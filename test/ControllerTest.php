<?php


class ControllerTest
{

    private $entity;

    public function form_fillingentity($object, $data, $deeper = false)
    {
        if (!is_object($object))
            throw new InvalidArgumentException('$object must be an object.');

//        if (!$data)
//            return $object->__show($deeper);

        global $_ENTITY_FORM;
        $_ENTITY_FORM = $data;

        if ($object->getId()) {
            $object = $object->__show($deeper);
        }
        $this->entity = $object;
//        if ($jsondata) {
//            return $this->formWithJson($object, $entityform);
//        } else {
//            return $this->formWithPost($object, $entityform);
//        }

    }

    public function hydrateWithJson($object, $jsonform)
    {

        $this->form_fillingentity($object, $jsonform);
        //$fields = json_decode($jsonform, true);

        foreach ($jsonform as $field => $value) {

            if(!is_string($value) && !is_numeric($value) )
                continue;

            $meta = explode(":", $field);

            $imbricate = explode(".", $meta[0]);

            $this->hydrateEntity($field, $value, $meta, $imbricate);

        }

        return $this->entity;

    }

    private function hydrateEntity($field, $value, $meta, $imbricate){
        if (isset($meta[1]))
            $setter = "set" . ucfirst($meta[1]);
        else
            $setter = "set" . ucfirst($meta[0]);

        // $imbricate[0]: represent the name of the attribute of the imbricated entity in its owner
        // $imbricate[1]: represent the name of the attribute of the imbricated entity. by default it's id
        if (isset($imbricate[1])) {
            if ($imbricate[1] !== "id") // if the default value have changed to may be other_name, then it will call a method as setOther_name() in the owner class
                $setter = "set" . ucfirst($imbricate[1]);
            else // if the default value is still id, then it will call a method setAttributename() in the owner class
                $setter = "set" . ucfirst($imbricate[0]);

            $reflect = new ReflectionClass($imbricate[0]);
            $entityimbricate = $reflect->newInstance();
            if (!is_numeric($value)) {
                $entityimbricate->setId(null);
                return;
            }

            $entityimbricate->setId($value);
            if (!method_exists($this->entity, $setter)) {
                $this->error[$field] = " You may create method " . $setter . " in entity ";
            } elseif ($error = call_user_func(array($this->entity, $setter), $entityimbricate->__show(false)))
                $this->error[$field] = $error;

        } else {
            if (!method_exists($this->entity, $setter)) {
                $this->error[$field] = " You may create method " . $setter . " in entity. ";
            } elseif ($error = call_user_func(array($this->entity, $setter), $value))
                $this->error[$field] = $error;
        }
    }

    public function hydrateWithFormData($object, $jsonform, $deeper = false)
    {
        $classname = strtolower(get_class($object));

        $this->form_fillingentity($object, $jsonform, $deeper);

        //$fields = json_decode($jsonform, true);

        foreach ($jsonform as $field => $value) {
            $field = str_replace($classname."_", "", $field);
            $meta = explode(":", $field);

            $imbricate = explode(">", $meta[0]);

            $this->hydrateEntity($field, $value, $meta, $imbricate);

        }

        return $this->entity;

    }

