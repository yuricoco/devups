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
     * 
     * @param string $att
     * @param type $order
     * @return type
     */
    public static function all($att = 'id', $order = "asc") {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        if ($att == 'id')
            $att = strtolower(get_class($entity)) . "." . $att;

        return $qb->select()->orderby($att . " " . $order)->__getAll();
    }

    /**
     * Return an array of rows as in database.
     * @example http://easyprod.spacekola.com/doc/#allrow 
     * @param String $att the attribut you want to order by
     * @param String $order the ordering model ( ASC default, DESC, RAND() )
     * @return Array
     */
    public static function allrows($att = 'id', $order = "") {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        if ($att == 'id')
            $att = strtolower(get_class($entity)) . "." . $att;

        return $qb->select()->orderby($att . " " . $order)->__getAllRow();
    }

    /**
     * return instance of \QueryBuilder white the select request sequence.
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
     * @return boolean
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

    public function __delete() {
        $dbal = new DBAL();
        return $dbal->deleteDbal($this);
    }

    public function __getall($att = 'id', $order = "asc") {
        $qb = new QueryBuilder($this);
        if ($att == 'id')
            $att = strtolower(get_class($this)) . "." . $att;

        return $qb->select()->orderby($att . " " . $order)->__getAll();
    }

    public function __all($att = 'id', $order = "") {
        $qb = new QueryBuilder($this);
        if ($att == 'id')
            $att = strtolower(get_class($this)) . "." . $att;

        return $qb->select()->orderby($att . " " . $order)->__getAll();
    }

    public function __hasmany($collection) {
        if (!is_object($collection)) {
            $reflection = new ReflectionClass($collection);
            $collection = $reflection->newInstance();
        }
        if ($this->getId()) {
            $dbal = new DBAL();
            return $dbal->hasmany($this, $collection);
        } else {
            return [];
        }
    }

    public function __belongto($relation) {

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