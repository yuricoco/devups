<?php

namespace dclass\devups\Controller;

use Genesis as g;
use Philo\Blade\Blade;

/**
 * class Controller 1.0
 *
 * @author yuri coco
 */
abstract class Controller
{

    public static $sidebar = true;
    protected $error = [];
    protected $error_exist = false;
    protected $entity = null;
    public $indexView = "default.index";


    /**
     * @return $this
     * @throws \ReflectionException
     */
    public static function i()
    {
        $reflection = new \ReflectionClass(get_called_class());
        return $reflection->newInstance();
    }

    /**
     *
     * @param type $resultCtrl controller method
     */
    public static function renderTemplate($view, $data)
    {
        g::render($view, $data);
    }

    /**
     * 11/11/2017
     *
     * @param \stdClass $Dao
     * @param int $par_page
     * @param type $next
     * @return type
     */
    public static function lastpersistance($entity)
    {
        $classname = strtolower(get_class($entity));

        return array('success' => true, // pour le restservice
            'classname' => $classname,
            'listEntity' => [$entity],
            'detail' => '');
    }

    /**
     * Hydrate l'entité passé en parametre sur la base de la variable post ou dans le cas des requete
     * asynchrone, d'une chaine formater en json ou alors les arrays.
     *
     * @example $jsondata as \Array dans le cas de la persistance d'une
     * entité imbriqué dans celle courante
     *
     * @param stdClass $object l'instance de l'entité à hydrater
     * @param Mixed ( String or Array ) $jsondata optionnel
     * @return type
     * @throws InvalidArgumentException
     */
    public function form_generat($object, $data = null, $entityform = null, $deeper = false)
    {
        return $this->form_fillingentity($object, $data, $entityform, $deeper);
    }

    /**
     * @param $object
     * @param null $data
     * @param null $entityform
     * @param bool $deeper
     * @return mixed
     */
    public function form_fillingentity($object, $data = null, $entityform = null, $deeper = false)
    {
        $this->error = [];
        if (!is_object($object))
            throw new \InvalidArgumentException('$object must be an object.');

        if (!$data) {
            if (isset($_FILES[strtolower(get_class($object)) . '_form']))
                $data = $_FILES[strtolower(get_class($object)) . '_form'];
            else
                return $object->__show($deeper);
        }

        global $_ENTITY_FORM;
        $_ENTITY_FORM = $data;

        if ($object->getId()) {
            $object = $object->__show($deeper);
        }

//            if($jsondata){
//                $object_array = Controller::formWithJson ($object, $jsondata, $change_collection_adresse);
//            }else{
        $this->entity = $object;

        return $this->formWithPost($object, $entityform);
//            }

    }

