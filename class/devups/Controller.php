<?php

/**
 * class Controller 1.0
 *
 * @author yuri coco
 */
abstract class Controller extends DBAL {

    private $change_collection_adress;

    public function editImageAction($id) {
        
    }

    /**
     * 
     * @param type $resultCtrl controller method
     */
    public static function renderTemplate($resultCtrl) {
        extract($resultCtrl);
        include $template;
    }

    /**
     * 11/11/2017
     * 
     * @param \stdClass $Dao
     * @param int $par_page
     * @param type $next
     * @return type
     */
    public function lazyloading(\stdClass $entity, $next = 0, $per_page = 10, \QueryBuilder $qbcustom = null) {
        $remain = true;
        if (isset($_GET['next']) && isset($_GET['per_page']))
            extract($_GET);

        $qb = new QueryBuilder($entity);

        if ($qbcustom != null) {
            $nb_element = $qbcustom->__countEl(false);
        } else {
            $nb_element = $qb->selectcount()->__countEl(false);
        }


        if ($per_page != "all") {
            if (!($nb_element % $per_page)) {
                $pagination = $nb_element / $per_page;
            } else {
                $pagination = intval($nb_element / $per_page) + 1;
            }

            if ($next > 0) {
                $page = $next;
                $next = (intval($next) - 1) * $per_page;
            } else {
                $page = 1;
            }

            if ($qbcustom != null) {
                $listEntity = $qbcustom->limit($next, $per_page)->__getAll();
            } else {
                $listEntity = $qb->select()->limit($next, $per_page)->__getAll();
            }

            if ($page == $pagination) {
                $next = $page - 1;
                $remain = false;
            } else {
                $next = $page;
            }
        } else {
            if ($qbcustom != null) {
                $listEntity = $qbcustom->__getAll();
            } else {
                $listEntity = $qb->select()->__getAll();
            }
        }

        return array('success' => true, // pour le restservice
            'listEntity' => $listEntity,
            'nb_element' => $nb_element,
            'per_page' => $per_page,
            'pagination' => $pagination,
            'current_page' => $page,
            'next' => $next + 1,
            'previous' => $page - 1,
            'remain' => $remain,
            'detail' => '');
    }

    /**
     * 24/10/2016
     * 
     * @param \stdClass $Dao
     * @param int $par_page
     * @param type $next
     * @return type
     */
    public function scrollloading(\stdClass $entity, $next = 0, $per_page = 10, \QueryBuilder $qbcustom = null) {
        $remain = true;
        if (isset($_GET['next']) && isset($_GET['per_page']))
            extract($_GET);

        if ($next > 0) {
            $page = $next;
            $next = (intval($next) - 1) * $per_page;
        } else {
            $page = 1;
        }

        if ($qbcustom != null) {
            $listEntity = $qbcustom->limit($next, $per_page)->__getAll();
        } else {
            $qb = new QueryBuilder($entity);
            $listEntity = $qb->select()->limit($next, $per_page)->__getAll();
        }

        if (count($listEntity) < $per_page) {
            $next = $page - 1;
            $remain = false;
        } else {
            $next = $page;
        }

        return array('success' => true, // pour le restservice
            'listEntity' => $listEntity,
            'per_page' => $per_page,
            'current_page' => $page,
            'next' => $next + 1,
            'previous' => $page - 1,
            'remain' => $remain,
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
    public static function form_generat($object, $data = null, $entityform = null) {
        if (!is_object($object))
            throw new InvalidArgumentException('$object must be an object.');

        global $_ENTITY_FORM;
        $_ENTITY_FORM = $data;

        if ($object->getId()) {
            $dbal = new DBAL();
            $object = $dbal->findByIdDbal($object, false, true);
        }

//            if($jsondata){
//                $object_array = Controller::formWithJson ($object, $jsondata, $change_collection_adresse);
//            }else{
        $object_array = Controller::formWithPost($object, $entityform);
//            }
        return Bugmanager::cast((object) $object_array, get_class($object));
    }

    private static function formWithPost($object, $entityform) {
        global $_ENTITY_FORM;
        global $_ENTITY_COLLECTION;
        global $__controller_traitment;
        global $em;


        $classmetadata = $em->getClassMetadata("\\" . get_class($object));
        $fieldname = array_keys($classmetadata->fieldNames);
        $association = array_keys($classmetadata->associationMappings);

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
            $entitycore = new stdClass();
            $entitycore->field = $_SESSION["dvups_form"][strtolower(get_class($object))];
//            unset($_SESSION[strtolower(get_class($object))]);
        }

        $object_array = (array) $object;
        if (isset($object_array["dvfetched"])) {
            unset($object_array["dvfetched"]);
        }
        $key_value = [];
        $i = 0;
        $j = 0;
        foreach ($object_array as $key => $value) {
            if (is_object($value)) {
                $key_form = $association[$j];
                $key_value[$key_form] = $key;
                $j++;
            } elseif (is_array($value)) {
                $key_form = strtolower(get_class($value[0]));

                if (!isset($_ENTITY_FORM[$key_form]))
                    $_ENTITY_FORM[$key_form] = [];

                $key_value[$key_form] = $key;
            } else {
                $key_form = $fieldname[$i];
                $key_value[$key_form] = $key;
                $i++;
            }
        }

        foreach ($entitycore->field as $key => $value) {
            foreach ($_ENTITY_FORM as $key_form => $value_form) {

                if ($key_form == $key) {

                    if (isset($value['values'])) {


                        $_ENTITY_COLLECTION[] = [
                            'owner' => $object->getId()
                        ];

                        $collection = [];
                        $oldselection = [];

                        if ($value_form) {
                            foreach ($value_form as $val) {

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

                        $object_array[$key_value[$key]] = $toadd;
                    } else if (isset($value['options']) && !isset($value['arrayoptions']) && class_exists($key)) {// && is_object ($value['options'][0])
                        $reflect = new ReflectionClass($key);
                        $value2 = $reflect->newInstance();

                        if ($value['options']) {
                            $value2->setId($value_form);
                            $object_array[$key_value[$key]] = $value2;
                        } else {
                            $object_array[$key_value[$key]] = $value2;
                        }
                    } else {
                        if (isset($key_value[$key]))
                            $object_array[$key_value[$key]] = $value_form;
                    }
                }
            }
        }

        return $object_array;
    }

    public static function renderController($view, $resultCtrl) {

        extract($resultCtrl);
        include __DIR__ . "/../../" . $view;
    }

//        public abstract function _new() ;
//        public abstract function _edit($id) ;

    public function validemail($email) {
        return ereg("^([a-zA-Z0-9_\.-]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$", $email);
    }

}
