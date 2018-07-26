<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author azankang atemkeng  <azankang.developer@gmail.com>
 */
abstract class Model extends \stdClass {

    public $dvfetched = false;
    public $dvinrelation = false;

    public function inrelation(){

        global $em;
        $this->classmetadata = $em->getClassMetadata("\\" . get_class($this));

        $objecarray = (array) $this;
        $association = array_keys($this->classmetadata->associationMappings);
        if(count($association))
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

    public static function classpath(){
        $reflector = new ReflectionClass(get_called_class());
        $fn = $reflector->getFileName();
        $dirname = explode("src", dirname($fn));
        $dirname = str_replace("Entity", "", $dirname[1]);
        return "src".$dirname;
    }

    /**
     *
     * @param type $lable
     * @param type $content
     * @param type $lang
     * @return \Dvups_lang
     */
    public function __translate($lable, $content, $lang = "fr") {
        if(!$this->id || !$content)
            return;

        $dvlang = new Dvups_lang();
        $dvlang->setLabel($this->id . "_" . $lable);
        $dvlang->setLang($lang);
        $dvlang->setTable(strtolower(get_class($this)));
        $dvlang->setRow_id($this->id);
        $dvlang->setContent($content);
        $dvlang->__save();
    }

    public function __updatetranslate($lable, $content, $lang = "fr") {
        if(!$this->id || !$content)
            return;

        $dvlang = Dvups_lang::select()
            ->where("label", $this->id . "_" . $lable)
            ->andwhere("lang", $lang)
            ->andwhere("`table`", strtolower(get_class($this)) )
            ->__getOne();

        if (!$dvlang->getId()) {
            $dvlang->setLabel($this->id . "_" . $lable);
            $dvlang->setLang($lang);
            $dvlang->setTable(strtolower(get_class($this)));
            $dvlang->setRow_id($this->id);
        }
        $dvlang->setContent($content);
        $dvlang->__save();
    }

    public function __gettranslate($lable, $lang = "fr") {
        if(!$this->id)
            return "";

        $dvlang = Dvups_lang::select()->where("label", $this->id . "_" . $lable)
            ->andwhere("`table`", strtolower(get_class($this)) )
            ->andwhere("lang", $lang)->__getOne();
        return $dvlang->getContent();
    }

    /**
     *
     * @param type $param
     * @return \Dfile
     */
    public static function Dfile($fileparam) {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();
        $dfile = new Dfile($fileparam, $entity);
        return $dfile;
    }

    public function savefile($file) {

        $uploadmethod = 'set' . ucfirst($file);
        if (!method_exists($this, $uploadmethod)) {
            var_dump(" You may create method " . $uploadmethod . " to set the file. ");
            die;
        }

        $dfile = new Dfile($file, $this);
        if ($this->id) {
            $getcurrentfile = 'get' . ucfirst($file);
            if (!method_exists($this, $getcurrentfile)) {
                var_dump(" You may create method " . $getcurrentfile . " to update the file. ");
                die;
            }

            $currentfile = call_user_func(array($this, $getcurrentfile));
            if ($currentfile)
                $dfile::deleteFile($currentfile, $dfile->uploaddir);
        }

        $url = $dfile->hashname()->move();
        call_user_func(array($this, $uploadmethod), $url["file"]["hashname"]);

        if (!$url['success']) {
            return false;
        }
        return true;
    }



    /**
     * return the row as design in the database
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function count() {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->select()->__countEl();

    }


    /**
     * return the row as design in the database
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function first() {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->select()->limit(1)->__getOne();
    }

    /**
     * return the row as design in the database
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function last() {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->select()->orderby($qb->getTable().".id desc")->limit(1)->__getOne();
    }

    /**
     * return the row as design in the database
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function get($index = 1) {
        $i = (int) $index;
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->select()->limit($i - 1, $i)->__getOne();
    }

    /**
     * return the row as design in the database
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function findrow($id) {

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
     * @param type $id the id of the entity
     * @param boolean $recursif [true] tell the DBAL to find all the data of the relation
     * @return type
     */
    public static function find($id, $recursif = true) {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();
        $entity->setId($id);

        $dbal = new DBAL();
        return $dbal->findByIdDbal($entity, $recursif);
    }

    /**
     * return the entity
     * when recursif set to false, attribut as relation manyToOne has just their id hydrated
     * when recursif set to true, the DBAL does recursif request to hydrate the association entity and those of it.
     * @param type $id the id of the entity
     * @param boolean $recursif [true] tell the DBAL to find all the data of the relation
     * @return type
     */
    public static function delete($id = null) {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        if($id){
            $entity->setId($id);

            $dbal = new DBAL();
            return $dbal->deleteDbal($entity);
        }else{
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
    public static function all($sort = 'id', $order = "asc") {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        if ($sort == 'id')
            $sort = $qb->getTable() . "." . $sort;

        return $qb->select()->orderby($sort . " " . $order)->__getAll();
    }

    /**
     * Return an array of rows as in database.
     * @example http://easyprod.spacekola.com/doc/#allrow
     * @param String $att the attribut you want to order by
     * @param String $order the ordering model ( ASC default, DESC, RAND() )
     * @return Array
     */
    public static function allrows($sort = 'id', $order = "") {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        if ($sort == 'id')
            $sort = $qb->getTable() . "." . $sort;

        return $qb->select()->orderby($sort . " " . $order)->__getAllRow();
    }

    /**
     * return instance of \QueryBuilder white the select request sequence.
     * @example name, description, category if none has been set, all will be take.
     * @param string $columns
     * @return \QueryBuilder
     */
    public static function select($columns = '*') {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->select($columns);
    }

    /**
     * update a part or an entire entity
     * @example http://easyprod.spacekola.com description
     * @param Mixed $arrayvalues
     * @param Mixed $seton
     * @param Mixed $case id
     * @return \QueryBuilder
     */
    public static function update($arrayvalues = null, $seton = null, $case = null) {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();
        if ($seton != null && is_array($arrayvalues) || $case != null && !is_array($case))
            $entity->setId($case);

        $qb = new QueryBuilder($entity);
        return $qb->update($arrayvalues, $seton, $case);
    }

    /**
     * create a new entry
     * @return integer
     */
    public function __insert() {
        $dbal = new DBAL();
        return $dbal->createDbal($this);
    }

    /**
     * update a part or an entire entity
     * @example http://easyprod.spacekola.com description
     * @param Mixed $arrayvalues
     * @param Mixed $seton
     * @param Mixed $case
     * @return boolean
     */
    public function __update($arrayvalues = null, $seton = null, $case = null) {
        $dbal = new DBAL();
        if (!$arrayvalues) {
            return $dbal->updateDbal($this);
        } else {
            $qb = new QueryBuilder($this);
            return $qb->update($arrayvalues, $seton, $case);
        }
    }

    public function __save() {

        $dbal = new DBAL();
        if ($this->getId())
            return $dbal->updateDbal($this);
        else
            return $dbal->createDbal($this);
    }

    public function __show($recursif = false) {
        if (isset($this->dvfetched)) {
            return $this;
        }
        $dbal = new DBAL();
        return $dbal->findByIdDbal($this, $recursif);
    }

    public function __delete($exec = true) {
        if ($exec) {
            $dbal = new DBAL();
            return $dbal->deleteDbal($this);
        } else {
            $qb = new QueryBuilder($this);
            $qb->delete();
            return $qb;
        }
    }

    public function __getall($att = 'id', $order = "asc") {
        $qb = new QueryBuilder($this);
        if ($att == 'id')
            $att = $qb->getTable() . "." . $att;

        return $qb->select()->orderby($att . " " . $order)->__getAll();
    }

    public function __all($att = 'id', $order = "") {
        $qb = new QueryBuilder($this);
        if ($att == 'id')
            $att = $qb->getTable() . "." . $att;

        return $qb->select()->orderby($att . " " . $order)->__getAll();
    }

    public function __hasmany($collection, $exec = true) {
        if (!is_object($collection)) {
            $reflection = new ReflectionClass($collection);
            $collection = $reflection->newInstance();
        }
        if ($this->getId()) {
            $dbal = new DBAL();
            return $dbal->hasmany($this, $collection, $exec);
        } else {
            return [];
        }
    }

    public function __belongto($relation) {

        if(is_object($relation) && $relation->dvfetched)
            return $relation;

        if (!$this->getId()) {
            if (is_object($relation)) :
                return $relation;
            else:
                $reflection = new ReflectionClass($relation);
                return $reflection->newInstance();
            endif;
        }

        $dbal = new DBAL();
        return $dbal->belongto($this, $relation);
    }

    public function __belongto2($relation) {
        if (!is_object($relation)) :
            $reflection = new ReflectionClass($relation);
            $relation = $reflection->newInstance();
        endif;

        $qb = new QueryBuilder($relation);
        return $qb->select()->where(strtolower(get_class($this)) . "_id", $this->getId())->__getOne();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function scan_entity_core() {
        return Core::__extract($this);
    }

}
