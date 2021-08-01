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
class QueryBuilderNew extends \DBAL
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

    public function __construct($entity = null, $defaultjoinsetted = true)
    {
        $this->initwhereclause = false;
        if (is_object($entity))
            parent::__construct($entity);

        if($defaultjoinsetted) {
            $this->defaultjoinsetted = $defaultjoinsetted;
            $this->join();
        }
//        $this->table = strtolower(get_class($entity));
    }

    /**
     * Set the columns to be selected.
     *
     * @param array|mixed $columns
     * @return $this
     */
    public function addselect($columns = "*", $object = null, $defaultjoin = true)
    {

        // save currente sequence
        $this->querysequence = $this->query;
        $this->wheresequence = $this->_where;
        $this->sequenceobject = $this->object;

        if (is_object($columns)):
            $this->instanciateVariable($columns);
            $columns = "*";
        elseif (is_bool($object)):
            $defaultjoin = $object;
        elseif (is_object($object)):
            $this->instanciateVariable($object);
        endif;

        $this->defaultjoinsetted = $defaultjoin;
        $this->query = " select $columns from `" . $this->table . "` ";
        $this->_where = "";

        if ($defaultjoin) {

            if (!empty($this->entity_link_list)) {
                $entity_links = array_keys($this->entity_link_list);
                foreach ($entity_links as $entity_link) {
                    $class_attrib = explode(":", $entity_link);
                    if( $class_attrib[0] != $class_attrib[1])
                        $this->query .= " left join `" . $class_attrib[0]."` ".$class_attrib[1] . " on " . $class_attrib[1] . ".id = " . $this->table . "." . $class_attrib[1] . "_id";
                    else
                        $this->query .= " left join `" . $class_attrib[0]."` on " . $class_attrib[0] . ".id = " . $this->table . "." . $class_attrib[0] . "_id";
                }
            }
        }

        return $this;
    }

    public function close()
    {
//        $params = $this->parameters;
        $query = $this->query.$this->_where;

        // restaure sequence before any other select
        $this->query = $this->querysequence;
        $this->_where = $this->wheresequence;

        $this->instanciateVariable($this->sequenceobject);

        return $query;
    }


    /**
     * Set the columns to be selected.
     *
     * @param array|mixed $columns
     * @return $this
     */
    public function join()
    {
        $this->defaultjoinsetted = true;
        if (!empty($this->entity_link_list)) {
            $entity_links = array_keys($this->entity_link_list);
            foreach ($entity_links as $entity_link) {
                $class_attrib = explode(":", $entity_link);
                if( $class_attrib[0] != $class_attrib[1])
                    $this->defaultjoin .= " left join `" . $class_attrib[0]."` ".$class_attrib[1] . " on " . $class_attrib[1] . ".id = " . $this->table . "." . $class_attrib[1] . "_id";
                else
                    $this->defaultjoin .= " left join `" . $class_attrib[0]."` on " . $class_attrib[0] . ".id = " . $this->table . "." . $class_attrib[0] . "_id";
            }
        }
        $this->_join = $this->defaultjoin;

        return $this;
    }

    /**
     * Set the columns to be selected.
     *
     * @example name, description, category
     * @param  array|mixed $columns
     * @return $this
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

        $this->columns = $columns;
        $this->query = " ";
        $this->_select = " SELECT $columns FROM ";

        if ($defaultjoin):
            $this->join();
        endif;

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
        $this->_from = $this->tablecollection;
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

        $this->query = " insert into `" . $this->table . "` (" . $col . ") select " . strtolower(implode(' ,', $objectVar)) . " from `" . $this->table . "` ";
        return $this;
    }

    private function sequensization(){
        if($this->_where)
            $this->query .= " {$this->_where} ";

        if($this->_order_by)
            $this->query .= " {$this->_order_by} ";

        if($this->_limit)
            $this->query .= " {$this->_order_by} ";

        return $this;

    }

    /**
     * @return boolean | $this
     */
    public function delete($exec = true)
    {
        $this->columns = null;
        $this->sequence = 'delete';
        if ($this->softdelete)
            $this->query = " UPDATE " . $this->table . " {$this->_where} SET deleted_at = NOW() ";
        else
            $this->query = "  DELETE FROM `" . $this->table . "` ";

        if(!$this->initwhereclause) {
            $this->endquery = " where id = " . $this->instanceid;
            $this->_where = " where id = " . $this->instanceid;
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
        //$this->join();
        $this->columns = null;
        $this->query = "  UPDATE `" . $this->table . "` " . $this->defaultjoin;

        if ($arrayvalues)
            return $this->set($arrayvalues, $seton, $case)->sequensization()->exec();

        return $this->sequensization()->exec();
    }

    public function set($arrayvalues, $seton = null, $case = null)
    {
        $this->query .= " set ";
        $this->_set = " SET ";

        // update a column on multiple rows
        if (is_object($arrayvalues)) {
            $class = strtolower(get_class($arrayvalues));
            $this->parameters[$class."_id"] = $arrayvalues->getId();
            $this->_set .= " " . $this->table . "." . $class . "_id = :".$class."_id";
            if ($this->instanceid)
                $this->endquery = " WHERE " . $this->table . ".id = " . $this->instanceid;
        }
        elseif (is_array($case)) {
            $whens = [];
            $this->_set .= " `" . $arrayvalues . "` = CASE " . $seton . " ";

            foreach ($case as $when => $then) {
                $whens[] = $when;
                $this->parameters[$when] = $then;
                $this->_set .= " WHEN '$when' THEN :$when ";
            }

            $this->_set .= " ELSE  $seton END ";

            $whens = implode("', '", $whens);
            $this->endquery = " WHERE `" . $arrayvalues . "`  IN('" . $whens . "'); ";
        } // update one column on one row
        elseif ($arrayvalues && $seton != null) {
            //elseif (true) {
            $this->parameters[$arrayvalues] = $seton;
            $this->_set .= " $arrayvalues = :$arrayvalues ";
            $this->endquery = " WHERE " . $this->table . ".id = " . $this->instanceid;
        } // update multiple column on one row
        else {
            $arrayset = [];
            foreach ($arrayvalues as $key => $value) {
                $keymap = explode(".", $key);
                $attrib = str_replace('.', '_', $key);

                $dot = "`";
                if (count($keymap) == 2)
                    $dot = "";

                if (is_object($value)) {
                    if (strtolower(get_class($value)) == "datetime") {
                        $date = array_values((array)$value);
                        $this->parameters[implode('_', $keymap)] = $date[0];
                        $arrayset[] = $dot . implode('.`', $keymap) . "` = :".implode('_', $keymap);
                    } else {
                        $this->parameters[strtolower(get_class($value)) ."_id"] = $value->getId();
                        $arrayset[] = strtolower(get_class($value)) . "_id = :".strtolower(get_class($value)) ."_id";
                    }
                } else {
                    $this->parameters[$attrib] = $value;
                    $arrayset[] = $dot . implode('.`', $keymap) . "` = :".$attrib;
                }
            }
            $this->_set .= implode(", ", $arrayset);
            if ($this->instanceid)
                $this->endquery = " WHERE " . $this->table . ".id = " . $this->instanceid;
        }

        return $this;
    }

    /**
     * Set the columns to be selected.
     *
     * @param array|mixed $columns
     * @return $this
     */
    public function selectcount($object = null)
    {
        $this->softdeletehandled = false;
        $columns = "COUNT(*)";
        if ($object):
            $this->instanciateVariable($object);
        elseif (is_object($columns)):
            $this->instanciateVariable($columns);
            $columns = "COUNT(*)";
        endif;

        $this->columns = "COUNT(*)";
        $this->columnscount = "COUNT(*)";
//        $this->columns = is_array($columns) ? $columns : func_get_args();
        $this->query = " ";
//        $this->_selectcount = " select $columns from `". $this->table . "` ";
        $this->initdefaultjoin();

        return $this;
    }

    /**
     * init innerjoin of the $classname, base on the $classnameon. if the $classnameon is not specified, it will be set as the current
     * class
     * @param type $classname
     * @param type $classnameon
     * @return $this
     */
    public function innerjoin($classname, $classnameon = "")
    {
        $this->join = strtolower(get_class($classname));

        if (!$classnameon)
            $classnameon = $this->objectName;

        $this->_join = " INNER JOIN `" . $this->join . "` ON " . $this->join . ".id = " . strtolower($classnameon) . "." . $this->join . "_id";

        $this->query .= $this->_join;

        return $this;
    }

    /**
     * init leftjoin of the $classname, base on the $classnameon. if the $classnameon is not specified, it will be set as the current
     * class
     * @param type $classname
     * @param type $classnameon
     * @return $this
     */
    public function leftjoin($classname, $classnameon = "")
    {
        $join = strtolower($classname);

        if (!$classnameon)
            $classnameon = $this->objectName;

        $this->_join = " INNER JOIN `" . $join . "` ON " . $join . ".id = " . strtolower($classnameon) . "." . $join . "_id";
        $this->query .= $this->_join;


        $this->sequence = '';

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
    public function leftjoinrecto($classname, $classnameon = "")
    {
        $this->join = strtolower($classname);

        if (!$classnameon)
            $classnameon = $this->objectName;

        $this->_join .= " INNER JOIN `" . $this->join . "` ON " . $this->join . "." . strtolower($classnameon) . "_id = " . strtolower($classnameon) . ".id";
//        $this->query .= " left join `" . $this->join . "` ";
        $this->sequence = '';

        return $this;
    }

    public function on($entity)
    {
        //" left join `".strtolower(get_class($entity)).
        $this->query .= " ON " . $this->join . ".id = " . strtolower(get_class($entity)) . "." . $this->join . "_id";

        return $this;
    }

    public $softdeletehandled = false;

    public function handlesoftdelete()
    {

        if($this->softdeletehandled)
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

    public function whereMonth($column){

    }
    /**
     * Add a basic where clause to the query.
     *
     * @param string|array|\Closure $column
     * @param string|null $operator
     * @param mixed $value
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $link = "where")
    {
        $this->endquery = "";

        if($this->initwhereclause && $link == "where")
            $link = "and";

        if ($this->softdelete && $link == "where") {

            if(!$this->softdeletehandled)
                $this->handlesoftdelete();

            $link = "and";
        }

        if (is_object($column)) {

            $attrib = strtolower(get_class($column)) . '_id';
            if ($this->defaultjoinsetted) {
                $this->_where .= " " . $link . " " . strtolower(get_class($column)) . '.id';
            }else
                $this->_where .= " " . $link . " " . $attrib;

            if ($column->getId()) {
                if ($operator == "not") {
                    $this->_where .= " != :$attrib";
                } else {
                    $this->_where .= " = :".$attrib;
                }
                $this->parameters[$attrib] = $column->getId();
            } else {
                $this->_where .= " is null ";
            }
        }
        elseif (is_array($column)) {
            if (is_array($operator)) {
                for ($index = 0; $index < count($column); $index++) {
                    $this->andwhere($column[$index], "=", $operator[$index]);
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
                    $this->andwhere($key, "=", $value);
                }
            }
        }
        else {
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
                    $this->_where .= " = :".$attrib;
                    $this->parameters[$attrib] = $operator;
                }
            }
        }

        $this->initwhereclause = true;

        return $this;
    }

    public function andwhere($column, $sign = null, $value = null)
    {
        if ($this->initwhereclause)
            return $this->where($column, $sign, $value, 'and');
        else
            return $this->where($column, $sign, $value, 'where');
    }

    public function orwhere($column, $sign = null, $value = null)
    {
//        return $this->where($column, $sign, $value, 'or');
        if ($this->initwhereclause)
            return $this->where($column, $sign, $value, 'or');
        else
            return $this->where($column, $sign, $value, 'where');
    }

    public function orwhere_str($column, $sign = null, $value = null)
    {
//        return $this->where($column, $sign, $value, 'or');
        if ($this->initwhereclause)
            return $this->where_str($column, $sign, $value, 'or');
        else
            return $this->where_str($column, $sign, $value, 'where');
    }

    public function where_str($constraint, $link = "where")
    {
        $this->_where .= " " . $link . " " . $constraint;
        //$this->query .= $this->_where;

        $this->initwhereclause = true;

        return $this;
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
        }
        else
            $this->_where .= " in ( $values )";

        return $this;
    }

    public function notin($values)
    {
        if (is_array($values)) {
            $this->_where .= " NOT IN (" . implode(",", array_map("qb_sanitize", $values)) . ")";
        }
        else
            $this->_where .= " NOT IN ( $values )";

        return $this;
    }

    public function isNull()
    {
        $this->_where .= " IS NULL ";

        return $this;
    }
    public function isNotNull()
    {
        $this->_where .= " IS NOT NULL ";

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

    public function groupby($critere)
    {
        $this->_where .= " GROUP BY " . $critere;
        return $this;
    }

    public function between($value1, $value2)
    {
        $this->_where .= " BETWEEN '" . $value1 . "' AND '" . $value2 . "'";
        return $this;
    }

    public function orderby($critere)
    {
        $this->_where .= " ORDER BY " . $critere;
        return $this;
    }

    public function rand()
    {
        $this->_where .= " ORDER BY RAND() ";
        return $this;
    }

    public function limit($start = 1, $max = null)
    {
        if ($start < 0) {
            $qb = $this;
            $i = (int)$start;
            $nbel = $qb->count();
            if($nbel + $i > 0) {

                //$i += $nbel;
                $this->_limit = " limit " . ($nbel + $i) . ", " . abs($nbel);
                // return $qb->select()->limit($i - 1, $i)->__getOne($recursif, $collect);
                return $this;
            }
            $start = 0;
            $max = $nbel;
        }

        if ($max)
            $this->_limit = " limit " . $start . ", " . $max;
        else
            $this->_limit = " limit " . $start;
        $this->_where .= $this->_limit;
        return $this;
    }

    /**
     * @deprecated use index
     * @param int $index
     * @param bool $recursif
     * @param array $collect
     * @return type|null
     */
    public function __index($index = 1, $recursif = true, $collect = []) {
        $i = (int) $index;

        if($i < 0){
            $nbel = (int) $this->__countEl();
            if($nbel == 1)
                return $this->object;

            $i += $nbel;
            return $this->limit($i - 1, $i)->__getOne($recursif, $collect);
        }

        return $this->limit($i - 1, $i)->__getOne($recursif, $collect);
    }

    public function index($index = 1, $recursif = true, $collect = []) {
        $i = (int) $index;

        if($i < 0){
            $nbel = (int) $this->count();
            if($nbel == 1)
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

        return " select " . $columns . " from `" . $this->table . "` ";
    }

    protected function querysanitize($sql)
    {
        return str_replace("this.", $this->table . ".", $sql);
    }

    public function getSqlQuery()
    {
        if(self::$debug) // for the retro compatibility
            $sql = $this->query;
        elseif ($this->columns)
            $sql = $this->querysanitize($this->initquery($this->columns) . $this->defaultjoin . $this->query.$this->_where . $this->endquery);
        else
            $sql = $this->querysanitize($this->query .$this->_where . $this->endquery);

        return ["sql" => $sql, "parameters" => $this->parameters];
    }

    public function exec($action = 0)
    {
        if (in_array($action, [DBAL::$FETCH, DBAL::$FETCHALL]))
            return $this->executeDbal($this->querysanitize($this->initquery($this->columns) . $this->defaultjoin . $this->query .$this->_where), $this->parameters, $action);

        return $this->executeDbal($this->querysanitize($this->query .$this->_where . $this->endquery), $this->parameters, $action);
    }

    public function __getValue()
    {
        $value = $this->executeDbal(
            $this->querysanitize($this->initquery($this->columns) . $this->defaultjoin . $this->query.$this->_where),
            $this->parameters, DBAL::$FETCH);
        if (is_array($value))
            return $value[0];

        return $value;
    }

    public function first($recursif = true, $collect = [])
    {
        if (is_numeric($recursif))
            $this->limit_iteration = $recursif;

        $this->setCollect($collect);
        return $this->limit(1)->getInstance($recursif);
    }

    /**
     * @deprecated uses  firstOrNull
     * @param bool $recursif
     * @param array $collect
     * @return type|null
     */
    public function __firstOrNull($recursif = true, $collect = [])
    {
        $model = $this->__first($recursif, $collect);

        if($model->getId())
            return $model;

        return null;
    }
    public function firstOrNull($recursif = true, $collect = [])
    {
        $model = $this->first($recursif, $collect);

        if($model->getId())
            return $model;

        return null;
    }

    /**
     * @deprecated  use firstOr
     * @param $callback
     * @param bool $recursif
     * @param array $collect
     * @return type|null
     */
    public function __firstOr($callback, $recursif = true, $collect = [])
    {
        $model = $this->__first($recursif, $collect);

        if($model->getId())
            return $model;

        if(is_callable($callback))
            return $callback();

        dv_dump("callback is not callable");
    }
    public function firstOr($callback, $recursif = true, $collect = [])
    {
        $model = $this->__first($recursif, $collect);

        if($model->getId())
            return $model;

        if(is_callable($callback))
            return $callback();

        dv_dump("callback is not callable");
    }

    public function getLast($recursif = true, $collect = [])
    {
        return $this->orderby($this->table . ".id DESC ")->limit(1)->getInstance($recursif, $collect);
    }

    public function __getIndex($index, $recursif = true, $collect = [])
    {
        if (is_numeric($recursif))
            $this->limit_iteration = $recursif;

        $this->setCollect($collect);
        $i = (int)$index;
        return $this->limit($i - 1, $i)->__getOne($recursif);
    }

    public function __exportAllRow($callback)
    {
        return $this->__findAllRow($this->querysanitize($this->initquery($this->columns) . $this->query.$this->_where), $this->parameters, $callback);
    }
    public function __getAllRow($setdefaultjoin = false)
    {
        if ($setdefaultjoin)
            return $this->__findAllRow($this->querysanitize($this->initquery($this->columns) . $this->defaultjoin . $this->query.$this->_where), $this->parameters);

        return $this->__findAllRow($this->querysanitize($this->initquery($this->columns) . $this->query.$this->_where), $this->parameters);
    }

    private function initSelect(){

        $this->query = " SELECT {$this->_select_option} FROM ";
        $this->query .= $this->_from;

    }


    public function getInstanceOfIndex($index, $recursif = true, $collect = [])
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
     * @deprecated use get
     * @param bool $recursif
     * @param array $collect
     * @return array
     */
    public function __getAll($recursif = true, $collect = [])
    {

        if (is_numeric($recursif))
            $this->limit_iteration = $recursif;

        $this->setCollect($collect);
        //var_dump($this->objectVar);
        return $this->__findAll($this->querysanitize($this->initquery($this->columns) . $this->defaultjoin . $this->query.$this->_where), $this->parameters, false, $recursif);
    }

    public function cursor($callback)
    {
        return $this->__cursor($this->querysanitize($this->initquery($this->columns) . $this->defaultjoin . $this->query.$this->_where), $this->parameters, $callback);
    }

    /**
     * @deprecated use row
     * @return Object
     */
    public function __getOneRow()
    {
        return $this->__findOneRow($this->querysanitize($this->initquery($this->columns) . $this->query.$this->_where), $this->parameters);
    }

    /**
     * @deprecated use getInstance
     * @param bool $recursif
     * @param array $collect
     * @return type|null
     */
    public function __getOne($recursif = true, $collect = [])
    {

        if (is_numeric($recursif))
            $this->limit_iteration = $recursif;

        $this->setCollect($collect);
        return $this->__findOne($this->querysanitize($this->initquery($this->columns) . $this->defaultjoin . $this->query.$this->_where), $this->parameters, false, $recursif);
    }

    /**
     * @deprecated use count
     * @param bool $recursif
     * @param false $defaultjoin
     * @return mixed
     */
    public function __countEl($recursif = true, $defaultjoin = false)
    {
        //$this->setCollect($collect);
        if ($defaultjoin):
            $this->join();
        endif;

        return $this->__count($this->querysanitize($this->initquery($this->columnscount) . $this->defaultjoin . $this->query.$this->_where), $this->parameters, false, $recursif);
    }

    /**
     *
     * @param string $order
     * @return \dclass\devups\Datatable\Lazyloading
     */
    public function lazyloading($order = "", $debug = false)
    {

        $ll = new \dclass\devups\Datatable\Lazyloading($this->object);
        $ll->debug  = $debug;
        $ll->start($this->object);

        return $ll->lazyloading($this->object, $this, $order);

    }

    public function row(){

        $this->initSelect();
        $this->query .= $this->_join;
        $this->sequensization();

        if (self::$debug)
            return $this->getSqlQuery();

        return $this->__findOneRow($this->query, $this->parameters);

    }

    public function getRows($callbackexport = null){
        $this->initSelect();
        $this->query .= $this->_join;
        $this->sequensization();

        if (self::$debug)
            return $this->getSqlQuery();

        return $this->__findAllRow($this->query, $this->parameters, $callbackexport);
    }

    public function getInstance($recursif = true, $collect = []){
        $this->initSelect();
        if($recursif) {
            $this->query .= $this->_join;

            if (is_numeric($recursif))
                $this->limit_iteration = $recursif;

        }

        $this->sequensization();

        if (self::$debug)
            return $this->getSqlQuery();

        return $this->__findOne($this->query, $this->parameters, $collect, $recursif);
    }

    public function get($column = "*", $recursif = true, $collect = []){
        $this->_select_option = $column;
        $this->initSelect();

        if($recursif) {
            $this->query .= $this->_join;

            if (is_numeric($recursif))
                $this->limit_iteration = $recursif;

        }

        $this->sequensization();

        if (self::$debug)
            return $this->getSqlQuery();

        return $this->__findAll($this->query, $this->parameters, $collect, $recursif);

    }

    private function getValue(){
        $this->initSelect();
        $this->query .= $this->_join;
        $this->sequensization();

        if (self::$debug)
            return $this->getSqlQuery();

        $value = $this->executeDbal($this->query, $this->parameters, DBAL::$FETCH);
        if (is_array($value))
            return $value[0];

        return $value;
    }

}
