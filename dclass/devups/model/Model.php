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

abstract class Model extends \stdClass
{

    public static $jsonmodel;
    public $dvfetched = false;
    public $dvsoftdelete = false;
    public $dvinrelation = false;


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
        return $route . "src" . $dirname . $src;
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
     * @param type $lable
     * @param type $content
     * @param type $lang
     * @return \Dvups_lang
     */
    public static function inittranslate($entity, $column, $content, $lang = __lang)
    {
        $id = $entity->getId();
        if (!$id || !$content)
            return;

        $table = strtolower(get_class($entity));
        $ref = $table . "_" . $id . "_" . $column;

        $dvlang = Dvups_lang::select()->where("ref", $ref)->__getOne();
        $dvcontentlang = new Dvups_contentlang();

        if ($dvlang->getId()) {
            $dvcontentlang = Dvups_contentlang::select()
                ->where("dvups_lang.ref", $dvlang->getRef())
                ->andwhere("lang", $lang)
                ->__getOne();
            if (!$dvcontentlang->getId()) {
                $dvcontentlang = new Dvups_contentlang();

                $dvcontentlang->setDvups_lang($dvlang);
                $dvcontentlang->setLang($lang);
            }
        } else {
            $dvlang = new Dvups_lang();
            $dvlang->setRef($ref);
            $dvlang->set_table($table);
            $dvlang->set_row($id);
            $dvlang->set_column($column);
            $dvlang->__save();

            $dvcontentlang->setDvups_lang($dvlang);
            $dvcontentlang->setLang($lang);
        }
        $dvcontentlang->setContent($content);
        $dvcontentlang->__save();

    }

    /**
     *
     * @param type $lable
     * @param type $content
     * @param type $lang
     * @return \Dvups_lang
     */
    public function __inittranslate($column, $content, $lang = __lang)
    {
        if (!$this->id || !$content)
            return;

        $table = strtolower(get_class($this));
        $ref = $table . "_" . $this->id . "_" . $column;

        $dvlang = Dvups_lang::select()->where("ref", $ref)->__getOne();
        $dvcontentlang = new Dvups_contentlang();

        if ($dvlang->getId()) {
            $dvcontentlang = Dvups_contentlang::select()
                ->where("dvups_lang.ref", $dvlang->getRef())
                ->andwhere("lang", $lang)
                ->__getOne();
            if (!$dvcontentlang->getId()) {
                $dvcontentlang = new Dvups_contentlang();

                $dvcontentlang->setDvups_lang($dvlang);
                $dvcontentlang->setLang($lang);
            }
        } else {
            $dvlang = new Dvups_lang();
            $dvlang->setRef($ref);
            $dvlang->set_table($table);
            $dvlang->set_row($this->id);
            $dvlang->set_column($column);
            $dvlang->__save();

            $dvcontentlang->setDvups_lang($dvlang);
            $dvcontentlang->setLang($lang);
        }
        $dvcontentlang->setContent($content);
        $dvcontentlang->__save();

    }

    public static function gettranslate($entity, $column, $default = null)
    {
        $id = $entity->getId();

        if (!$id)
            return "";

        $lang = local();
        //$lang = __lang;
        $table = strtolower(get_class($entity));
        $ref = $table . "_" . $id . "_" . $column;

        $dvcontentlang = Dvups_contentlang::select()
            ->where("dvups_lang.ref", $ref)
            ->andwhere("lang", $lang)->__getOne();

        //dv_dump( $dvcontentlang->getId());
        if ($dvcontentlang->getId())
            return $dvcontentlang->getContent();

        return $default;
    }

    public function __gettranslate($column, $default = null)
    {
        $id = $this->id;

        if (!$id)
            return "";

        $lang = local();
        //$lang = __lang;
        $table = strtolower(get_class($this));
        $ref = $table . "_" . $id . "_" . $column;

        $dvcontentlang = Dvups_contentlang::select()
            ->where("dvups_lang.ref", $ref)
            ->andwhere("lang", $lang)->__getOne();

        //dv_dump( $dvcontentlang->getId());
        if ($dvcontentlang->getId())
            return $dvcontentlang->getContent();

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
     * return the row as design in the database
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function count($parameter = null, $value = null)
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        if (is_null($parameter))
            return $qb->select()->__countEl();

        if (is_object($parameter))
            return $qb->select()->where($parameter)->__countEl(false);

        return $qb->select()->where($parameter, "=", $value)->__countEl(false);

    }


