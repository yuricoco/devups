<?php

trait ModelTrait
{

    public $dvfetched = false;
    public $dvsoftdelete = false;
    public $dvinrelation = false;
    public $dvtranslate = false;
    public $dvid_lang = false; // this attribute has an issue I've forgot the one but this note is just to remind me of that
    // in fact if the attribute is not setted the __get() method will throw a error: attribute not found! why Have i commented it?
    public $dvtranslated_columns = [];
    private static $dvkeys = ["dvid_lang", "dvfetched", "dvinrelation", "dvsoftdelete", "dvtranslate", "dvtranslated_columns",];

    public $dv_collection = [];

    public function __get($attribut)
    {
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
            return $qb->select()->count();

        if (is_object($parameter) || is_array($parameter))
            return $qb->select()->where($parameter)->count();

        return $qb->select()->where($parameter, "=", $value)->count();

    }


    /**
     * return the firt
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function first($id_lang = null)
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        $qb->setLang($id_lang);
        return $qb->select()->limit(1)->getInstance();
    }
    /**
     * return the firt
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function firstOrCreate($constraint, $data = [], $id_lang = null)
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        $qb->setLang($id_lang);
        return $qb->firstOrCreate($constraint, $data, $id_lang);

    }

    /**
     * return the firt
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function firstOrNew($constraint, $data = [], $id_lang = null)
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        $qb->setLang($id_lang);
        return $qb->firstOrNew($constraint, $data, $id_lang);

    }

    /**
     * return the row as design in the database
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function last($id_lang = null)
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        $qb->setLang($id_lang);
        return $qb->select()->orderby($qb->getTable() . ".id desc")->limit(1)->getInstance();
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
        return $qb->select()->orderby("id desc")->limit(1)->getInstance();
    }

    /**
     * return the row as design in the database
     * @example http://easyprod.spacekola.com description
     * @param type $id
     * @return $this
     */
    public static function index($index = 1, $id_lang = null )
    {
        $i = (int)$index;
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->getIndex($index, $id_lang);
        /*if ($i < 0) {
            $nbel = $qb->count();
            if ($nbel == 1)
                return $entity;

            $i += $nbel;
            return $qb->select()->limit($i - 1, $i)->getInstance($recursif, $collect);
        }

        return $qb->select()->limit($i - 1, $i)->getInstance($recursif, $collect);*/
    }

