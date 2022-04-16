<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 * Description of Model
 *
 * @author azankang atemkeng  <azankang.developer@gmail.com>
 */

//namespace dclass\devups;

class Model extends \stdClass
{

    use ModelTrait;

    public static $jsonmodel;

    /**
     * @Column(name="created_at", type="datetime" , nullable=true )
     * @var string
     **/
    protected $created_at;
    /**
     * @Column(name="updated_at", type="datetime" , nullable=true )
     * @var string
     **/
    protected $updated_at;
    /**
     * @Column(name="deleted_at", type="datetime" , nullable=true )
     * @var string
     **/
    protected $deleted_at;

    //public $dverrormessage = "";

    public function inrelation()
    {

        global $em;
        $this->classmetadata = $em->getClassMetadata("\\" . get_class($this));

        $objecarray = (array)$this;
        $association = array_keys($this->classmetadata->associationMappings);
        if (count($association))
            return true;

        return false;
//        foreach ($objecarray as $obkey => $value) {
//            // gere les attributs hérités en visibilité protected
//            if (is_object($value)) {
//                $classname = get_class($value);
//                if ($classname != 'DateTime' && $association[0] != $classname) {
//                    return true;
//                }
//            }
//        }
    }

    /**
     * static method gives the path of the module where the entity is/
     * @return string the path of the module where the class is.
     */
    public static function classpath($src = "", $route = __env)
    {
        //return get_called_class();
        $reflector = new ReflectionClass(get_called_class());
        $fn = $reflector->getFileName();
        $dirname = explode("src", dirname($fn));
        $dirname = str_replace("Entity", "", $dirname[1]);
        return str_replace("\\", "/", $route . "src" . $dirname . $src);
    }

    /**
     * static method gives the path of the module where the entity is/
     * @return string the path of the module where the class is.
     */
    public static function classview($view, $route = __env."admin/")
    {
        //return get_called_class();
        $reflector = new ReflectionClass(get_called_class());
        $fn = $reflector->getFileName();
        $dirname = explode("src", dirname($fn));
        $dirname = str_replace("Entity", "", $dirname[1]);
        return str_replace("\\", "/", $route . $dirname . $view);
    }

    /**
     * static method gives the path of the module where the entity is/
     * @return string the path of the module where the class is.
     */
    public static function services($src = "", $route = __env)
    {
        //return get_called_class();
        $reflector = new ReflectionClass(get_called_class());
        $fn = $reflector->getFileName();
        $dirname = explode("src", dirname($fn));
        $dirname = str_replace("Entity", "", $dirname[1]);
        return str_replace("\\", "/", $route . "src" . $dirname . "services.php?path=" . $src);
    }

    public static function classroot($src)
    {
        $reflector = new ReflectionClass(get_called_class());
        $fn = $reflector->getFileName();
        $dirname = explode("src", dirname($fn));
        $dirname = str_replace("Entity", "", $dirname[1]);
        return ROOT . "src" . $dirname . $src;
    }

    /**
     * static method gives the directory of the module where the entity is/
     * @return classroot the directory of the module where the class is.
     */
    public static function classdir()
    {
        return ROOT . '..' . self::classpath();
    }

    public static function post($attribute, $default = null)
    {

        $class = strtolower(get_called_class());
        if (isset($_POST[$class . "_form"][$attribute]))
            return $_POST[$class . "_form"][$attribute];
        else
            return $default;

    }

