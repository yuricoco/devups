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
    protected $entity = null;

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

    public function lazyloading2($listEntity, $classname = "") {

        return array('success' => true, // pour le restservice
            'classname' => strtolower($classname),
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
            case "get":
                $this->currentqb->andwhere($attr, ">=", $value);
                break;
            case "let":
                $this->currentqb->andwhere($attr, "<=", $value);
                break;
            case "lkr":
                $this->currentqb->andwhere($attr)->like_($value);
                break;
            case "lkl":
                $this->currentqb->andwhere($attr)->_like($value);
                break;
            case "btw":
                // todo : add constraint of integrity
                $btw = explode('_', $value);
                $this->currentqb->where($attr)->between($btw[0], $btw[1]);
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

            if(!$value)
                continue;

            $attr = explode(":", $key);
            $join = explode(".", $attr[0]);
            if (isset($join[1])) {
                $this->filterswicher($attr[1], $attr[0], $value);
            } else if ($this->currentqb->hasrelation && isset($attr[1]))
                $this->filterswicher($attr[1], strtolower(get_class($entity)) . "." . $join[0], $value);
            elseif (isset($attr[1]))
                $this->filterswicher($attr[1], $join[0], $value);
//            else
//                $this->filterswicher("", $join[0], $value);

        }
        return $this->currentqb;
    }

    public static function initlazyloading(\stdClass $entity, $next = 0, $per_page = 10, \QueryBuilder $qbcustom = null, $order = ""){
        return (new Controller())->lazyloading($entity, $next, $per_page, $qbcustom, $order);
    }

    const maxpagination = 12;

    /***
     * @param stdClass $entity the instance of the entity
     * @param int $next the page to print within the datatable by default it's 0
     * @param int $per_page the number of element per page
     * @param QueryBuilder|null $qbcustom if the developer want to customise the request
     * @param string $order
     * @return array
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

            $nb_element = $qbcustom->__countEl(false, false); //false
        } else {

            if (Request::get("dfilters")) {
                $qbcustom = $this->filter($entity, $qb);
                $nb_element = $qbcustom->__countEl(false, true);
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

        $paginationcustom = [];
        if($pagination >= self::maxpagination){
            $middle = intval($pagination / 2);
            $paginationcustom['firsts'] = [1, 2, 3];
            $paginationcustom['lasts'] = [$pagination - 2, $pagination - 1, $pagination];

            if($page > self::maxpagination / 2){

                $paginationcustom['middleleft'] = intval($pagination / 4);
                //$paginationcustom['firsts'] = [$page, 1 + $page + 1, 2 + $page + 2];

                if($page + 3 >= $pagination){
                    $paginationcustom['middleleft'] = intval($pagination / 4);
                    $paginationcustom['lasts'] = [];
                    $paginationcustom['middles'] = [$pagination - 5, $pagination - 4, $pagination - 3, $pagination - 2, $pagination - 1, $pagination];
//                else{
//                    $paginationcustom['middles'][] = $middle + $page + 2;
//                    $paginationcustom['middles'][] = $middle + $page + 3;
//                    $paginationcustom['middles'][] = $middle + $page + 4;
                }else{
                    $paginationcustom['middleright'] = intval($pagination * 3 / 4);
                    $paginationcustom['middles'] = [$page - 1, $page, $page + 1];
                }
                //= [$page, $page + 1, $page + 2];
            }else{

                $paginationcustom['middles'] = [$middle - 1, $middle, $middle + 1];
                $paginationcustom['middleright'] = intval($pagination * 3 / 4);
                $paginationcustom['middleleft'] = intval($pagination / 4);

                if( $page > 3 && $page < 8){
                    $paginationcustom['firsts'] = [1, 2, 3, 4, 5, 6, 7];
                }

            }
        }

        return array('success' => true, // pour le restservice
            //'sqlquery' => $qbcustom->getSqlQuery(),
            'classname' => $classname,
            'listEntity' => $listEntity,
            'nb_element' => (int) $nb_element,
            'per_page' => $per_page,
            'pagination' => $pagination,
            'paginationcustom' => $paginationcustom,
            'current_page' => $page,
            'next' => $next + 1,
            'previous' => (int) $page - 1,
            'remain' => (int) $remain,
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
    public function form_generat($object, $data = null, $entityform = null, $deeper = false) {
        return $this->form_fillingentity($object, $data, $entityform, $deeper);
    }

    /**
     * @param $object
     * @param null $data
     * @param null $entityform
     * @param bool $deeper
     * @return mixed
     */
    public function form_fillingentity($object, $data = null, $entityform = null, $deeper = false) {
        if (!is_object($object))
            throw new InvalidArgumentException('$object must be an object.');

        if(!$data)
            return $object->__show($deeper);

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
     * @throws ReflectionException
     */
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

        //Genesis::json_encode($_POST["dvups_form"]);

        foreach ($entitycore->field as $key => $value) {
            foreach ($_ENTITY_FORM as $key_form => $value_form) {

                if ($key_form == $key) {

//                    if(!is_string($value["setter"]))
//                        continue;
                    if(!isset($value["setter"]))
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
                        }
                        elseif($error = call_user_func(array($object, $currentfieldsetter), $toadd))
                            $this->error[$key] = $error;

                    }
                    else
                        if (isset($value['options']) && !isset($value['arrayoptions']) && class_exists($key)) {// && is_object ($value['options'][0])
                            $reflect = new ReflectionClass($key);
                            $value2 = $reflect->newInstance();

                            if (is_array($value['options']) && isset($_ENTITY_FORM[$key])) {

                                if(!is_numeric($_ENTITY_FORM[$key])){
                                    $value2->setId(null);
                                    continue;
                                }

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
                        }
                        else {

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


    /**
     * @param $object
     * @param $jsonform
     * @param bool $deeper
     * @return null
     */
    public function hydrateWithJson($object, $jsonform, $deeper= false)
    {

        if ($object->getId()) {
            $object = $object->__show($deeper);
        }

        $this->entity = $object;

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

        if(is_array($value)){
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

    /**
     * @param $object
     * @param $jsonform
     * @param bool $deeper
     * @return null
     */
    public function hydrateWithFormData($object, $postdata, $deeper= false)
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

            if (!preg_match_all("/$classname"."_/", $key)){
                //var_dump($key);
                continue;
            }
                //continue;

            $field = str_replace($classname."_", "", $key);
            $meta = explode(":", $field);

            $imbricate = explode(">", $meta[0]);

            $this->hydrateEntity($field, $value, $meta, $imbricate);

            unset($_POST[$key]);

        }

        return $this->entity;

    }


    public static function renderController($view, $resultCtrl) {

        extract($resultCtrl);
        include __DIR__ . "/../../" . $view;
    }

    protected $entitytarget = "";
    protected $datatablemodel = [];
    protected $title = "View Title";
    public static $cssfiles = [];
    public static $jsscript = "";
    public static $jsfiles = [];

    public function listView($next = 1, $per_page = 10)
    {



    }

    public function renderListView($datatablehtml, $return = false, $lazyloading = [], $datatablemodel = "") {

        if($return)
            return array('success' => true, // pour le restservice
                'title' => $this->title, // pour le web service
                'entity' => $this->entitytarget, // pour le web service
                'datatablehtml' => $datatablehtml, // pour le web service
                'lazyloading' => $lazyloading, // pour le web service
                'datatablemodel' => $datatablemodel, // pour le web service
                'detail' => '');

        Genesis::renderView('default.index',
            array('success' => true, // pour le restservice
                'title' => $this->title, // pour le web service
                'entity' => $this->entitytarget, // pour le web service
                'datatablehtml' => $datatablehtml,
                'detail' => '')
        );

    }

    public function renderDetailView($datatablehtml, $return = false, $datatablemodel = "") {

        if($return)
            return array('success' => true, // pour le restservice
                'title' => $this->title, // pour le web service
                'entity' => $this->entitytarget, // pour le web service
                'datatabledetailhtml' => $datatablehtml, // pour le web service
                'datatablemodel' => $datatablemodel, // pour le web service
                'detail' => '');

        Genesis::renderView('default.detail',
            array('success' => true, // pour le restservice
                'title' => $this->title, // pour le web service
                'entity' => $this->entitytarget, // pour le web service
                'datatabledetailhtml' => $datatablehtml,
                'detail' => '')
        );

    }

}
