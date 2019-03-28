<?php

use Genesis as g;

/**
 * class Controller 1.0
 *
 * @author yuri coco
 */
class Controller {

    protected $error = [];
    protected $error_exist = false;

    /**
     * @return $this
     * @throws ReflectionException
     */
    public static function i() {
        $reflection = new ReflectionClass(get_called_class());
        return $reflection->newInstance();
    }

    /**
     *
     * @param type $resultCtrl controller method
     */
    public static function renderTemplate($view, $data) {
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
    public static function lastpersistance($entity) {
        $classname = strtolower(get_class($entity));

        return array('success' => true, // pour le restservice
            'classname' => $classname,
            'listEntity' => [$entity],
            'detail' => '');
    }

    public function lazyloading2($listEntity) {

        return array('success' => true, // pour le restservice
            'listEntity' => $listEntity,
            'nb_element' => count($listEntity),
            'per_page' => 100,
            'pagination' => 1,
            'current_page' => 1,
            'next' => 1,
            'previous' => 0,
            'remain' => 1,
            'detail' => '');
    }

    /**
     * @var \QueryBuilder $currentqb
     */
    private $currentqb;

    private function filterswicher($opt, $attr, $value)
    {
        switch ($opt) {
            case "eq":
                $this->currentqb->andwhere($attr, "=", $value);
                break;
            case "gt":
                $this->currentqb->andwhere($attr, ">", $value);
                break;
            case "lt":
                $this->currentqb->andwhere($attr, "<", $value);
                break;
            default:
                $this->currentqb->andwhere($attr)->like($value);
                break;
        }

    }

    private function filter(\stdClass $entity, \QueryBuilder $qb)
    {
        $this->currentqb = $qb;
        $getparam = Request::$uri_get_param;
        foreach ($getparam as $key => $value) {
            $attr = explode(":", $key);
            $join = explode("-", $attr[0]);
            if (isset($join[1])) {
                $this->filterswicher($attr[1], $join[0] . "." . $join[1], $value);
            } else if ($this->currentqb->hasrelation && isset($attr[1]))
                $this->filterswicher($attr[1], get_class($entity) . "." . $join[0], $value);
            elseif (isset($attr[1]))
                $this->filterswicher($attr[1], $join[0], $value);

        }
        return $this->currentqb;
    }

    private function filterold(\stdClass $entity, \QueryBuilder $qb) {

        $fieldarray = explode(",", Request::get('dfilters'));

        foreach ($fieldarray as $fieldwithtype) {
            $arrayfieldtype = explode(":", $fieldwithtype);

            if (Request::get($arrayfieldtype[0])) {
                if ($arrayfieldtype[1] == "attr") {
                    if($qb->hasrelation)
                        $qb->andwhere(get_class($entity) .".".$arrayfieldtype[0])->like(Request::get($arrayfieldtype[0]));
                    else
                        $qb->andwhere($arrayfieldtype[0])->like(Request::get($arrayfieldtype[0]));
                } elseif ($arrayfieldtype[1] == "join") {

                    $join = explode("-", $arrayfieldtype[0]);

                    if($join[1] == "id"){
                        $qb->andwhere($join[0] . "_id", "=", Request::get($arrayfieldtype[0]));
                    }else{
                        $qb->andwhere($join[0] . "_id")
                            ->in(
                                $qb->addselect("id", new $join[0], false)
                                    ->where($join[1])
                                    ->like(Request::get($arrayfieldtype[0]))
                                    ->close()
                            );
                    }

                }
//                elseif ($_GET[$arrayfieldtype[1]] == "collect") {
//
//                    $join = explode("-", $arrayfieldtype[0]);
//                    $qb->andwhere("id")->in($qb->addselect("id", new $join[0])->where($column)->like($value)->close());
//                }
            }
        }

        return $qb;
    }

    public static function initlazyloading(\stdClass $entity, $next = 0, $per_page = 10, \QueryBuilder $qbcustom = null, $order = ""){
        return (new Controller())->lazyloading($entity, $next, $per_page, $qbcustom, $order);
    }
    /**
     *
     * @param \stdClass $entity
     * @param type $next
     * @param type $per_page
     * @param \QueryBuilder $qbcustom
     * @return type
     */
    public function lazyloading(\stdClass $entity, $next = 0, $per_page = 10, \QueryBuilder $qbcustom = null, $order = "") {//
        $remain = true;
        $qb = new QueryBuilder($entity);
        $classname = strtolower(get_class($entity));
        if (Request::get("next") && Request::get('per_page'))
            extract(Request::$uri_get_param);

        if(Request::get('order')){
            $order = Request::get('order');
            if($entity->inrelation())
                $order = $classname.".".$order;//$_GET['order'];
        }elseif(Request::get('orderjoin'))
            $order = strtolower(Request::get('orderjoin'));


        if ($qbcustom != null) {

            if (Request::get("dfilters"))
                $qbcustom = $this->filter($entity, $qbcustom);

            $nb_element = $qbcustom->__countEl(false);
        } else {

            if (Request::get("dfilters")) {
                $qbcustom = $this->filter($entity, $qb);
                $nb_element = $qbcustom->__countEl(false);
            } else {
                $nb_element = $qb->selectcount()->__countEl(false);
            }
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

                if ($order) {
                    $listEntity = $qbcustom->orderby($order)->limit($next, $per_page)->__getAll();
                } else
                    $listEntity = $qbcustom->limit($next, $per_page)->__getAll();

            } else {
                if ($order)
                    $listEntity = $qb->select()->orderby($order)->limit($next, $per_page)->__getAll();
                else
                    $listEntity = $qb->select()->limit($next, $per_page)->__getAll();

            }

            if ($page == $pagination) {
                $next = $page - 1;
                $remain = false;
            } else {
                $next = $page;
            }
        } else {
            $pagination = 0;
            $page = 1;
            $remain = 0;
            if($qbcustom != null){
                if ($order) {
                    $listEntity = $qbcustom->orderby($order)->__getAll();
                } else {
                    $listEntity = $qbcustom->__getAll();
                }
            }else{
                if ($order) {
                    $listEntity = $qb->select()->orderby($order)->__getAll();
                } else {
                    $listEntity = $qb->select()->__getAll();
                }
            }
            $per_page = $nb_element;
        }

        return array('success' => true, // pour le restservice
            'classname' => $classname,
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
    public function form_generat($object, $data = null, $entityform = null) {
        return $this->form_fillingentity($object, $data, $entityform);
    }

    public function form_fillingentity($object, $data = null, $entityform = null) {
        if (!is_object($object))
            throw new InvalidArgumentException('$object must be an object.');

        if(!$data)
            return $object;

        global $_ENTITY_FORM;
        $_ENTITY_FORM = $data;

        if ($object->getId()) {
            $object = $object->__show(false);
        }

//            if($jsondata){
//                $object_array = Controller::formWithJson ($object, $jsondata, $change_collection_adresse);
//            }else{
        return $this->formWithPost($object, $entityform);
//            }

    }

    private function formWithPost($object, $entityform) {
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
            $entitycore = new stdClass();
            $entitycore->field = json_decode($_POST["dvups_form"][strtolower(get_class($object))], true);
        }

        foreach ($entitycore->field as $key => $value) {
            foreach ($_ENTITY_FORM as $key_form => $value_form) {

                if ($key_form == $key) {

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
                        }
                        elseif($error = call_user_func(array($object, $currentfieldsetter), $toadd))
                            $this->error[$key] = $error;

                    } else if (isset($value['options']) && !isset($value['arrayoptions']) && class_exists($key)) {// && is_object ($value['options'][0])
                        $reflect = new ReflectionClass($key);
                        $value2 = $reflect->newInstance();

                        if ($value['options'] && isset($_ENTITY_FORM[$key])) {
                            $value2->setId($_ENTITY_FORM[$key]);
                            if (!method_exists($object, $currentfieldsetter)) {
                                $this->error[$key] = " You may create method " . $currentfieldsetter . " in entity ";
                            }
                            elseif($error = call_user_func(array($object, $currentfieldsetter), $value2->__show(false)))
                                $this->error[$key] = $error;
                        } else {
                            if (!method_exists($object, $currentfieldsetter)) {
                                $this->error[$key] = " You may create method " . $currentfieldsetter . " in entity. ";
                            }
                            elseif($error = call_user_func(array($object, $currentfieldsetter), $value2))
                                $this->error[$key] = $error;
                        }
                    } else {

                        if (isset($_ENTITY_FORM[$key])){
                            if(isset($value["type"]) && $value["type"] == "injection"){
//                                $result = call_user_func(array($key."Controller", "createAction"));
//                                if($error = call_user_func(array($object, $currentfieldsetter), $result[$key]))
//                                    $this->error[$key] = $error;
                            }
                            elseif (!method_exists($object, $currentfieldsetter)) {
                                $this->error[$key] = " You may create method " . $currentfieldsetter . " in entity. ";
                            }
                            elseif($error = call_user_func(array($object, $currentfieldsetter), $_ENTITY_FORM[$key]))
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

    public static function renderController($view, $resultCtrl) {

        extract($resultCtrl);
        include __DIR__ . "/../../" . $view;
    }

}
