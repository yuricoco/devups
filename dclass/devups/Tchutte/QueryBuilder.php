<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QueryBuilder
 *
 * @author Aurelien Atemkeng
 */
class QueryBuilder extends \DBAL
{

    public static $debug = false;

//    private $table;
    public $_select = "";
    public $_from = "";
    public $_set = "";
    public $_into = "";
    public $_select_option = "*";
    public $_where = "";
    public $_join = "";
    public $_order_by = "";
    public $_limit = "";

    private $query = "";
    private $sequence = "";
    private $parameters = [];
    private $columns = "*";
    //private $defaultjoin = "";
    private $columnscount = "COUNT(*)";
    private $endquery = "";
    private $initwhereclause = false;
    private $defaultjoinsetted = true;

    /**
     * All of the available clause operators.
     *
     * @var array
     */
    private $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>',
        'like', 'like binary', 'not like', 'between', 'ilike', 'is',
        '&', '|', '^', '<<', '>>',
        'rlike', 'regexp', 'not regexp',
        '~', '~*', '!~', '!~*', 'similar to',
        'not similar to', 'not ilike', '~~*', '!~~*',
    ];

    public $tablecollection = [];
    private $joincollection = [];


    public function __construct($entity = null, $defaultjoinsetted = true)
    {
        $this->initwhereclause = false;
        if (is_object($entity))
            parent::__construct($entity);

        $this->_from = "`" . strtolower($this->table) . "`";
        if ($defaultjoinsetted) {
            $this->defaultjoinsetted = $defaultjoinsetted;
            $this->initdefaultjoin();
        }
//        $this->table = strtolower(get_class($entity));
    }

    /**
     * Set the columns to be selected.
     *
     * @param array|mixed $columns
     * @return string
     */
    public function close(\QueryBuilder &$qb)
    {
        $this->initSelect();
        $this->sequensization();

        $qb->addParameter($this->parameters);

        return $this->query;
    }

    public function addParameter($parameters)
    {
        $this->parameters += $parameters;
    }

    /**
     * Set the columns to be selected.
     *
     * @param array|mixed $columns
     * @return $this
     * @example name, description, category
     * @example name, description, category
     */
    public function setLang($id_lang)
    {
        $this->id_lang = $id_lang;
        DBAL::$id_lang_static = $id_lang;
        return $this;
    }

    /**
     * Set the columns to be selected.
     *
     * @param array|mixed $columns
     * @return $this
     * @example name, description, category
     * @example name, description, category
     */
    public function select($columns = '*', $object = null, $defaultjoin = true)
    {
        $this->softdeletehandled = false;
        $this->defaultjoin = "";
        if (is_object($columns)):
            $this->instanciateVariable($columns);
            $columns = "*";
        elseif (is_bool($object)):
            $defaultjoin = $object;
        elseif (is_object($object)):
            $this->instanciateVariable($object);
        endif;

        if ($columns == '*') {
            $columns = "this.`" . implode("`, this.`", $this->objectVar) . "`";
            if ($this->object->dvtranslate && DBAL::$id_lang_static) {

                $thislang = $this->table . "_lang";
                $columns .= ", " . $thislang . ".`" . implode("`, $thislang.`", $this->object->dvtranslated_columns) . "`";
            }
        }
        if ($this->object->dvtranslate && !in_array($this->table . "_lang", $this->joincollection) && DBAL::$id_lang_static) {
            $this->joincollection[] = $this->table . "_lang";
            $this->leftjoinrecto($this->table . "_lang")
                ->where($this->table . "_lang.lang_id", "=", $this->id_lang);

        }
        $this->columns = $columns;
        $this->_select_option = $columns;
        $this->query = " ";

        return $this;
    }

    public function addColumns(...$columns)
    {
        $this->custom_columns .= implode(", ", $columns);
        return $this;
    }

    /**
     * @param bool $update
     * @return $this
     */
    public function from($collection)
    {

//        $classname = [];
//        foreach ($collection as $val)
//            $classname[] = strtolower(get_class($val));

        $this->tablecollection = implode("`, `", $collection);
        $this->_from = strtolower($this->tablecollection);
        return $this;
    }

    /**
     * @param bool $update
     * @return $this
     */
    public function __dclone($update = false)
    {
        unset($this->objectVar[0]);
        $col = "`" . strtolower(implode('`,`', $this->objectVar)) . "`";
        $objectVar = explode(",", $col);
        if ($update)
            foreach ($objectVar as $i => $var) {
                foreach ($update as $key => $value) {
                    if ($var == "`" . $key . "`") {
                        $objectVar[$i] = "'" . $value . "'";
                        unset($update[$key]);
                    }
                }
//                if(count($update))
//                    break;
            }

        $this->query = " insert into " . $this->_from . " (" . $col . ") select " . strtolower(implode(' ,', $objectVar)) . " from {$this->_from} ";
        return $this;
    }

    private function sequensization()
    {
        $query = $this->query;
        $query .= " WHERE 1 ";
        if ($this->_where)
            $query .= " {$this->_where} ";

        if ($this->softdelete) {
            if ($this->hasrelation)
                $query .= ' AND ' . $this->table . '.deleted_at IS NULL ';
            else
                $query .= ' AND deleted_at IS NULL ';
        }


        if ($this->_order_by)
            $query .= " {$this->_order_by} ";

        if ($this->_limit)
            $query .= " {$this->_limit} ";

        $this->query = $this->querysanitize($query);

        return $this;

    }

    /**
     * @return boolean | $this
     */
    public function delete($exec = true)
    {

        if ($this->softdelete) {
            $this->query = " UPDATE " . $this->table . " SET deleted_at = NOW() ";
        } else
            $this->query = "  DELETE FROM {$this->_from} ";

        if (!$this->initwhereclause) {
            $this->_where = " AND id = " . $this->instanceid;
        }
        if ($exec)
            return $this->sequensization()->exec();

        return $this->sequensization()->exec();
    }

    /**
     *
     * @param type $arrayvalues
     * @param type $seton
     * @param type $case
     * @return boolean
     */
    public function update($arrayvalues = null, $seton = null, $case = null)
    {

        $this->columns = null;
        $this->query = "  UPDATE {$this->_from} ";

        if ($this->_join)
            $this->query .= " {$this->_join} ";

        if ($arrayvalues)
            return $this->set($arrayvalues, $seton, $case)->sequensization()->exec();

        return $this->sequensization()->exec();
    }

    public function set($arrayvalues, $seton = null, $case = null)
    {

        $this->_set = " SET ";

        // update a column on multiple rows
        if (is_object($arrayvalues)) {
            $class = strtolower(get_class($arrayvalues));
            $this->parameters[$class . "_id"] = $arrayvalues->getId();
            $this->_set .= " " . $this->table . "." . $class . "_id = :" . $class . "_id";
            if ($this->instanceid)
                $this->endquery = " AND " . $this->table . ".id = " . $this->instanceid;
        } elseif (is_array($case)) {
            $whens = [];
            $this->_set .= " `" . $arrayvalues . "` = CASE " . $seton . " ";

            foreach ($case as $when => $then) {
                $whens[] = $when;
                $this->parameters[$when] = $then;
                $this->_set .= " WHEN '$when' THEN :$when ";
            }

            $this->_set .= " ELSE  $seton END ";

            $whens = implode("', '", $whens);
            $this->endquery = " AND `" . $arrayvalues . "`  IN('" . $whens . "'); ";
        } // update one column on one row
        elseif ($arrayvalues && $seton != null) {
            //elseif (true) {
            $this->parameters[$arrayvalues] = $seton;
            $this->_set .= " $arrayvalues = :$arrayvalues ";
            $this->endquery = " AND " . $this->table . ".id = " . $this->instanceid;
        } // update multiple column on one row
        else {
            $arrayset = [];

            if ($this->object->dvtranslate ) {

                // we check of attribut translable is present in the arrayvalue to update for an entity dvtranslated
                // then if $attribnotexist comes with the same value of dvtranslated_columns that mean non translable attribute
                // has been setted for update
                $attribnotexist = array_diff($this->object->dvtranslated_columns, array_keys($arrayvalues));

                if ($attribnotexist != $this->object->dvtranslated_columns) {

                    $objarray = $arrayvalues;
                    if ($this->object->dvid_lang) {
                        $parameterQuery = [];
                        $keyvalue = [];
                        foreach ($this->object->dvtranslated_columns as $key) {
                            if (!isset($objarray[$key]))
                                continue;

                            $parameterQuery[] = ' `' . $key . '`= :' . $key;
                            $keyvalue[$key] = $objarray[$key];
                            unset($arrayvalues[$key]);
                        }
                        $this->updateLangValue($keyvalue, $parameterQuery, $this->object->dvid_lang);
                    } else {
                        // dv_dump($this->object->dvtranslated_columns, $arrayvalues);
                        $langs = Dvups_lang::allrows();
                        foreach ($langs as $lang) {
                            $parameterQuery = [];
                            $keyvalue = [];
                            foreach ($this->object->dvtranslated_columns as $key) {
                                if (!isset($objarray[$key]))
                                    continue;
                                $parameterQuery[] = ' `' . $key . '`= :' . $key;
                                $keyvalue[$key] = $objarray[$key][$lang->getIso_code()];

                                unset($arrayvalues[$key]);
                            }

                            $this->updateLangValue($keyvalue, $parameterQuery, $lang->getId());
                        }
                    }
                }
            }

            foreach ($arrayvalues as $key => $value) {

                $keymap = explode(".", $key);
                $attrib = str_replace('.', '_', $key);

                $dot = "`";
                if (count($keymap) == 2)
                    $dot = "";

                if (is_object($value)) {

                    $this->parameters[strtolower(get_class($value)) . "_id"] = $value->getId();
                    $arrayset[] = strtolower(get_class($value)) . "_id = :" . strtolower(get_class($value)) . "_id";

                } else {
                    $this->parameters[$attrib] = $value;
                    $arrayset[] = $dot . implode('.`', $keymap) . "` = :" . $attrib;
                }
            }
            $this->_set .= implode(", ", $arrayset);
            if ($this->instanceid)
                $this->endquery = " AND " . $this->table . ".id = " . $this->instanceid;
        }

        $this->query .= $this->_set;

        return $this;

    }

    /**
     * Set the columns to be selected.
     *
     * @param array|mixed $columns
     * @return $this
     */
    public function join($joins, $type = " LEFT JOIN ")
    {
        // todo: to be thinked
        foreach ($joins as $key => $value)
            $join = $type . " ";
        return $this;
    }

    public function initdefaultjoin()
    {

        $this->defaultjoinsetted = true;
        if (!empty($this->entity_link_list)) {
            $entity_links = array_keys($this->entity_link_list);
            foreach ($entity_links as $entity_link) {
                $class_attrib = explode(":", $entity_link);
                if ($class_attrib[0] != $class_attrib[1])
                    $this->defaultjoin .= " LEFT JOIN `" . $class_attrib[0] . "` `" . $class_attrib[1] . "` ON `" . $class_attrib[1] . "`.id = " . $this->table . "." . $class_attrib[1] . "_id";
                else
                    $this->defaultjoin .= " LEFT JOIN `" . $class_attrib[0] . "` ON `" . $class_attrib[0] . "`.id = {$this->table}." . $class_attrib[0] . "_id";
            }
        }
        $this->_join .= $this->defaultjoin;

        return $this;
    }

    /**
     * init innerjoin of the $classname, base on the $classnameon. if the $classnameon is not specified, it will be set as the current
     * class
     * @param string $classname
     * @param string $classnameon
     * @param string $constraint
     * @return $this
     */
    public function innerjoin($classname, $classnameon = "", $constraint = "")
    {

        $join = strtolower($classname);

        if (!$classnameon)
            $classnameon = $this->table;

        $this->_join .= " INNER JOIN `" . $join . "` ON ( `" . $join . "`.id = `" . strtolower($classnameon) . "`." . $join . "_id $constraint ) ";

        return $this;
    }

    public function join_str($classname, $on)
    {
        $join = strtolower($classname);

        $this->_join .= " INNER JOIN `" . $join . "` ON ( $on ) ";

        return $this;
    }

    /**
     * init leftjoin of the $classname, base on the $classnameon. if the $classnameon is not specified, it will be set as the current
     * class
     * @param string $classname
     * @param string $classnameon
     * @param string $constraint
     * @return $this
     */
    public function leftjoin($classname, $classnameon = "", $constraint = "")
    {
        $join = strtolower($classname);

        if (!$classnameon)
            $classnameon = $this->table;

        $this->_join .= " LEFT JOIN `" . $join . "` ON ( `" . $join . "`.id = `" . strtolower($classnameon) . "`." . $join . "_id $constraint )";

        return $this;
    }

    /**
     * rather than take relation.id = table.relation_id to create the link,
     * it uses relation.table_id = table.id
     *
     * class
     * @example get all the post in different timeline (timelineuser, timelinepage, timelinegroup, ...) timeline's got post_id
     * but post doesn't have timeline's id. therefore to establish the relation, we need inverse the usual way. also we use left join
     * because it support null value, again right join and inner join
     * @param string $classname
     * @param string $classnameon
     * @return $this
     */
    public function leftjoinrecto($classname, $classnameon = "", $alias = "")
    {
        $this->join = strtolower($classname);

        if (!$classnameon)
            $classnameon = $this->objectName;

        if (!$alias)
            $alias = $this->join;

        $this->_join .= " INNER JOIN `" . $this->join . "` `$alias` ON `" . $alias . "`." . strtolower($classnameon) . "_id = `" . strtolower($classnameon) . "`.id";

        return $this;
    }

    public function on($entity)
    {
        //" left join `".strtolower(get_class($entity)).
        $this->query .= " ON `" . $this->join . "`.id = `" . strtolower(get_class($entity)) . "`." . $this->join . "_id";

        return $this;
    }

    public $softdeletehandled = false;

    public function handlesoftdelete()
    {

        if ($this->softdeletehandled)
            return $this;

        if ($this->softdelete) {
            if ($this->hasrelation)
                $this->query .= ' WHERE ' . $this->table . '.deleted_at IS NULL ';
            else
                $this->query .= ' WHERE deleted_at IS NULL ';
        }

        $this->softdeletehandled = true;
        return $this;

    }

    public function whereMonth($column)
    {

    }

    /**
     * Add a basic where clause to the query.
     *
     * @param string|array|\Closure $column
     * @param string|null $operator
     * @param mixed $value
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $link = "AND")
    {
        $this->endquery = "";

//        if($this->initwhereclause && $link == "where")
//            $link = "and";

        if (is_object($column)) {

            $attrib = strtolower(get_class($column)) . '_id';
            if ($this->defaultjoinsetted) {
                $this->_where .= " " . $link . " " . strtolower(get_class($column)) . '.id';
            } else
                $this->_where .= " " . $link . " " . $attrib;

            if ($column->getId()) {
                if ($operator == "not") {
                    $this->_where .= " != :$attrib";
                } else {
                    $this->_where .= " = :" . $attrib;
                }
                $this->parameters[$attrib] = $column->getId();
            } else {
                $this->_where .= " is null ";
            }
        } elseif (is_array($column)) {
            if (is_array($operator)) {
                for ($index = 0; $index < count($column); $index++) {
                    $this->where($column[$index], "=", $operator[$index]);
                }
            }
            // todo: handle the operation as we do for the lazyloading api
            /*elseif (is_array($column[0])) {
                foreach ($column as $value) {
                    $this->andwhere($value[0], $value[1], $value[2]);
                }
            }*/
            else {
                foreach ($column as $key => $value) {
                    $this->where($key, "=", $value);
                }
            }
        } else {
            $keymap = explode(".", $column);
            $attrib = str_replace(".", "_", $column);
            if (count($keymap) == 2) {
                $this->_where .= " " . $link . " " . $column;
            } else {
                $keymapattr = explode(" ", $column);
                if (count($keymapattr) >= 2) {
                    $column = $keymapattr[0];
                    unset($keymapattr[0]);
                    $extra = implode(" ", $keymapattr);
                    $this->_where .= " " . $link . ' `' . $column . "` " . $extra;
                } else
                    $this->_where .= " " . $link . ' `' . $column . "` ";
            }
            //$this->query .= " " . $link . " " . $column;
            if ($operator) {
                if (in_array($operator, $this->operators)) {
                    $this->_where .= " " . $operator . " :$attrib";
                    $this->parameters[$attrib] = $value;
                } elseif (strtolower($operator) == "like") {
                    $this->_where .= " LIKE '%" . $operator . "%' ";
                } else {
                    $this->_where .= " = :" . $attrib;
                    $this->parameters[$attrib] = $operator;
                }
            }
        }

        $this->initwhereclause = true;

        return $this;
    }

    public function andwhere($column, $sign = null, $value = null)
    {
        return $this->where($column, $sign, $value, 'and');
    }

    public function orWhere($column, $sign = null, $value = null)
    {
        return $this->where($column, $sign, $value, 'OR');
    }

    public function orWhere_str($constraint)
    {
        return $this->where_str($constraint, 'OR');
    }

    public function where_str($constraint, $link = "AND")
    {
        $this->_where .= " " . $link . " " . $constraint;
        return $this;
    }

    public function whereIn($column, $values, $negate = "")
    {

        if (is_array($values)) {
            $this->_where .= " AND $column $negate IN (" . implode(",", array_map("qb_sanitize", $values)) . ")";
        } else
            $this->_where .= " AND $column $negate IN ( $values )";

        return $this;
        // return $this->where($column)->in($collection);
    }

    /**
     *
     * @param String|Array $values
     * @return $this
     */
    public function in($values)
    {
        if (is_array($values)) {
            $this->_where .= " in (" . implode(",", array_map("qb_sanitize", $values)) . ")";
        } else
            $this->_where .= " in ( $values )";

        return $this;
    }

    /**
     * @param $values
     * @return $this
     */
    public function notIn($values)
    {
        if (is_array($values)) {
            $this->_where .= " NOT IN (" . implode(",", array_map("qb_sanitize", $values)) . ")";
        } else
            $this->_where .= " NOT IN ( $values )";

        return $this;
    }

    public function whereNull($column)
    {
        $this->_where .= " AND $column IS NULL ";

        return $this;
    }

    public function whereNotNull($column)
    {
        $this->_where .= " AND $column IS NOT NULL ";

        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @param string $constraint specify the constraint of like. the value is either "" = %value%; l = value%; r = %value
     * @return $this
     */
    public function whereLike($column, $value, $constraint = "")
    {
        if ($constraint == "l")
            $this->_where .= " AND $column  LIKE '" . $value . "%' ";
        elseif ($constraint == "r")
            $this->_where .= " AND $column  LIKE '%" . $value . "' ";
        else
            $this->_where .= " AND $column  LIKE '%" . $value . "%' ";

        return $this;
    }

    public function like($value)
    {
//        if (is_array($values))
//            $this->query .= " LIKE '%" . implode(",", $values) . "%'";
//        else
        $this->_where .= " LIKE '%" . $value . "%' ";

        return $this;
    }

    public function _like($value)
    {
        $this->_where .= " LIKE '%" . $value . "' ";
        return $this;
    }

    public function like_($value)
    {
        $this->_where .= " LIKE '" . $value . "%' ";
        return $this;
    }

    public function groupBy($critere)
    {
        $this->_where .= " GROUP BY " . $critere;
        return $this;
    }

    public function between($value1, $value2)
    {
        $this->_where .= " BETWEEN '" . $value1 . "' AND '" . $value2 . "'";
        return $this;
    }

    public function orderBy($critere, $order = "")
    {
        $this->_order_by .= " ORDER BY " . $critere . " " . $order;
        return $this;
    }

    public function rand()
    {
        $this->_order_by .= " ORDER BY RAND() ";
        return $this;
    }

    public function limit($start = 1, $max = null)
    {
        if ($start < 0) {
            $qb = $this;
            $i = (int)$start;
            $nbel = $qb->count();
            if ($nbel + $i > 0) {

                //$i += $nbel;
                $this->_limit = " LIMIT " . ($nbel + $i) . ", " . abs($nbel);
                // return $qb->select()->limit($i - 1, $i)->__getOne($recursif, $collect);
                return $this;
            }
            $start = 0;
            $max = $nbel;
        }

        if ($max)
            $this->_limit = " LIMIT " . $start . ", " . $max;
        else
            $this->_limit = " LIMIT " . $start;
        // $this->_where .= $this->_limit;
        return $this;
    }

    /**
     * @param int $index
     * @param bool $recursif
     * @param array $collect
     * @return type|null
     * @deprecated use index
     */
    public function index($index = 1, $recursif = true, $collect = [])
    {
        $i = (int)$index;

        if ($i < 0) {
            $nbel = (int)$this->count();
            if ($nbel == 1)
                return $this->object;

            $i += $nbel;
            return $this->limit($i - 1, $i)->getInstance($recursif, $collect);
        }

        return $this->limit($i - 1, $i)->getInstance($recursif, $collect);
    }

    private function initquery($columns)
    {
        if ($this->tablecollection)
            return " select " . $columns . " from `" . $this->tablecollection . "` ";

        return " select " . $columns . " from {$this->_from} ";
    }

    protected function querysanitize($sql)
    {
        return str_replace("this.", "{$this->_from}.", $sql);
    }

    public function getSqlQuery()
    {
        $this->initSelect();
        $this->sequensization();
        return ["sql" => $this->query, "parameters" => $this->parameters];
    }

    public function exec($action = 0)
    {
        if (in_array($action, [DBAL::$FETCH, DBAL::$FETCHALL]))
            return $this->executeDbal($this->querysanitize($this->initquery($this->columns) . $this->defaultjoin . $this->query . $this->_where), $this->parameters, $action);

        return $this->executeDbal($this->querysanitize($this->query . $this->_where . $this->endquery), $this->parameters, $action);
    }


    public function first($recursif = true, $collect = [])
    {
        if (is_numeric($recursif))
            $this->limit_iteration = $recursif;

        // $this->setCollect($collect);
        // ->limit(1)
        return $this->getInstance();
    }

    /**
     * @param bool $recursif
     * @param array $collect
     * @return type|null
     * @deprecated uses  firstOrNull
     */
    public function __firstOrNull($recursif = true, $collect = [])
    {
        $model = $this->first($recursif, $collect);

        if ($model->getId())
            return $model;

        return null;
    }

    public function firstOrNull($recursif = true, $collect = [])
    {
        $model = $this->first($recursif, $collect);

        if ($model->getId())
            return $model;

        return null;
    }

    /**
     * @param $callback
     * @param bool $recursif
     * @param array $collect
     * @return type|null
     * @deprecated  use firstOr
     */
    public function __firstOr($callback, $recursif = true, $collect = [])
    {
        $this->firstOr($callback, $recursif);
    }

    public function firstOr($callback, $recursif = true, $collect = [])
    {

        $model = $this->getInstance($recursif, $collect);

//        if(is_bool($model))
//            dv_dump($model, $this->getSqlQuery());

        if ($model)
            return $model;

        if (is_callable($callback))
            return $callback();

        dv_dump("callback is not callable");
    }

    public function getLast($recursif = true, $collect = [])
    {
        return $this->orderBy($this->table . ".id DESC ")->limit(1)->getInstance($recursif, $collect);
    }

    public function getIndex($index, $recursif = true, $collect = [])
    {
        if (is_numeric($recursif))
            $this->limit_iteration = $recursif;

        $this->setCollect($collect);
        $i = (int)$index;
        return $this->limit($i - 1, $i)->getInstance($recursif);
    }

    public function __exportAllRow($callback)
    {
        return $this->__findAllRow($this->querysanitize($this->initquery($this->columns) . $this->query . $this->_where), $this->parameters, $callback);
    }

    /**
     * @return array
     * @deprecated use get
     */
    public function __getAllRow()
    {
        return $this->get();
    }

    private function initSelect($columns = "*")
    {
        $this->query = " SELECT {$this->_select_option} ";
        if ($this->custom_columns != "")
            $this->query .= ", {$this->custom_columns}";
        $this->query .= " FROM " . $this->_from;

        if ($this->_join)
            $this->query .= " {$this->_join} ";

    }


    public function getInstanceAtIndex($index, $recursif = true, $collect = [])
    {
        $this->setCollect($collect);
        $i = (int)$index;
        return $this->limit($i - 1, $i)->getInstance($recursif);
    }

    public function count($column = "*", $as = "")
    {
        if ($as)
            $as = " AS " . $as;

        $this->_select_option = " COUNT(" . $column . ") $as ";
        return $this->getValue();
    }

    public function sum($column, $as = "")
    {
        if ($as)
            $as = " AS " . $as;

        $this->_select_option = " SUM($column) $as ";
        return $this->getValue();

    }

    public function avg($column, $as = "")
    {
        if ($as)
            $as = " AS " . $as;

        $this->_select_option = " AVG(" . $column . ") $as ";
        return $this->getValue();
    }

    public function max($column, $as = "")
    {
        if ($as)
            $as = " AS " . $as;

        $this->_select_option = " MAX(" . $column . ") $as ";
        return $this->getValue();

    }

    public function min($column, $as = "")
    {
        if ($as)
            $as = " AS " . $as;

        $this->_select_option = " MIN(" . $column . ") $as ";
        return $this->getValue();
    }

    public function distinct($column)
    {
        return $this->get(" DISTINCT " . $column);
    }


    /**
     * @param bool $recursif
     * @param array $collect
     * @return array
     * @deprecated use get
     */
    public function __getAll($column = true, $collect = [])
    {
        return $this->get($column);
    }

    public function cursor($callback)
    {
        $this->initSelect();
        $this->sequensization();

        return $this->__cursor($this->query, $this->parameters, $callback);

    }

    /**
     * @return Object
     * @deprecated use row
     */
    public function __getOneRow()
    {
        return $this->getInstance();
    }

    /**
     * @param bool $recursif
     * @param array $collect
     * @return mixed|null
     * @deprecated use getInstance
     */
    public function __getOne($recursif = true, $collect = [])
    {
        return $this->getInstance();
    }

    /**
     * @param bool $recursif
     * @param false $defaultjoin
     * @return mixed
     * @deprecated use count
     */
    public function __countEl($recursif = true, $defaultjoin = false)
    {
        //$this->setCollect($collect);
        if ($defaultjoin):
            $this->initdefaultjoin();
        endif;

        return $this->__count($this->querysanitize($this->initquery($this->columnscount) . $this->defaultjoin . $this->query . $this->_where), $this->parameters, false, $recursif);
    }

    /**
     *
     * @param string $order
     * @return \dclass\devups\Datatable\Lazyloading | $this
     */
    public function lazyloading($order = "", $debug = false, $qbinstance = false)
    {

        $ll = new \dclass\devups\Datatable\Lazyloading($this->object);
        $ll->debug = $debug;
        //$ll->start($this->object);

        return $ll->lazyloading($this->object, $this, $order, null, $qbinstance);

    }

    /**
     *
     * @param string $order
     * @return \dclass\devups\Datatable\Lazyloading
     */
    public function perPage($perpage = 10)
    {

        $ll = new \dclass\devups\Datatable\Lazyloading($this->object, $this);

        return $ll->setPerPage($perpage);

    }

    /**
     *
     * @param string $order
     * @return \dclass\devups\Datatable\Lazyloading
     */
    public function nextPage($page = 1)
    {

        $ll = new \dclass\devups\Datatable\Lazyloading($this->object, $this);

        return $ll->setNext($page);

    }

    public function row()
    {

        $this->initSelect();
        $this->query .= $this->_join;
        $this->sequensization();

        if (self::$debug)
            return $this->getSqlQuery();

        return $this->__findOneRow($this->query, $this->parameters);

    }

    /*public function getRows($callbackexport = null)
    {
        $this->initSelect();
        $this->query .= $this->_join;
        $this->sequensization();

        if (self::$debug)
            return $this->getSqlQuery();

        return $this->__findAllRow($this->query, $this->parameters, $callbackexport);
    }*/

    public function getInstance($column = "*", $collect = [])
    {
        $this->select($column);
        $this->initSelect();
        $this->sequensization();

        if (self::$debug)
            return $this->getSqlQuery();

        return $this->__findOneRow($this->query, $this->parameters);
    }

    public function get($column = "*", $recursif = true, $collect = [])
    {
        $this->select($column);
        $this->initSelect();
        $this->sequensization();

        if (self::$debug)
            return $this->getSqlQuery();

        return $this->__findAll($this->query, $this->parameters);

    }

    public function getRows($column = "*", $asobject = false)
    {
        $this->select($column);
        $this->initSelect($column);
        $this->sequensization();

        if (self::$debug)
            return $this->getSqlQuery();

        if ($asobject)
            return (object) $this->__findAllRow($this->query, $this->parameters);

        return $this->__findAllRow($this->query, $this->parameters);

    }

    public function getValue()
    {
        // todo: put select() here
        $this->initSelect();
        $this->sequensization();

        if (self::$debug)
            return $this->getSqlQuery();

        $value = $this->executeDbal($this->query, $this->parameters, DBAL::$FETCH);
        if (is_array($value))
            return $value[0];

        return $value;
    }

}
