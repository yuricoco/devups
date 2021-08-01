<?php

namespace dclass\devups\Controller;

use dclass\devups\Datatable\Lazyloading;
use Genesis as g;
use Philo\Blade\Blade;
use phpDocumentor\Reflection\Types\Self_;
use ReflectionClass;
use Request;

/**
 * class Controller 1.0
 *
 * @author yuri coco
 */
class Controller
{

    public static $sidebar = true;
    public static $tablename = "";
    public static $formname = "";
    public static $ctrlname = "";
    public static $entityname = "";

    protected $error = [];
    protected $nopersist = [];
    protected $error_exist = false;
    protected $entity = null;
    public $indexView = "default.index";

    public function __construct()
    {

        self::$classname = ucfirst(self::$entityname);
        self::$tablename = self::$classname . "Table";
        self::$formname = self::$classname . "Form";
        self::$ctrlname = self::$classname . "Ctrl";

    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public static function i()
    {
        $reflection = new \ReflectionClass(get_called_class());
        return $reflection->newInstance();
    }

    public static $eventListners = [
        "after" => [
            "create" => []
        ]
    ];

    public static function addEventListener($position, $action, $classname)
    {
        if (isset(self::$eventListners[$position][$action][$classname]))
            self::$eventListners[$position][$action][$classname][] = $classname;
        else
            self::$eventListners[$position][$action][] = $classname;
    }

    public static function addEventListenerAfterCreate($classname, $method)
    {
        $classname = strtolower($classname);
        $eventcollector = self::$eventListners["after"]["create"];
        if (isset($eventcollector[$classname]))
            $eventcollector[$classname][] = $method;
        else
            $eventcollector[$classname] = [$method];

        self::$eventListners["after"]["create"] = $eventcollector;

    }

    public static function getclassname()
    {

        $classname = str_replace('-', '_', Request::get('dclass'));
        $dventity = \Dvups_entity::getbyattribut("this.name", $classname);
        if (!$dventity->getId()) {
            echo json_encode([
                "success" => false,
                "message" => "entity " . $classname . " not found",
                "available" => \Dvups_entity::all(),
            ]);
            die;
        }
        return $classname;
    }

    public function createCore()
    {
        $classname = self::getclassname();
        $newclass = ucfirst($classname);
        $entity = new $newclass;

        $rawdata = \Request::raw();
        if (is_null($rawdata)) {
            if (!isset($_POST[$classname . "_form"]))
                return array('success' => false,
                    $classname => $entity,
                    'detail' => $classname . "_form is missing in your form_data. ex: entity_form[attribute] ");
            $entity = $this->form_fillingentity($entity, $_POST[$classname . "_form"]);
        } else
            $entity = $this->hydrateWithJson($entity, $rawdata[$classname]);

        if (isset($_FILES[$classname . "_form"])) {
            foreach ($_FILES[$classname . "_form"]['name'] as $key_form => $value_form) {
                self::addEventListenerAfterCreate(get_class($this->entity), 'upload' . ucfirst($key_form));
            }
        }

        if ($this->error) {
            return array('success' => false,
                $classname => $entity,
                'error' => $this->error);
        }

        $id = $entity->__insert();

        return array('success' => true,
            $classname => $entity,
            'detail' => '');

    }

    public function uploadCore($id)
    {

        $classname = self::getclassname();
        $newclass = ucfirst($classname);
        $entity = $newclass::find($id, false);

        if (isset($_FILES[$classname . "_form"])) {
            foreach ($_FILES[$classname . "_form"]['name'] as $key_form => $value_form) {
                $method = 'upload' . ucfirst($key_form);
                $entity->{$method}();
            }
            return array('success' => true,
                $classname => $entity->__show(true),
                'detail' => 'file uploaded with success');
        }

        return array('success' => false,
            'detail' => 'no file founded');

    }

    public function updateCore($id)
    {

        $classname = self::getclassname();
        $newclass = ucfirst($classname);
        $entity = new $newclass($id);

        $rawdata = \Request::raw();
        if (is_null($rawdata)) {
            if (!isset($_POST[$classname . "_form"]))
                return array('success' => false,
                    $classname => $entity,
                    'detail' => $classname . "_form is missing in your form_data. ex: entity_form[attribute] ");
            $entity = $this->form_fillingentity($entity, $_POST[$classname . "_form"]);
        } else
            $entity = $this->hydrateWithJson($entity, $rawdata[$classname]);

//        if (isset($_FILES[$classname . "_form"])) {
//            foreach ($_FILES[$classname . "_form"]['name'] as $key_form => $value_form) {
//                self::addEventListenerAfterCreate(get_class($this->entity), 'upload' . ucfirst($key_form));
//            }
//        }

        if ($this->error) {
            return array('success' => false,
                $classname => $entity,
                'error' => $this->error);
        }

        $entity->__update();
        return array('success' => true,
            $classname => $entity,
            'detail' => '');

    }

    public function deleteCore($id)
    {

        $classname = self::getclassname();
        $newclass = ucfirst($classname);
        $newclass::find($id, false)->__delete();

        return array('success' => true,
            'detail' => '');

    }

    public function detailCore($id)
    {

        $classname = self::getclassname();
        $newclass = ucfirst($classname);

        return array('success' => true,
            $classname => $newclass::find($id, false),
            'detail' => '');

    }


    public function ll()
    {

        $classname = str_replace('-', '_', Request::get('dclass'));
        $dventity = \Dvups_entity::getbyattribut("this.name", $classname);
        if (!$dventity->getId())
            return [
                "success" => false,
                "message" => "entity " . $classname . " not found",
                "available" => \Dvups_entity::all(),
            ];

        $newclass = ucfirst($classname);
        $entity = new $newclass;

        $ll = new Lazyloading();
        $ll->lazyloading($entity);
        return $ll;

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
    public function form_generat($object, $data = null, $deeper = false)
    {
        return $this->form_fillingentity($object, $data, $deeper);
    }

    /**
     * @param $object
     * @param null $data
     * @param null $entityform
     * @param bool $deeper
     * @return mixed
     */
    public function form_fillingentity($object, $data = null, $deeper = false)
    {
        $this->error = [];
        if (!is_object($object))
            throw new \InvalidArgumentException('$object must be an object.');

        $classname = strtolower(get_class($object));
        if (isset($_FILES[$classname . '_form'])) {
            //self::addEventListenerAfterCreate(strtolower(get_class($object)), "");
            //$data = $_FILES[strtolower(get_class($object)) . '_form'];

            foreach ($_FILES[$classname . "_form"]['name'] as $key_form => $value_form) {
                if (!method_exists($object, 'upload' . ucfirst($key_form))) {
                    $this->error[$key_form] = " You may create method " . 'upload' . ucfirst($key_form) . " in entity. ";
                    continue;
                }
                $object->{'upload' . ucfirst($key_form)}();
                //self::addEventListenerBeforeCreate(get_class($this->entity), 'upload' . ucfirst($key_form));
            }

            if (!$data) {
                return $object;
            }

        }

        if (!$data) {
            return $object->__show($deeper);
        }

        global $_ENTITY_FORM;
        $_ENTITY_FORM = $data;

        if ($object->getId()) {
            $object = $object->__show($deeper);
            $object->setUpdatedAt(date(\DClass\lib\Util::dateformat));
        } else
            $object->setCreatedAt(date(\DClass\lib\Util::dateformat));


//            if($jsondata){
//                $object_array = Controller::formWithJson ($object, $jsondata, $change_collection_adresse);
//            }else{
        $this->entity = $object;

        return $this->formWithPost($object);
//            }

    }

    /**
     * @param $object
     * @param $entityform
     * @return mixed
     * @throws \ReflectionException
     */
    private function formWithPost(\Model $object)
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
        //$_ENTITY_FORM["devups_entitycollection"] = "empty";

        //$entitycore = new \stdClass();
        //$entitycore->field = json_decode($_POST["dvups_form"][strtolower(get_class($object))], true);
        //$entitycore->field = $object->entityKeyForm();

        foreach ($_ENTITY_FORM as $key_form => $value_form) {
            $result = explode(":", $key_form);
            $attrib = $result[0];
            $key = $result[0];
            if (isset($result[1])) {
                if ($result[1] == "upload") {
                    self::addEventListenerAfterCreate(get_class($this->entity), 'upload' . ucfirst($result[1]));
                    //self::$eventListners['after']['create'] = 'upload'.ucfirst($meta[1]);
                    continue;
                }
                $setter = 'set' . ucfirst($result[1]);
            } else
                $setter = 'set' . ucfirst($result[0]);

            //if ($key_form == $key) {

            if ($setter == 'setNull' || in_array($attrib, $this->nopersist)) {
                continue;
            }

            $currentfieldsetter = $setter;
            //var_dump($key_form, strpos($key_form, "::"));
            if (strpos($key_form, "::")) {

                $entitname = str_replace("::values", "", $key);

                if (strpos($entitname, "\\")) {
                    $classtyperst = explode("\\", $entitname);
                    $classtype = $classtyperst[0];
                    $entitname = $classtyperst[1];
                } else
                    $classtype = $entitname;

                $currentfieldsetter = 'set' . ucfirst($entitname);

                if (!class_exists($classtype)) {

                    if (!method_exists($object, $currentfieldsetter)) {
                        $this->error[$key] = " You may create method " . $currentfieldsetter . " in entity. ";
                    } elseif ($error = call_user_func(array($object, $currentfieldsetter), implode(",", $value_form)))
                        $this->error[$key] = $error;

                    continue;
                }

                if ($object->getId()) {
                    $values = $object->inCollectionOf($classtype);

//                $toadd = array_diff($_ENTITY_FORM[$key], $value["values"]);
//                $todrop = array_diff($value["values"], $_ENTITY_FORM[$key]);

                    $toadd = array_diff($value_form, $values);
                    $todrop = array_diff($values, $value_form);
                } else {
                    $toadd = $value_form;
                    $todrop = [];
                }
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

                        $reflect = new \ReflectionClass($classtype);
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

                        $reflect = new \ReflectionClass($classtype);
                        $value2 = $reflect->newInstance();
                        $value2->setId($val);
                        $oldselection[] = $value2;
                    }
                }

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
                if (strpos($key_form, ".id")) {
                    // && is_object ($value['options'][0])

                    $entitname = str_replace(".id", "", $key_form);
                    if (strpos($entitname, "\\")) {
                        $classtyperst = explode("\\", $entitname);
                        $classtype = $classtyperst[0];
                        $entitname = $classtyperst[1];
                    } else
                        $classtype = $entitname;

                    $currentfieldsetter = 'set' . ucfirst($entitname);
                    //dv_dump($currentfieldsetter);
                    if (!class_exists($entitname))
                        continue;

                    if (!is_numeric($value_form)) {
                        continue;
                    }

                    $reflect = new \ReflectionClass($classtype);
                    $value2 = $reflect->newInstance();

                    $value2->setId($value_form);

                    if (!method_exists($object, $currentfieldsetter)) {
                        $this->error[$key] = " You may create method " . $currentfieldsetter . " in entity ";
                    } elseif ($error = call_user_func(array($object, $currentfieldsetter), $value2->__show(false)))
                        $this->error[$key] = $error;

                } else {

                    //if (isset($_ENTITY_FORM[$key])) {
//                        if (isset($value["type"]) && $value["type"] == "injection") {
//                                $result = call_user_func(array($key."Controller", "createAction"));
//                                if($error = call_user_func(array($object, $currentfieldsetter), $result[$key]))
//                                    $this->error[$key] = $error;
//                        } else
                    if (!method_exists($object, $currentfieldsetter)) {
                        $this->error[$key] = " You may create method " . $currentfieldsetter . " in entity. ";
                    } elseif ($error = call_user_func(array($object, $currentfieldsetter), $_ENTITY_FORM[$key]))
                        $this->error[$key] = $error;
                    //}

                }
            //}

        }
//        }

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

            //$this->hydrateEntity($field, $value, $meta, $imbricate);
            if (isset($meta[1])) {
                if ($meta[1] == "upload") {
                    self::addEventListenerAfterCreate(get_class($this->entity), 'upload' . ucfirst($meta[1]));
                    //self::$eventListners['after']['create'] = 'upload'.ucfirst($meta[1]);
                    continue;
                }
                $setter = "set" . ucfirst($meta[1]);
            } else
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

                $classtype = explode("\\", $imbricate[0]);
                if (count($classtype) > 1)
                    $imbricate[0] = $classtype[1];

                if ($imbricate[1] !== "id") // if the default value have changed to may be other_name, then it will call a method as setOther_name() in the owner class
                    $setter = "set" . ucfirst($imbricate[1]);
                else // if the default value is still id, then it will call a method setAttributename() in the owner class
                    $setter = "set" . ucfirst($imbricate[0]);

                $reflect = new \ReflectionClass($classtype[0]);
                $entityimbricate = $reflect->newInstance();
                if (!is_numeric($value)) {
                    $entityimbricate->setId(null);
                    continue;
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

        return $this->entity;

    }

    private function hydrateEntity($field, $value, $meta, $imbricate)
    {

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

    // public abstract function listView($next = 1, $per_page = 10);

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


    public static $classname;

}
