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
class QueryBuilder extends \DBAL {

//    private $table;    
    private $query = "";
    private $parameters = [];
    private $columns = "*";
    private $defaultjoin = "";
    private $columnscount = "COUNT(*)";
    private $endquery = "";

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

    public function __construct($entity = null) {
        if ($entity)
            parent::__construct($entity);

//        $this->table = strtolower(get_class($entity));
    }

    /**
     * Add an array of where clauses to the query.
     *
     * @param  array  $column
     * @param  string  $boolean
     * @param  string  $method
     * @return $this
     */
//    protected function addArrayOfWheres($column, $boolean, $method = 'where')
//    {
//        return $this->whereNested(function ($query) use ($column, $method, $boolean) {
//            foreach ($column as $key => $value) {
//                if (is_numeric($key) && is_array($value)) {
//                    $query->{$method}(...array_values($value));
//                } else {
//                    $query->$method($key, '=', $value, $boolean);
//                }
//            }
//        }, $boolean);
//    }

    /**
     * Prepare the value and operator for a where clause.
     *
     * @param  string  $value
     * @param  string  $operator
     * @param  bool  $useDefault
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function prepareValueAndOperator($value, $operator, $useDefault = false) {
        if ($useDefault) {
            return [$operator, '='];
        } elseif ($this->invalidOperatorAndValue($operator, $value)) {
            throw new InvalidArgumentException('Illegal operator and value combination.');
        }

        return [$value, $operator];
    }

    /**
     * Determine if the given operator and value combination is legal.
     *
     * Prevents using Null values with invalid operators.
     *
     * @param  string  $operator
     * @param  mixed  $value
     * @return bool
     */
    protected function invalidOperatorAndValue($operator, $value) {
        return is_null($value) && in_array($operator, $this->operators) &&
                !in_array($operator, ['=', '<>', '!=']);
    }

    /**
     * Determine if the given operator is supported.
     *
     * @param  string  $operator
     * @return bool
     */
    protected function invalidOperator($operator) {
        return !in_array(strtolower($operator), $this->operators, true) &&
                !in_array(strtolower($operator), $this->grammar->getOperators(), true);
    }

    /**
     * Set the columns to be selected.
     *
     * @param  array|mixed  $columns
     * @return $this
     */
    public function addselect($columns = "*", $object = null, $defaultjoin = true) {

        // save currente sequence
        $this->querysequence = $this->query;
        $this->sequenceobject = $this->object;

//        if ($object):
//            parent::__construct($object);
//        elseif (is_object($columns)):
//            $this->instanciateVariable($columns);
//            $columns = "*";
//        endif;

        if (is_object($columns)):
            $this->instanciateVariable($columns);
            $columns = "*";
        elseif (is_bool($object)):
            $defaultjoin = $object;
        elseif (is_object($object)):
            $this->instanciateVariable($object);
        endif;

        $this->query = " select $columns from `" . $this->table . "` ";

        if ($defaultjoin) {

            if (!empty($this->entity_link_list)) {
                foreach ($this->entity_link_list as $entity_link) {
                    $this->query .= " left join `" . strtolower(get_class($entity_link)) . "` on " . strtolower(get_class($entity_link)) . ".id = " . $this->table . "." . strtolower(get_class($entity_link)) . "_id";
                }
            }
        }

        return $this;
    }

    public function close() {
//        $params = $this->parameters;
        $query = $this->query;
        // restaure sequence before any other select
        $this->query = $this->querysequence;
//        $this->columns = $this->columnssequence ;
//        parent::__construct($this->sequenceobject);
//        
            $this->instanciateVariable($this->sequenceobject);
//        $this($this->sequenceobject);
        // we add value of previous request
//        foreach ($params as $param) {
//            $this->parameters[] = $param;
//        }

        return $query;
    }

    private function initdefaultjoin() {

        if (!empty($this->entity_link_list)) {
            foreach ($this->entity_link_list as $entity_link) {
                $this->defaultjoin = " left join `" . strtolower(get_class($entity_link)) . "` on " . strtolower(get_class($entity_link)) . ".id = " . $this->table . "." . strtolower(get_class($entity_link)) . "_id";
            }
        }
    }

    /**
     * Set the columns to be selected.
     *
     * @param  array|mixed  $columns
     * @return $this
     */
    public function select($columns = '*', $object = null, $defaultjoin = true) {

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

        if ($defaultjoin):
            $this->initdefaultjoin();
        endif;

        return $this;
    }

    public function delete() {
        $this->columns = null;
        
        $this->query = "  delete from `" . $this->table . "` ";
        $this->endquery = " where id = " . $this->instanceid;
        
        return $this;
        
    }
    
    /**
     * 
     * @param type $arrayvalues
     * @param type $seton
     * @param type $case
     * @return $this
     */
    public function update($arrayvalues = null, $seton = null, $case = null) {
        $this->columns = null;
        $this->query = "  update `" . $this->table . "` ";
        if(!$arrayvalues)
            return $this->set($arrayvalues, $seton, $case);
        
        return $this;
        
    }
    