    /**
     * @param $object
     * @param $entityform
     * @return mixed
     * @throws \ReflectionException
     */
    private function formWithPost($object, $entityform)
    {
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
            $entitycore = $entityform::formBuilder($object);
        else {
            $entitycore = new \stdClass();
            $entitycore->field = json_decode($_POST["dvups_form"][strtolower(get_class($object))], true);
        }

        //Genesis::json_encode($_POST["dvups_form"]);

        foreach ($entitycore->field as $key => $value) {

            if (isset($value["filetype"])) {

                if (!method_exists($object, "upload" . ucfirst($key)))
                    $this->error[$key] = " You may create method " . "upload" . ucfirst($key) . " in entity. ";
                else if ($error = call_user_func(array($object, "upload" . ucfirst($key))))
                    $this->error[$key] = $error;

                continue;
            }

            foreach ($_ENTITY_FORM as $key_form => $value_form) {

                if ($key_form == $key) {

//                    if(!is_string($value["setter"]))
//                        continue;
                    if (!isset($value["setter"]))
                        $value["setter"] = $key;

                    if (isset($value["persist"]) && $value["persist"] == false) {
                        continue;
                    }

                    $currentfieldsetter = 'set' . ucfirst($value["setter"]);

                    if (isset($value['values']) || isset($value["checker"])) {

                        if(!class_exists($key)){

                            if (!method_exists($object, $currentfieldsetter)) {
                                $this->error[$key] = " You may create method " . $currentfieldsetter . " in entity. ";
                            } elseif ($error = call_user_func(array($object, $currentfieldsetter), implode(",", $_ENTITY_FORM[$key])))
                                $this->error[$key] = $error;

                            continue;
                        }

                        $toadd = array_diff($_ENTITY_FORM[$key], $value["values"]);
                        $todrop = array_diff($value["values"],$_ENTITY_FORM[$key]);

                        //dv_dump($toadd, $todrop);

                        $_ENTITY_COLLECTION[] = [
                            'owner' => $object->getId()
                        ];

                        $collection = [];
                        $oldselection = [];

                        // if ($_ENTITY_FORM[$key]) {
                        if ($toadd) {
                            // foreach ($_ENTITY_FORM[$key] as $val) {
                            foreach ($toadd as $val) {

                                $reflect = new \ReflectionClass($key);
                                $value2 = $reflect->newInstance();
                                $value2->setId($val);
                                $collection[] = $value2;
                            }
                            $_ENTITY_COLLECTION[]["selection"] = true;
                        } else {
                            $_ENTITY_COLLECTION[]["selection"] = false;
                        }

                        if ($todrop) {

                            foreach ($todrop as $val) {

                                $reflect = new \ReflectionClass($key);
                                $value2 = $reflect->newInstance();
                                $value2->setId($val);
                                $oldselection[] = $value2;
                            }
                        }
// else {
//
//                            foreach ($value['values'] as $ky => $val) {
//
//                                $reflect = new \ReflectionClass($key);
//                                $value2 = $reflect->newInstance();
//                                $value2->setId($ky);
//                                $oldselection[] = $value2;
//                            }
//                        }
//
//                        $intersect = \EntityCollection::intersection($oldselection, $collection);

                        //$toadd = \EntityCollection::diff($collection, $intersect);
                        // $todrop = \EntityCollection::diff($oldselection, $intersect);

                        if ($collection)
                            $_ENTITY_COLLECTION[]["toadd"] = true;

                        if ($todrop) {
                            $_ENTITY_COLLECTION[]["todrop"] = $oldselection;//array_values($todrop);
                        }

                        if (!method_exists($object, $currentfieldsetter)) {
                            $this->error[$key] = " You may create method " . $currentfieldsetter . " in entity. ";
                        } elseif ($error = call_user_func(array($object, $currentfieldsetter), $collection))
                            $this->error[$key] = $error;

                    } else
                        if (isset($value['options']) && !isset($value['arrayoptions']) && class_exists($key)) {// && is_object ($value['options'][0])
                            $reflect = new \ReflectionClass($key);
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


    /**
     * @param $object
     * @param $jsonform
     * @param bool $deeper
     * @return null
     */
    public function hydrateWithJson($object, $jsonform, $deeper = false)
    {

        if ($object->getId()) {
            $object = $object->__show($deeper);
        }

        $this->entity = $object;

        foreach ($jsonform as $field => $value) {

            if (!is_string($value) && !is_numeric($value))
                continue;

            $meta = explode(":", $field);

            $imbricate = explode(".", $meta[0]);

            $this->hydrateEntity($field, $value, $meta, $imbricate);

        }

        return $this->entity;

    }

    private function hydrateEntity($field, $value, $meta, $imbricate)
    {
        if (isset($meta[1]))
            $setter = "set" . ucfirst($meta[1]);
        else
            $setter = "set" . ucfirst($meta[0]);

        if (is_array($value)) {
            dv_dump($value);
            $setter = "add" . ucfirst($meta[0]);
            if (!method_exists($this->entity, $setter)) {
                $this->error[$field] = " You may create method " . $setter . " in entity. ";
            } elseif ($error = call_user_func(array($this->entity, $setter), $value))
                $this->error[$field] = $error;
        }

        // $imbricate[0]: represent the name of the attribute of the imbricated entity in its owner
        // $imbricate[1]: represent the name of the attribute of the imbricated entity. by default it's id
        else if (isset($imbricate[1])) {
            if ($imbricate[1] !== "id") // if the default value have changed to may be other_name, then it will call a method as setOther_name() in the owner class
                $setter = "set" . ucfirst($imbricate[1]);
            else // if the default value is still id, then it will call a method setAttributename() in the owner class
                $setter = "set" . ucfirst($imbricate[0]);

            $reflect = new \ReflectionClass($imbricate[0]);
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

    /**
     * @param $object
     * @param $jsonform
     * @param bool $deeper
     * @return null
     */
    public function hydrateWithFormData($object, $postdata, $deeper = false)
    {
        $classname = strtolower(get_class($object));

        $this->entity = $object;
        //$object = $this->form_fillingentity($object, $jsonform);

        if ($object->getId()) {
            $object = $object->__show($deeper);
        }

        $this->entity = $object;

        //$fields = json_decode($jsonform, true);

        foreach ($postdata as $key => $value) {

            if (!preg_match_all("/$classname" . "_/", $key)) {
                //var_dump($key);
                continue;
            }
            //continue;

            $field = str_replace($classname . "_", "", $key);
            $meta = explode(":", $field);

            $imbricate = explode(">", $meta[0]);

            $this->hydrateEntity($field, $value, $meta, $imbricate);

            unset($_POST[$key]);

        }

        return $this->entity;

    }


    public static function renderController($view, $resultCtrl)
    {

        extract($resultCtrl);
        include __DIR__ . "/../../" . $view;
    }

    protected $entitytarget = "";
    protected $datatablemodel = [];
    protected $title = "View Title";
    public static $cssfiles = [];
    public static $jsscript = "";
    public static $jsfiles = [];

    public abstract function listView($next = 1, $per_page = 10);

    public function renderListView($data = [])
    {

        if (!$data) {
            foreach ($this as $key => $value) {
                \Response::set($key, $value);
            }
        }

        \Genesis::renderView($this->indexView,
            \Response::$data + $data
        );
        die;
    }

    public function renderDetailView($datatablehtml, $return = false, $datatablemodel = "")
    {

        if ($return)
            return array('success' => true, // pour le restservice
                'title' => $this->title, // pour le web service
                'entity' => $this->entitytarget, // pour le web service
                'datatabledetailhtml' => $datatablehtml, // pour le web service
                'datatablemodel' => $datatablemodel, // pour le web service
                'detail' => '');

        \Genesis::renderView('default.detail',
            array('success' => true, // pour le restservice
                'title' => $this->title, // pour le web service
                'entity' => $this->entitytarget, // pour le web service
                'datatabledetailhtml' => $datatablehtml,
                'detail' => '')
        );

    }

    public static function renderBladeView($view, $data = [], $action = "list", $redirect = false)
    {

        global $path;
        global $views;

        if ($redirect && $data['success']) {
            header('location: index.php?path=' . $path[ENTITY] . '/' . $data['redirect']);
        }

        if ($data) {
            $data["__navigation"] = "";//Genesis::top_action($action, $path[ENTITY]);
        }

        $blade = new Blade([$views, admin_dir . 'views'], ROOT . "cache/views");
        echo $blade->view()->make($view, $data)->render();
    }

    public static function render($view, $data = [])
    {

        $compilate = [];
        if ($data) {
            if (key_exists(0, $data)) {
                foreach ($data as $el) {
                    foreach ($el as $key => $value) {
                        $compilate[$key] = $value;
                    }
                }
            } else {
                $compilate = $data;
            }
        }

        $blade = new Blade([web_dir . "views", admin_dir . 'views'], ROOT . "cache/views");
        echo $blade->view()->make($view, $compilate)->render();
        //die;
    }

    public static function renderView($view, $data = [], $redirect = false)
    {

        global $viewdir, $moduledata;

        if ($redirect && isset($data['redirect'])) {
            header('location: ' . $data['redirect']);
        }

        $data["moduledata"] = $moduledata;//Genesis::top_action($action, $classroot);

        $blade = new Blade($viewdir, ROOT . "cache/views");
        echo $blade->view()->make($view, $data)->render();
    }

}