    /**
     * return the attribut as design in the database
     * @example http://easyprod.spacekola.com description
     * @param string $attribut
     * @param int $id
     * @return mixed
     */
    public static function getattribut($attribut, $id)
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->select($attribut)->where("this.id", $id)->getValue();
    }

    public static function addColumns(...$columns)
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->addColumns($columns)->getValue();
    }

    /**
     * return the attribut as design in the database
     * @example http://easyprod.spacekola.com description
     * @param string $attribut
     * @param string $value
     * @return $this
     */
    public static function getbyattribut($attribut, $value, $id_lang = false)
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        $qb->setLang($id_lang);
        return $qb->select()->where($attribut, $value)->getInstance();
    }

    /**
     * return the row as design in the database
     * @example http://easyprod.spacekola.com description
     * @param int $id
     * @return $this
     */
    public static function findrow($id, $id_lang = null)
    {

        $classname = get_called_class();
        $reflection = new ReflectionClass($classname);
        $entity = $reflection->newInstance();
        $entity->setId($id);

        $qb = new QueryBuilder($entity);
        $qb->setLang($id_lang);
        if ($entity->dvtranslate) {
//            if (!$id_lang)
//                $id_lang = Dvups_lang::defaultLang()->getId();

            return $qb->select()
                //->leftjoinrecto($classname . "_lang")
                ->where("this.id", "=", $id)
                //->where($classname . "_lang.lang_id", "=", $id_lang)
                ->getInstance();
        } else
            return $qb->select()->where("id", "=", $id)->getInstance();

    }

    /**
     * return the entity
     * when recursif set to false, attribut as relation manyToOne has just their id hydrated
     * when recursif set to true, the DBAL does recursif request to hydrate the association entity and those of it.
     * @param integer | array $id the id of the entity
     * @param boolean $recursif [true] tell the DBAL to find all the data of the relation
     * @return $this | array
     */
    public static function find($id, $id_lang = null)
    {
        $classname = get_called_class();
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();
        $entity->setId($id);

        $qb = new QueryBuilder($entity);
        $qb->setLang($id_lang);
        if (is_array($id)) {

            return $qb->whereIn("this.id", $id)->get();
        }

        return $qb->select()->where("this.id", "=", $id)
            ->getInstance();

    }

    /**
     * return the entity
     * when recursif set to false, attribut as relation manyToOne has just their id hydrated
     * when recursif set to true, the DBAL does recursif request to hydrate the association entity and those of it.
     * @param type $id the id of the entity
     * @param boolean $recursif [true] tell the DBAL to find all the data of the relation
     * @return \QueryBuilder
     */
    public static function delete($id = null, $force = false)
    {

        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        if (is_array($id)) {
            $qb = new QueryBuilder($entity);
            return $qb->whereIn("this.id", $id)->delete($force);
        } elseif (is_numeric($id)) {
            $entity->setId($id);
            $dbal = new DBAL();
            return $dbal->deleteDbal($entity, $force);
        } else {
            $qb = new QueryBuilder($entity);
            return $qb->delete($force);
        }

    }

    /**
     *
     * @param string $sort
     * @param type $order
     * @return type
     */
    public static function all($sort = 'id', $order = "asc", $id_lang = null)
    {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        if ($entity->dvtranslate) {
            $qb->setLang($id_lang);
        }
        if ($sort == 'id')
            $sort = $qb->getTable() . "." . $sort;

        return $qb->select()->handlesoftdelete()->orderby($sort . " " . $order)->get();

    }

    /**
     * Return an array of rows as in database.
     * @example http://easyprod.spacekola.com/doc/#allrow
     * @param String $att the attribut you want to order by
     * @param String $order the ordering model ( ASC default, DESC, RAND() )
     * @return Array
     */
    public static function allrows($sort = 'id', $order = "", $id_lang = null)
    {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        if ($entity->dvtranslate) {
            $qb->setLang($id_lang);
        }
        if ($sort == 'id')
            $sort = $qb->getTable() . "." . $sort;

        return $qb->select()
            //->handlesoftdelete()
            ->orderBy($sort . " " . $order)->get();
    }

    public static function trashed($sort = 'id', $order = "", $id_lang = null)
    {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        if ($entity->dvtranslate) {
            $qb->setLang($id_lang);
        }
        if ($sort == 'id')
            $sort = $qb->getTable() . "." . $sort;

        return $qb->select()
            ->handlesoftdelete()
            ->orderBy($sort . " " . $order)->trashed();
    }


    /**
     * return instance of \QueryBuilder white the select request sequence.
     * @param string $columns
     * @return \QueryBuilder
     * @example name, description, category if none has been set, all will be take.
     */
    public static function select($columns = '*', $id_lang = null, $defaultjoin = true)
    {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity, $defaultjoin);
        if ($entity->dvtranslate) {

            $qb->setLang($id_lang);
        }
        return $qb->select($columns);
    }

    /**
     * return instance of \QueryBuilder with the select request sequence without the default join.
     * @param string $columns
     * @return \QueryBuilder
     * @example name, description, category if none has been set, all will be take.
     */
    public static function initQb($columns = '*', $id_lang = null)
    {
        return self::select($columns, $id_lang, false);
    }

    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @return QueryBuilder
     */
    public static function where($column, $operator = null, $value = null, $id_lang = null)
    {
        return self::select("*", $id_lang)->where($column, $operator, $value);
    }

    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @return QueryBuilder
     */
    public static function where_str($column, $link = "AND", $id_lang = null)
    {
        return self::select("*", $id_lang)->where_str($column, $link);
    }

    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @return QueryBuilder
     */
    public static function with($entity)
    {
        return self::select()->with($entity);
    }

    /**
     * @param $column
     * @param $collection
     * @return QueryBuilder
     */
    public static function whereIn($column, $collection)
    {
        return self::select()->whereIn($column, $collection);
    }

    public static function join($classname, $classnameon = null, $id_lang = null)
    {
        return self::select("*", $id_lang)->leftjoin($classname, $classnameon);
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
     * return instance of \QueryBuilder white the select request sequence.
     * @param string $columns
     * @return QueryBuilder
     * @example name, description, category if none has been set, all will be take.
     */
    public static function orderBy($column, $sort = "")
    {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->orderBy($column, $sort);

    }
    /**
     * return instance of \QueryBuilder white the select request sequence.
     * @param string $columns
     * @return float
     * @example name, description, category if none has been set, all will be take.
     */
    public static function sum($columns)
    {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->sum($columns);

    }

    public static function avg($columns, $as = "")
    {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);

        return $qb->avg($columns, $as);
    }

    public static function max($columns, $as = "")
    {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->max($columns, $as);
    }

    public static function distinct($columns)
    {
        $reflection = new ReflectionClass(get_called_class());
        $entity = $reflection->newInstance();

        $qb = new QueryBuilder($entity);
        return $qb->distinct("$columns");
    }

    public function inCollectionOf($collection, $key_map = "")
    {

        if (!$this->getId())
            return [];

        $thisclass = get_class($this);
        $entityTable = $collection;
        $entity_id = "id";

        $dbal = new DBAL();
        if ($key_map) {
            // do nothing
            $entityTable = $key_map;
        } elseif ($dbal->tableExists($collection . '_' . $thisclass)) {
            $entityTable = $collection . '_' . $thisclass;
            $entity_id = $collection . "_id";
        } elseif ($dbal->tableExists($thisclass . "_" . $collection)) {
            $entityTable = $thisclass . "_" . $collection;
            $entity_id = $collection . "_id";
        }
//        else {
//            $association = false;
//            $entityTable = $entityName;
//            $direction = "lr";
//        }

        $collection_ids = [];

        $dbal = new DBAL();
        $results = $dbal->executeDbal(strtolower(" select $entity_id from `$entityTable` where " . $thisclass . "_id = " . $this->getId()), [], DBAL::$FETCHALL);
        foreach ($results as $index => $values)
            $collection_ids[] = $values[0];
        //$result = $result[$index][0];

        return $collection_ids;
        //return implode(",", $collection_ids);
    }

    public function entityKey($fieldNames, &$entity_link_list = null, &$collection = null, &$softdelete = null)
    {
        $keys = [];
        foreach ($this as $key => $val) {
            if (isset($fieldNames[$key]))
                $keys[$key] = $val;
        }
        return  $keys;
        // $softdelete = $this->dvsoftdelete;

        /*if(get_class($this) == "User") {
            var_dump($this);
            //die;
        }*/
        foreach ($this as $key => $val) {
            if (in_array($key, self::$dvkeys))
                continue;
            if (is_object($val)) {
                //var_dump(get_class($val));
                // $entity_link_list[strtolower(get_class($val) . ":" . $key)] = $val;
                $keys[$key . '_id'] = $val->getId();
//            } else if (is_array($val))
//                // $collection[] = $val;
            } else
                $keys[$key] = $val;
        }
        //var_dump($this->dvtranslated_columns);

        return $keys;
    }

    public function entityKeyForm()
    {
        $keys = [];

        foreach ($this as $key => $val) {
            if (in_array($key, self::$dvkeys))
                continue;
            if (is_object($val)) {
                $keys[$key . '.id'] = $val->getId();
            } else
                $keys[$key] = $val;
        }
        return $keys;
    }

}