    /**
     * 
     * @param type $arrayvalues
     * @param type $seton
     * @param type $case
     * @return $this
     */
    public function set($arrayvalues, $seton = null, $case = null) {
        $this->query .= " set ";
        
        // update a column on multiple rows
        if (is_array($case)) {
            
            $whens = [];
            $this->query .= " " . $arrayvalues . " = CASE " . $seton . " ";
            
            foreach ($case as $when => $then) {
                $whens[] = $when;
                $this->parameters[] = $then;
                $this->query .= " WHEN '$when' THEN ? ";
            }
            
            $this->query .= " ELSE  $seton END ";
            
            $whens = implode("', '", $whens);
            $this->endquery = " WHERE " . $arrayvalues . "  IN('".$whens."'); ";
            
        } 
        // update one column on one row
        elseif (!$seton) {
            $this->parameters[] = $seton;
            $this->query .= " $arrayvalues = ? ";
            $this->endquery = " WHERE id = ". $this->instanceid;
        } 
        // update multiple column on one row
        else {
            $arrayset = [];
            foreach ($arrayvalues as $key => $value) {
                $this->parameters[] = $value;
                $arrayset[] = " $key = ? ";
            }
            $this->query .= implode(", ", $arrayset);
            $this->endquery = " WHERE id = ". $this->instanceid;
        }
        
        return $this;
        
    }

    /**
     * Set the columns to be selected.
     *
     * @param  array|mixed  $columns
     * @return $this
     */
    public function selectcount($object = null) {
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
     * Set the columns to be selected.
     *
     * @param  array|mixed  $columns
     * @return $this
     */
    public function innerjoin($entity) {
        $this->join = strtolower(get_class($entity));
        $this->query .= " inner join `" . $this->join . "` ";

        return $this;
    }

    /**
     * Set the columns to be selected.
     *
     * @param  array|mixed  $columns
     * @return $this
     */
    public function leftjoin($entity) {
        $this->join = strtolower(get_class($entity));
        // on ".strtolower(get_class($entity)).".id = ".strtolower(get_class($entity_owner)).".".strtolower(get_class($entity))."_id
        $this->query .= " left join `" . $this->join . "` ";

        return $this;
    }

    /**
     * 
     * @param type $entity
     * @return $this
     */
    public function on($entity) {
        //" left join `".strtolower(get_class($entity)).
        $this->query .= " on " . $this->join . ".id = " . strtolower(get_class($entity)) . "." . $this->join . "_id";

        return $this;
    }

    /**
     * Add a basic where clause to the query.
     *
     * @param  string|array|\Closure  $column
     * @param  string|null  $operator
     * @param  mixed   $value
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $link = "where") {
        $this->endquery = "";
//        if(is_array($critere)){
//            
//        }
//        $this->columns = is_array($columns) ? $columns : func_get_args();

        if (is_object($column)) {

            $this->query .= " " . $link . " " . strtolower(get_class($column)) . '.id';
            if ($column->getId()) {
                $this->query .= " = ? ";
                $this->parameters[] = $column->getId();
            } else {
                $this->query .= " is null ";
            }
        } else {
            $this->query .= " " . $link . " " . $column;
            if ($operator) {
                if (in_array($operator, $this->operators)) {
                    $this->query .= " " . $operator . " ? ";
                    $this->parameters[] = $value;
                } elseif(strtolower ($operator) == "like") {
                    $this->query .= " LIKE '%" . $operator . "%' ";
                } else {
                    $this->query .= " = ? ";
                    $this->parameters[] = $operator;
                }
            }
        }

        return $this;
    }

    public function andwhere($column, $sign = null, $value = null) {
        return $this->where($column, $sign, $value, 'and');
    }

    public function orwhere($column, $sign = null, $value = null) {
        return $this->where($column, $sign, $value, 'or');
    }

    public function in($values) {
        if (is_array($values))
            $this->query .= " in (" . implode(",", $values) . ")";
        else
            $this->query .= " in ( $values )";

        return $this;
    }
    
    public function notin($values) {
        if (is_array($values))
            $this->query .= " not in (" . implode(",", $values) . ")";
        else
            $this->query .= " not in ( $values )";

        return $this;
    }
    

    public function like($value) {
//        if (is_array($values))
//            $this->query .= " LIKE '%" . implode(",", $values) . "%'";
//        else
            $this->query .= " LIKE '%" . $value . "%' ";

        return $this;
        
    }
    

    public function orderby($critere) {
        $this->query .= " order by " . $critere;
        return $this;
    }

    public function limit($start = 1, $max = null) {
        if ($max)
            $this->query .= " limit " . $start . ", " . $max;
        else
            $this->query .= " limit " . $start;

        return $this;
    }

    private function initquery($columns) {
        return " select " . $columns . " from `" . $this->table . "` ";
    }

    public function getSqlQuery() {
        if($this->columns)
            return $this->initquery($this->columns) . $this->defaultjoin . $this->query . $this->endquery;
        else
            return $this->query . $this->endquery;
    }
    
    public function exec($action = 0) {        
        return $this->executeDbal($this->query . $this->endquery, $this->parameters, $action);
    }

    public function __getAllRow() {
        return $this->__findAllRow($this->initquery($this->columns) . $this->query, $this->parameters);
    }

    public function __getAll($recursif = true) {
        return $this->__findAll($this->initquery($this->columns) . $this->defaultjoin . $this->query, $this->parameters, false, $recursif);
    }

    public function __getOneRow() {
        return $this->__findOneRow($this->initquery($this->columns) . $this->query, $this->parameters);
    }

    public function __getOne($recursif = true) {
        return $this->__findOne($this->initquery($this->columns) . $this->defaultjoin . $this->query, $this->parameters, false, $recursif);
    }

    public function __countEl($recursif = true) {
        return $this->__count($this->initquery($this->columnscount) . $this->defaultjoin . $this->query, $this->parameters, false, $recursif);
    }

}