    /**
     *
     * @param type $param
     * @return \Dfile
     */
    public static function Dfile($fileparam)
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();
        $dfile = new Dfile($fileparam, $entity);
        return $dfile;
    }

    /**
     * @param $file
     * @return bool
     */
    public function uploadfile($file)
    {

        $uploadmethod = 'set' . ucfirst($file);
        if (!method_exists($this, $uploadmethod)) {
            Genesis::json_encode(["success" => false,
                "error" => ["method not exist" => " You may create method " . $uploadmethod . " to update the file. "]]);
            die;
        }

        $dfile = new Dfile($file, $this);

        if ($dfile->error)
            return false;

        if ($this->id) {
            $getcurrentfile = 'get' . ucfirst($file);
            if (!method_exists($this, $getcurrentfile)) {
                Genesis::json_encode(["success" => false,
                    "error" => ["method not exist" => " You may create method " . $getcurrentfile . " to update the file. "]]);
                die;
            }

            $currentfile = call_user_func(array($this, $getcurrentfile));
            if ($currentfile)
                $dfile::deleteFile($currentfile, $dfile->uploaddir);
        }

        $url = $dfile->sanitize()->upload();

        if (!$url['success']) {
            Genesis::json_encode($url);
            die;
            return false;
        }

        $return = call_user_func(array($this, $uploadmethod), $url["file"]["hashname"]);

        if ($return) {
            Genesis::json_encode(["success" => false,
                "error" => ["method not exist" => " You may create method " . $getcurrentfile . " to update the file. "]]);
            die;
        }
    }

    /**
     * create a new entry
     * @return integer
     */
    public function __insert()
    {
        $this->created_at = date(\DClass\lib\Util::dateformat);
        $dbal = new DBAL();
        DBAL::$id_lang_static = $this->dvid_lang;
        $id = $dbal->createDbal($this);
        return $id;
    }

    /**
     * @param array $update
     * @return integer
     */
    public function __dclone($update = [])
    {
        $qb = new QueryBuilder($this);
        return $qb->__dclone($update)->where("this.id", $this->getId())->exec(DBAL::$INSERT);
    }

    /**
     * update a part or an entire entity
     * @example http://easyprod.spacekola.com description
     * @param Mixed $arrayvalues
     * @param Mixed $seton
     * @param Mixed $case
     * @return boolean | \QueryBuilder
     */
    public function __update($arrayvalues = null, $seton = null, $case = null, $defauljoin = true)
    {
        $this->updated_at = date(\DClass\lib\Util::dateformat);
        $dbal = new DBAL();
        DBAL::$id_lang_static = $this->dvid_lang;
        if (!$arrayvalues) {
            return $dbal->updateDbal($this);
        } else {
            $qb = new QueryBuilder($this);
            return $qb->update($arrayvalues, $seton, $case, $defauljoin);
        }
    }

    public function __save()
    {

        $dbal = new DBAL();
        if ($this->getId()) {
            $this->updated_at = date("Y-m-d");
            return $this->__update();
            //return $dbal->updateDbal($this);
        } else {
            $this->created_at = date("Y-m-d");
            return $this->__insert();
            //return $dbal->createDbal($this);
        }
    }

    public function __show($recursif = false, $id_lang = null)
    {
        if ($this->dvfetched) {
            return $this;
        }

        $dbal = new DBAL();
        return $dbal->findByIdDbal($this, $recursif, [], $id_lang);
    }

    public function __findrow()
    {
        $qb = new QueryBuilder($this);
        return $qb->select()->where("id", "=", $this->id)->getInstance();
    }

    public function __delete($exec = true)
    {
        if ($exec) {
            $dbal = new DBAL();
            return $dbal->deleteDbal($this);
        } else {
            $qb = new QueryBuilder($this);
            $qb->delete();
            return $qb;
        }
    }

    public function __hasmany($collection, $exec = true, $incollectionof = null, $id_lang = null)
    {
        if (!is_object($collection)) {
            $reflection = new ReflectionClass($collection);
            $collection = $reflection->newInstance();
        }
        if ($this->getId()) {
            $dbal = new DBAL();
            return $dbal->hasmany($this, $collection, $exec, $incollectionof, $id_lang);
        } elseif (!$exec)
            return new QueryBuilder($this);
        else {
            return [];
        }
    }

    /**
     * @param $relation
     * @param bool $recursif
     * @return $this
     * @throws ReflectionException
     */
    public function __belongto($relation)
    {

        if (is_object($relation) && ($relation->dvfetched || !$relation->dvinrelation))
            return $relation;

        if (!$this->getId()) {
            if (is_object($relation)) :
                return $relation;
            else:
                $reflection = new ReflectionClass($relation);
                return $reflection->newInstance();
            endif;
        } else {
            $reflection = new ReflectionClass($relation);
            $relation = $reflection->newInstance();
        }

        $dbal = new DBAL();
        return $dbal->belongto($this, $relation);
    }

    /**
     * @param $relation
     * @param bool $recursif
     * @return $this | QueryBuilder
     * @throws ReflectionException
     */
    public function __hasone($relation, $id_lang = null, $get = true)
    {
        if (!is_object($relation)) :
            $reflection = new ReflectionClass($relation);
            $relation = $reflection->newInstance();
        endif;

        $qb = new QueryBuilder($relation);
        $qb->setLang($id_lang);
        if ($get)
            return $qb->select()->where("this." . strtolower(get_class($this)) . "_id", $this->getId())->getInstance();

        return $qb->select()->where("this." . strtolower(get_class($this)) . "_id", $this->getId());
    }

    public function hydrate()
    {
        if (!$this->id || $this->dvfetched)
            return $this;

        global $em;
        $classlang = strtolower(get_class($this));
        $metadata = $em->getClassMetadata("\\" . $classlang);
        $fieldNames = $metadata->fieldNames;
        $assiactions = array_keys($metadata->associationMappings);

        $sql = " SELECT * FROM `$classlang` WHERE id = " . $this->id;
        $data = (new DBAL())->executeDbal($sql, [], DBAL::$FETCH);
        //var_dump($classlang." - ".$attribut, $data, $fieldNames);
        foreach ($fieldNames as $k => $val) {
            $this->{$k} = $data[$k];
        }
        foreach ($assiactions as $k) {
            //if(isset($data[$k]))
            $this->{$k}->id = $data[$k . "_id"];
            $this->{$k . "_id"} = $data[$k . "_id"];
        }

        if ($this->dvtranslate)
            (new DBAL($this))->getLangValues($this, $this->dvtranslated_columns);

        $this->dvfetched = true;

        return $this;
    }

    public function __get($attribut)
    {
//        $calledfrom = debug_backtrace();
//        dv_dump($calledfrom);
        if (!property_exists($this, $attribut)) {

            if ($this->dvtranslate && in_array($attribut, $this->dvtranslated_columns)) {
                if (!$this->id)
                    return null;
                $classlang = get_class($this) . "_lang";
                $cnl = strtolower($classlang);
                if (property_exists($classlang, $attribut)) {
                    $idlang = DBAL::$id_lang_static;

                    if (!$idlang) {

                        (new DBAL())->setClassname(get_class($this))->getLangValues($this, [$attribut]);
                        return $this->{$attribut};
                    }
                    $sql = " SELECT $attribut FROM `$cnl` WHERE lang_id = $idlang AND " . strtolower(get_class($this)) . "_id = " . $this->id;
                    $data = (new DBAL())->executeDbal($sql, [], DBAL::$FETCH);

                    $this->{$attribut} = $data[0];
                    return $data[0];
                }
            }
            else {
                $entityattribut = substr($attribut, 1, strlen($attribut)-1);
                //var_dump($attribut);
                if ($attribut != "_".$entityattribut){
                    $trace = debug_backtrace();
                    trigger_error(
                        'Propriété non-définie via __get() : ' . $attribut .
                        ' dans ' . $trace[0]['file'] .
                        ' à la ligne ' . $trace[0]['line'],
                        E_USER_NOTICE);
                    die;
                }
                if (is_object($this->{$entityattribut})) { //  && isset($this->{$entityattribut . "_id"})

                    if ($this->{$entityattribut}->dvfetched)
                        return $this->{$entityattribut};

                    $this->{$attribut} = $this->{$entityattribut}->hydrate();
//                    $classname = get_class($this->{$attribut});
//                    $this->{"_".$attribut} = $classname::findrow($this->{$attribut . "_id"});

                    return $this->{$attribut};
                }

            }
        } elseif (property_exists($this, $attribut)) {//$this->id &&

            /*
             * if id is defined and value of the attribut of this instance is null (problem with default value) and
             * if devups has never fetch it before then we hydrate the hole instance with it row in database
             */

            if ($this->id && !$this->dvfetched && $attribut != "id") { //  && !$this->{$attribut}

                /*
                 * the fact is that by a mechanism I don't understand by now once the method detect an association
                 * it automatically makes request to the db what I don't want.
                 * by the way even if we do $entity = $object->imbricate; when the dev will do $entity->attrib it will
                 * automatically hydrate the entity what solve the problem (at least for the current use case)
                 */
                /*if (is_object($this->{$attribut}) && isset($this->{$attribut."_id"})){

                    $classname = get_class($this->{$attribut});
                    $this->{$attribut} = $classname::findrow($this->{$attribut."_id"});

                    return $this->{$attribut};
                }*/
                global $em;
                $classlang = get_class($this);
                $metadata = $em->getClassMetadata("\\" . $classlang);
                $fieldNames = $metadata->fieldNames;
                $assiactions = array_keys($metadata->associationMappings);
                $cn = strtolower($classlang);
                $sql = " SELECT * FROM `$cn` WHERE id = " . $this->id;
                $data = (new DBAL())->executeDbal($sql, [], DBAL::$FETCH);
                //var_dump($classlang." - ".$attribut, $data, $fieldNames);
                foreach ($fieldNames as $k => $val) {
                    $this->{$k} = $data[$k];
                }
                foreach ($assiactions as $k) {
                    //if(isset($data[$k]))
                    $this->{$k}->id = $data[$k . "_id"];
                    $this->{$k . "_id"} = $data[$k . "_id"];
                }

                $this->dvfetched = true;
                //return $data[0];
            }
            return $this->{$attribut};

        }

        $trace = debug_backtrace();
        trigger_error(
            'Propriété non-définie via __get() : ' . $attribut .
            ' dans ' . $trace[0]['file'] .
            ' à la ligne ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->{$name} = $value;
    }

    public function getId()
    {
        return (int)$this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function scan_entity_core()
    {
        return Core::__extract($this);
    }

    public function __construct($id = null)
    {
        $this->id = $id;

    }

    /**
     * @return string
     */
    public function getCreatedAt($format = "")
    {
        if (!$format)
            return $this->created_at;

        return date($format, strtotime($this->created_at));
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt($created_at)
    {
        if ($created_at)
            $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt($format = "")
    {
        if (!$format)
            return $this->updated_at;

        return date($format, strtotime($this->updated_at));
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        if ($updated_at)
            $this->updated_at = $updated_at;
    }

    /**
     * @return string
     */
    public function getDeletedAt($format = "")
    {
        if (!$format)
            return $this->deleted_at;

        return date($format, strtotime($this->deleted_at));
    }

    /**
     * @param string $deleted_at
     */
    public function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }

    /**
     * Get value of entity X in $_POST global variable from submited form
     * @param string $formfeild
     * @return mixed
     */
    // todo: implement namespace for model class
//    public static function getvalue($formfeild){
//
//        $classname = strtolower(get_called_class());
//        return $_POST[$classname."_form['$formfeild']"];
//
//    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
        ];
    }

    const split = ";";

    public function importCsv($classname)
    {
        if (!isset($_FILES["fixture"]) || $_FILES["fixture"]['error'] != 0)
            return [
                "success" => false,
                "message" => "no file founded",
            ];


        $handle = file($_FILES["fixture"]["tmp_name"], FILE_IGNORE_NEW_LINES);

        if ($handle) {

            $values = [];
            $i = 0;
            //while (($line = fgets($handle)) !== false) {
            foreach ($handle as $line) {
                // process the line read.
                $references = [];
                if ($line) {
                    $line = (trim($line));
                    if ($i >= 1) {
                        // we verify if the current line is not empty. due to sometime EOF are just \n code
                        $reference = str_replace(self::split, "", $line);
                        if (!trim($reference))
                            continue;

                        // there are some file that has ;;; at the end of a line, programmatically it represent column
                        // therefore we have to remove those by user array_filter fonction
                        // we finaly combine value with column key
                        //try {
                        $valuetobind = explode(self::split, $line);
                        if (count($columns) != count($valuetobind))
                            return [
                                "content" => $line,
                                "index" => $i,
                                "columns" => $columns,
                                "nbc" => count($columns),
                                "valuetobind" => $valuetobind,
                                "nbv" => count($valuetobind),
                            ];

                        $keyvalue = array_combine($columns, explode(self::split, $line));

                        foreach ($this as $key => $val) {
                            if (in_array($key, self::$dvkeys))
                                continue;
                            if (is_object($val)) {
                                if (isset($keyvalue[$key . '_id']) && in_array(strtolower($keyvalue[$key . '_id']), ['', 'null']))
                                    $keyvalue[$key . '_id'] = null;
                            }
                        }
                        // dv_dump($keyvalue);

//                        }catch (Exception $exception){
//                            die(var_dump($exception));
//                        }

                        if (!$keyvalue) {
                            // and if event so we get a false
                            // we catch error to optimize the exception
                            $allerrors[] = [
                                "content" => $line,
                                "index" => $i,
                                "combinaison_column" => $columns,
                                "keyvalue" => $keyvalue,
                            ];
                            return $allerrors;
                        } else
                            DBAL::_createDbal(strtolower($classname), $keyvalue);

                    } else {
                        // we collect all headers and with the array_filter fonction we sanitize the array to avoid double value
                        $columns = array_filter(explode(self::split,
                            str_replace("\"", "", ($line))
                        ));
                    }
                    $i++;
                }
            }

        }

        return ["success" => true, "message" => "all went well"];

    }

    private function exportrows($callable, $column = "*", $sort = 'id', $order = "")
    {

        $qb = new QueryBuilder($this);

        return $qb->select($column)
            ->lazyloading("this." . $sort . " " . $order, false, true)
            ->get($column, $callable);

    }

    public function exportCsv($classname)
    {
        $keys = [];
        foreach ($this as $key => $val) {
            self::$dvkeys[] = 'id';
            if (in_array($key, self::$dvkeys) || is_array($val))
                continue;
            if (is_object($val)) {
                $keys[] = $key . '_id';
            } else
                $keys[] = $key;
        }

        $exportat = date("YmdHis");
        //$classname = get_class($this);
        $filename = $classname . "-" . $exportat . ".csv";
        $root = ROOT . "database/fixtures/" . $classname;

        if (!file_exists($root)) {
            mkdir($root, 0777, true);
        }

        // todo; optimization open the file once and write once
        \DClass\lib\Util::log(implode(";", $keys), $filename, $root);
        $this->exportrows(function ($row, $classname) use ($filename, $exportat, $root) {
            \DClass\lib\Util::log(implode(";", $row), $filename, $root);
        }, "this." . implode(", this.", $keys));

        $download = __env . "database/fixtures/" . $classname . "/" . $filename;
        return compact('keys', "download");
    }

    /**
     * map data to the specify model from the webservice call's
     * @param array $cutom_data an array (key -> value) of callback
     * @return array
     * @example $custom = [
     * "show"=>function(){ return $this->srcImage();}
     * ];
     */
    public function apimapper($cutom_data = [])
    {
        $datareturn = [];
        $rawdata = \Request::raw();
        $class = strtolower(get_class($this));
        if (isset(Request::$uri_raw_param["dataset"])) {
            if (isset(Request::$uri_raw_param["dataset"][$class])) {

                foreach ($this as $key => $value) {
                    if (in_array($key, Request::$uri_raw_param["dataset"][$class])) {
                        $datareturn[$key] = $value;
                    }
                }

                foreach ($cutom_data as $key => $value) {
                    if (!is_numeric($key)) {
                        if (is_callable($value)) {
                            $datareturn[$key] = $value();
                            continue;
                        }
                    } else
                        $key = $value;

                    if (in_array($key, Request::$uri_raw_param["dataset"][$class])) {
                        $method = 'get' . ucfirst($key);
                        if (method_exists($this, $method) && $result = call_user_func(array($this, $method))) {
                            $datareturn[$key] = $result;
                        } else {
                            $datareturn[$key] = null;
                        }
                    }
                }

                return $datareturn;
            }
        }

        return $datareturn;
    }

    private static $keyvalues = [];

    /**
     * create entity row and return id(s) of row(s)
     * @param ...$keyvalues
     * @return array|int|mixed
     */
    public static function create(...$keyvalues)
    {
        $ids = [];
        foreach ($keyvalues as $keyvalue) {
            $keyvalue["created_at"] = date("Y-m-d H:i:s");
            self::$keyvalues = $keyvalue;
            $classname = get_called_class();
            $ids[] = DBAL::_createDbal($classname, $keyvalue);
        }
        if (count($ids) == 1)
            return $ids[0];

        return $ids;
    }

    public static function createInstance(...$keyvalues)
    {
        $ids = self::create($keyvalues);
        if (count($ids)) {
            $instances = [];
            foreach ($ids as $id) {

            }
        }
    }

    public function hasRelation($name)
    {
        $keys = [];
        foreach ($this as $key => $val) {
            if (in_array($key, self::$dvkeys))
                continue;
            if (is_object($val) && $name == $key)
                return $val;
        }
        return false;
    }

    public static function link($path = "/index")
    {
        $entity = strtolower(get_called_class());
        $admin = getadmin();
        $de = Dvups_role_dvups_entity::where($admin->dvups_role)->andwhere("dvups_entity.name", $entity)->getInstance();

        if ($de->getId()) {
            return $de->dvups_entity->route($path);
        }
        return "#";

    }

    /**
     * @return Dvups_entity
     */
    public static function getDvupsEntity()
    {
        $entity = strtolower(get_called_class());
        return Dvups_entity::getbyattribut("this.name", $entity, false);

    }


    /**
     *
     * @param string $order
     * @return \dclass\devups\Datatable\Lazyloading
     */
    public static function lazyloading($order = "", $debug = false)
    {//
        $classname = get_called_class();
        $reflection = new ReflectionClass($classname);
        $entity = $reflection->newInstance();

        $ll = new \dclass\devups\Datatable\Lazyloading($entity);
        $ll->start($entity);
        if ($debug)
            return $ll->renderQuery()->lazyloading($entity, null, $order);

        return $ll->lazyloading($entity, null, $order);

    }

    public static function getStatusWhereKey($key){
        $classname = get_called_class();
        return Status::getStatus($key, strtolower($classname));
    }

}