    /**
     * return the firt
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function first($recursif = true, $collect = [])
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->select()->limit(1)->__getOne($recursif, $collect);
    }

    /**
     * return the row as design in the database
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function last($recursif = true, $collect = [])
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->select()->orderby($qb->getTable() . ".id desc")->limit(1)->__getOne($recursif, $collect);
    }

    /**
     * return the row as design in the database
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function lastrow()
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->select()->orderby("id desc")->limit(1)->__getOneRow();
    }

    /**
     * return the row as design in the database
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function index($index = 1, $recursif = true, $collect = []) {
        $i = (int) $index;
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        if($i < 0){
            $nbel = $qb->__countEl();
            if($nbel == 1)
                return $entity;

            $i += $nbel;
            return $qb->select()->limit($i - 1, $i)->__getOne($recursif, $collect);
        }

        return $qb->select()->limit($i - 1, $i)->__getOne($recursif, $collect);
    }

    /**
     * return the attribut as design in the database
     * @example http://easyprod.spacekola.com description
     * @param Str $attribut
     * @param int $id
     * @return $this
     */
    public static function getattribut($attribut, $id)
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->select($attribut)->where("this.id", $id)->exec(DBAL::$FETCH)[0];
    }

    /**
     * return the attribut as design in the database
     * @example http://easyprod.spacekola.com description
     * @param string $attribut
     * @param string $value
     * @return $this
     */
    public static function getbyattribut($attribut, $value)
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->select()->where($attribut, $value)->__getOne();
    }

    /**
     * return the row as design in the database
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function findrow($id)
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();
        $entity->setId($id);

        $qb = new QueryBuilder($entity);
        return $qb->select()->where("id", "=", $id)->__getOneRow();
    }

    /**
     * return the entity
     * when recursif set to false, attribut as relation manyToOne has just their id hydrated
     * when recursif set to true, the DBAL does recursif request to hydrate the association entity and those of it.
     * @param integer $id the id of the entity
     * @param boolean $recursif [true] tell the DBAL to find all the data of the relation
     * @return $this
     */
    public static function find($id, $recursif = true, $collect = [])
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();
        $entity->setId($id);

        $dbal = new DBAL();
        $dbal->setCollect($collect);
        return $dbal->findByIdDbal($entity, $recursif);
    }

    /**
     * return the entity
     * when recursif set to false, attribut as relation manyToOne has just their id hydrated
     * when recursif set to true, the DBAL does recursif request to hydrate the association entity and those of it.
     * @param type $id the id of the entity
     * @param boolean $recursif [true] tell the DBAL to find all the data of the relation
     * @return \QueryBuilder
     */
    public static function delete($id = null)
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        if ($id) {
            $entity->setId($id);

            $dbal = new DBAL();
            return $dbal->deleteDbal($entity);
        } else {
            $qb = new QueryBuilder($entity);
            return $qb->delete();
        }

    }

    /**
     *
     * @param string $sort
     * @param type $order
     * @return type
     */
    public static function all($sort = 'id', $order = "asc")
    {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        if ($sort == 'id')
            $sort = $qb->getTable() . "." . $sort;

        return $qb->select()->handlesoftdelete()->orderby($sort . " " . $order)->__getAll();

    }

    /**
     * Return an array of rows as in database.
     * @example http://easyprod.spacekola.com/doc/#allrow
     * @param String $att the attribut you want to order by
     * @param String $order the ordering model ( ASC default, DESC, RAND() )
     * @return Array
     */
    public static function allrows($sort = 'id', $order = "")
    {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        if ($sort == 'id')
            $sort = $qb->getTable() . "." . $sort;

        return $qb->select()->handlesoftdelete()->orderby($sort . " " . $order)->__getAllRow();
    }

    /**
     * return instance of \QueryBuilder white the select request sequence.
     * @param string $columns
     * @return \QueryBuilder
     * @example name, description, category if none has been set, all will be take.
     */
    public static function select($columns = '*')
    {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->select($columns);
    }

    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @return QueryBuilder
     */
    public static function where($column, $operator = null, $value = null)
    {
        return self::select()->where($column, $operator, $value);
    }

    /**
     * update a part or an entire entity
     * @example http://easyprod.spacekola.com description
     * @param Mixed $arrayvalues
     * @param Mixed $seton
     * @param Mixed $case id
     * @return \QueryBuilder
     */
    public static function update($arrayvalues = null, $seton = null, $case = null, $defauljoin = true)
    {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();
        if ($seton != null && is_array($arrayvalues) || $case != null && !is_array($case))
            $entity->setId($case);

        $qb = new QueryBuilder($entity);
        return $qb->update($arrayvalues, $seton, $case, $defauljoin);
    }

    /**
     * @param null $id
     * @param null $update
     * @return mixed
     * @throws ReflectionException
     */
    public static function dclone($id = null, $update = null)
    {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        if ($id)
            return $qb->__dclone($update)->where("this.id", $id)->exec(DBAL::$INSERT);

        return $qb->__dclone($update);
    }

    /**
     * create a new entry
     * @return integer
     */
    public function __insert()
    {
        $this->created_at = date(\DClass\lib\Util::dateformat);
        $dbal = new DBAL();
        return $dbal->createDbal($this);
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
        if ($this->getId())
            return $dbal->updateDbal($this);
        else
            return $dbal->createDbal($this);
    }

    public function __show($recursif = false)
    {
        if ($this->dvfetched) {
            return $this;
        }

        $dbal = new DBAL();
        return $dbal->findByIdDbal($this, $recursif);
    }

    public function __findrow()
    {
        $qb = new QueryBuilder($this);
        return $qb->select()->where("id", "=", $this->id)->__getOneRow();
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

    public function __getall($att = 'id', $order = "asc")
    {
        $qb = new QueryBuilder($this);
        if ($att == 'id')
            $att = $qb->getTable() . "." . $att;

        return $qb->select()->orderby($att . " " . $order)->__getAll();
    }

    public function __all($att = 'id', $order = "")
    {
        $qb = new QueryBuilder($this);
        if ($att == 'id')
            $att = $qb->getTable() . "." . $att;

        return $qb->select()->orderby($att . " " . $order)->__getAll();
    }

    public function __hasmany($collection, $exec = true, $incollectionof = null, $recursif = false)
    {
        if (!is_object($collection)) {
            $reflection = new ReflectionClass($collection);
            $collection = $reflection->newInstance();
        }
        if ($this->getId()) {
            $dbal = new DBAL();
            return $dbal->hasmany($this, $collection, $exec, $incollectionof, $recursif);
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
    public function __hasone($relation, $recursif = false, $get = true)
    {
        if (!is_object($relation)) :
            $reflection = new ReflectionClass($relation);
            $relation = $reflection->newInstance();
        endif;

        $qb = new QueryBuilder($relation);
        if ($get)
            return $qb->select()->where("this." . strtolower(get_class($this)) . "_id", $this->getId())->__getOne($recursif);

        return $qb->select()->where("this." . strtolower(get_class($this)) . "_id", $this->getId());
    }

    public function __get($attribut)
    {
        $qb = new QueryBuilder($this);
        return $qb->select($attribut)->where("this.id", $this->getId())->exec(DBAL::$FETCH)[0];
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
        if(!$format)
            return $this->created_at;

        return  date($format, strtotime($this->created_at));
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return string
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
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

    public function inCollectionOf($collection, $key_map = ""){

        if(!$this->getId())
            return [];

        $thisclass = get_class($this);
        $entityTable = $collection;
        $entity_id = "id";

        $dbal = new DBAL();
        if ($key_map) {
            // do nothing
            $entityTable = $key_map;
        }elseif ($dbal->tableExists($collection . '_' . $thisclass)) {
            $entityTable = $collection . '_' . $thisclass;
            $entity_id = $collection."_id";
        } elseif ($dbal->tableExists($thisclass . "_" . $collection)) {
            $entityTable = $thisclass . "_" . $collection;
            $entity_id = $collection."_id";
        }
//        else {
//            $association = false;
//            $entityTable = $entityName;
//            $direction = "lr";
//        }

        $collection_ids = [];

        $dbal = new DBAL();
        $results = $dbal->executeDbal(strtolower(" select $entity_id from `$entityTable` where ".$thisclass."_id = ".$this->getId()), [], DBAL::$FETCHALL);
        foreach ($results as $index => $values)
            $collection_ids[] = $values[0];
            //$result = $result[$index][0];

        return $collection_ids;
        //return implode(",", $collection_ids);
    }

}