    public function formWithPost($object, $entityform)
    {

        $this->form_fillingentity($object, $entityform);
        $object = $this->entity;
        global $_ENTITY_FORM;
        global $_ENTITY_COLLECTION;
        global $__controller_traitment;

        $__controller_traitment = true;
        $_ENTITY_COLLECTION = [];
        /**
         * dans le cas où la variable $_POST serait vide on met un element pour pouvoir traiter
         * les collections d'objet. ceci n'influence en rien l'hydratation des autres proprietés
         */
        $_ENTITY_FORM["devups_entitycollection"] = "empty";

        if ($entityform)
            $entitycore = $entityform::formBuilder($this->entity);
        else {
            $entitycore = new stdClass();
            $entitycore->field = json_decode($_POST["dvups_form"][strtolower(get_class($this->entity))], true);
        }

        //Genesis::json_encode($_POST["dvups_form"]);

        foreach ($entitycore->field as $key => $value) {
            foreach ($_ENTITY_FORM as $key_form => $value_form) {

                if ($key_form == $key) {

//                    if(!is_string($value["setter"]))
//                        continue;
                    if (!isset($value["setter"]))
                        $value["setter"] = $key;

                    $currentfieldsetter = 'set' . ucfirst($value["setter"]);

                    if (isset($value['values'])) {

                        $_ENTITY_COLLECTION[] = [
                            'owner' => $object->getId()
                        ];

                        $collection = [];
                        $oldselection = [];

                        if ($_ENTITY_FORM[$key]) {
                            foreach ($_ENTITY_FORM[$key] as $val) {

                                $reflect = new ReflectionClass($key);
                                $value2 = $reflect->newInstance();
                                $value2->setId($val);
                                $collection[] = $value2;
                            }
                            $_ENTITY_COLLECTION[]["selection"] = true;
                        } else {
                            $_ENTITY_COLLECTION[]["selection"] = false;
                        }

                        if (isset($value['values']['list'])) {

                            foreach ($value['values']['list'] as $ky => $val) {

                                $reflect = new ReflectionClass($key);
                                $value2 = $reflect->newInstance();
                                $value2->setId($ky);
                                $oldselection[] = $value2;
                            }
                        } else {

                            foreach ($value['values'] as $ky => $val) {

                                $reflect = new ReflectionClass($key);
                                $value2 = $reflect->newInstance();
                                $value2->setId($ky);
                                $oldselection[] = $value2;
                            }
                        }

                        $intersect = EntityCollection::intersection($oldselection, $collection);

                        $toadd = EntityCollection::diff($collection, $intersect);
                        $todrop = EntityCollection::diff($oldselection, $intersect);

                        if ($toadd)
                            $_ENTITY_COLLECTION[]["toadd"] = true;

                        if ($todrop) {
                            $_ENTITY_COLLECTION[]["todrop"] = array_values($todrop);
                        }

                        if (!method_exists($object, $currentfieldsetter)) {
                            $this->error[$key] = " You may create method " . $currentfieldsetter . " in entity. ";
                        } elseif ($error = call_user_func(array($object, $currentfieldsetter), $toadd))
                            $this->error[$key] = $error;

                    } else
                        if (isset($value['options']) && !isset($value['arrayoptions']) && class_exists($key)) {// && is_object ($value['options'][0])
                            $reflect = new ReflectionClass($key);
                            $value2 = $reflect->newInstance();

                            if (is_array($value['options']) && isset($_ENTITY_FORM[$key])) {

                                if (!is_numeric($_ENTITY_FORM[$key])) {
                                    $value2->setId(null);
                                    continue;
                                }

                                $value2->setId($_ENTITY_FORM[$key]);
                                if (!method_exists($object, $currentfieldsetter)) {
                                    $this->error[$key] = " You may create method " . $currentfieldsetter . " in entity ";
                                } elseif ($error = call_user_func(array($object, $currentfieldsetter), $value2->__show(false)))
                                    $this->error[$key] = $error;
                            } else {
                                if (!method_exists($object, $currentfieldsetter)) {
                                    $this->error[$key] = " You may create method " . $currentfieldsetter . " in entity. ";
                                } elseif ($error = call_user_func(array($object, $currentfieldsetter), $value2))
                                    $this->error[$key] = $error;
                            }
                        } else {

                            if (isset($_ENTITY_FORM[$key])) {
                                if (isset($value["type"]) && $value["type"] == "injection") {
//                                $result = call_user_func(array($key."Controller", "createAction"));
//                                if($error = call_user_func(array($object, $currentfieldsetter), $result[$key]))
//                                    $this->error[$key] = $error;
                                } elseif (!method_exists($object, $currentfieldsetter)) {
                                    $this->error[$key] = " You may create method " . $currentfieldsetter . " in entity. ";
                                } elseif ($error = call_user_func(array($object, $currentfieldsetter), $_ENTITY_FORM[$key]))
                                    $this->error[$key] = $error;
                            }

                        }
                }

            }
        }

//        if($this->error)
//            foreach ($this->error as $error){
//                if($error){
//                    $this->error_exist = true;
//                    break;
//                }
//            }

        return $object;
    }

}