<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Description of DBAL 3.1.0 *
 * Abstraction database layer implement object \DateTime structire
 * nullable value for many to one relation
 *
 * @author Atemkeng Azankang
 */
class DBAL extends Database
{

    protected $defaultjoin = "";
    protected $collect = [];
    /**
     *
     * @var type
     */
    protected $object;
    protected $classmetadata;

    /**
     *
     * @var type
     */
    protected $objectName;
    protected $table;

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    protected $instanceid;

    /**
     *
     * @var type
     */
    protected $objectVar;

    /**
     *
     * @var type
     */
    protected $objectValue;

    /**
     *
     * @var type
     */
    protected $nbVar;

    /**
     * collection d'objet utilisé dans les relations de n:n et dans les relations 1:n bidirectionnelles
     * @var type
     */
    protected $listeEntity;
    protected $objectCollection;

    /**
     *
     * @var type
     */
    protected $softdelete = false;
    /**
     *
     * @var type
     */
    private $select;

    /**
     *
     * @var type
     */
    private $en;

    /**
     * liste des entités en relation de 1:n et 1:1
     * @var type
     */
    protected $entity_link_list;
    private $iterat;
    private $update = false;

    public function __construct($object = null)
    {
        parent::__construct();
//        global $em;
//        $this->em = $em;

        $this->instanciateVariable($object);
    }

//    public static function getEntityManager() {
    public static function getEntityManager()
    {
        global $enittycollection;

        $global_navigation = Core::buildOriginCore();
        $enittyfoldes = [];
        $enittyfoldes[] = ROOT . "dclass/extends";

        foreach ($global_navigation as $key => $project) {
            if (is_object($project)) {
                foreach ($project->listmodule as $key => $module) {
                    if (is_object($module)) {
                        if (file_exists($rep = ROOT . "src/" . $project->name . "/" . $module->name . "/Entity")) {
                            $enittyfoldes[] = $rep;
                            foreach ($module->listentity as $key => $entity) {
                                if (is_object($entity))
                                    //var_dump($entity);
                                    $enittycollection[strtolower($entity->name)] = ROOT . "src/" . $project->name . "/" . $module->name;
                            }
                        }
                    }
                }
            }
        }

        // Create a simple "default" Doctrine ORM configuration for Annotations
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration($enittyfoldes, $isDevMode);
        // or if you prefer yaml or XML
        //$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
        //$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);
        // database configuration parameters
        $conn = array(
            'driver' => 'pdo_mysql',
            'dbname' => dbname,
            'user' => dbuser,
            'password' => dbpassword,
            'host' => dbhost,
            //    'path' => __DIR__ . '/db.sqlite',
        );

        // obtaining the entity manager
        return EntityManager::create($conn, $config);

    }


    public function setCollect(array $collect)
    {
        foreach ($collect as $el) {
            $this->collect[] = str_replace("this.", $this->table . ".", $el);
        }
        //$this->collect = $collect;
    }

    protected $em;

    public function is_doctrine_entity($className)
    {
//        $this->em = $this->getEntityManager();
        return !$this->em->getMetadataFactory()->isTransient("\\" . $className);
    }

    public function getDoctrineMetadata($className)
    {

        if ($this->is_doctrine_entity($className))
            return $this->em->getClassMetadata("\\" . $className);

        return null;
    }

    /**
     * persiste les entités issue d'un attribut en relation de n:n
     *
     * @param integer $id l'id de l'entité proprietère de la relation
     * @return
     */
    private function manyToManyAdd($id, $update = false, $change_collection = [])
    {
        /**
         * on traite chaque attribut de maniere unique, attribut qui est lui aussi une liste d'entité
         */
        $success = true;
        foreach ($this->objectCollection as $index => $listentity) {

            /**
             * on isole chaque entité contenu dans la liste des entités
             */
            $association = true;
            foreach ($listentity as $entity) {

                if (!is_object($entity))
                    continue;

                if (!$entity->getId())
                    break;
                /**
                 * chaque entité est persistée
                 */
                // valeur des attributs de la table
                $values = [];

                $entityName = strtolower(get_class($entity));

                if ($this->tableExists($entityName . '_' . $this->objectName)) {
                    $entityTable = $entityName . "_" . $this->objectName;
                    $direction = "ld";
                } elseif ($this->tableExists($this->objectName . "_" . $entityName)) {
                    $entityTable = $this->objectName . "_" . $entityName;
                    $direction = "rl";
                } else {
                    $association = false;
                    $entityTable = $entityName;
                    $direction = "lr";
                }


                /**
                 * on instantie la class $entityTable trop cool
                 */
                $persistecollection = true;

                if ($direction == "lr") {

                    $persistecollection = false;
                    $sql = "update `" . $entityTable . "` set " . $this->objectName . "_id = $id where id = " . $entity->getId();

                    $query = $this->link->prepare($sql);
                    $success = $query->execute() or die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $query->errorInfo(), $sql, $entityTable, $values));

                } else {

                    $reflect = new ReflectionClass($entityTable);
                    $object = $reflect->newInstance();
                    $obarr = (array)$object;
                    $obarr[$this->objectName] = $this->object;
                    $obarr[strtolower(get_class($entity))] = $entity;

                    $entitycol = Bugmanager::cast((object)$obarr, $entityTable);

                    $success = $entitycol->__save();

                }

                if ($persistecollection) {
                    $success = true;
                }
            }
        }

        return $success;
    }

    /**
     * cette methode est utilisé lors de l'update et non lors du delete mais il se peut que il ait une
     * moyen de faire son update sans les supprimer. mais je ne l'ai pas encore trouvé donc sa rester une
     * hypothèse
     *
     * @param type $id
     * @return type
     */
    private function manyToManyDelete($id, $change_collection = [])
    {

        $sql = "";
        $success = "";
        if (!$change_collection)
            return true;

        foreach ($change_collection as $i => $listentity) {

            if (!empty($listentity['todrop'])) {

                $entityName = strtolower(get_class($listentity['todrop'][0]));
                $objectarray = (array)$listentity['todrop'][0];
                $arrayvalues = array_values($objectarray);
                foreach ($arrayvalues as $value) {

                    foreach ($listentity['todrop'] as $entity) {
                        if ($this->tableExists($entityName . '_' . $this->objectName)) {
                            $entityTable = $entityName . "_" . $this->objectName;
                        } elseif ($this->tableExists($this->objectName . "_" . $entityName)) {
                            $entityTable = $this->objectName . "_" . $entityName;
                        } else {
                            $entityTable = $entityName;
                        }

                        $sql .= "delete from " . $entityTable . "  where " . $entityName . "_id = " . $entity->getId() . " and " . $this->objectName . "_id = $id; ";

                    }

                }
            } else {
                $success = TRUE;
            }
        }

        if ($sql != "") {

            $query = $this->link->prepare($sql);
            $success = $query->execute() or die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $query->errorInfo(), $sql));
        }
        return $success;
    }

    public function belongto($entity, $relation)
    {

        if (is_object($relation)) {
            if ($relation->getId())
                return $relation->__show();
            else {
                $obarray = (array)$entity;
                $relationname = strtolower(get_class($relation));
                //dv_dump($relationname);
                if (isset($obarray[$relationname . "_id"]))
                    $id = $obarray[$relationname . "_id"];
                else {
                    return $relation;
                }
            }
        } elseif (!is_object($relation)) {

            $obarray = (array)$entity;
            if (isset($obarray[$relation . "_id"]))
                $id = $obarray[$relation . "_id"];
            elseif (isset($obarray[$relation]))
                $id = $obarray[$relation]->getId();
            else {
                foreach ($obarray as $obkey => $value) {
                    //$key = str_replace(get_class($entity), '', $obkey);
                    //$key = str_replace('*', '', $key);

                    if (is_object($value) && strtolower(get_class($value)) == $relation) {

                        $id = $obarray[$obkey]->getId();
                        break;
                    }
                }
            }

            $reflection = new ReflectionClass($relation);
            $relation = $reflection->newInstance();
        }

        $qb = new QueryBuilder($relation);
        return $qb->select()->where("id", "=", $id)->__getOneRow();
    }

    public function hasmany($entity, $collection, $exec = true, $incollectionof = null, $recursif = false)
    {

        $collectionName = strtolower(get_class($collection));
        if ($incollectionof != null) {

            $qb = new QueryBuilder($collection);
            $qb->select()
                ->where("this.id")//$collectionName .
                ->in(
                    $qb->addselect($collectionName . "_id", new $incollectionof, false)
                        ->where($entity)
                        ->close()
                );

            if ($exec)
                return $qb->__getAll($recursif);
            else
                return $qb;

        } else {
            $objectName = strtolower(get_class($entity));

            if ($this->tableExists($collectionName . '_' . $objectName)) {
                $entityTable = $collectionName . '_' . $objectName;
            } elseif ($this->tableExists($objectName . "_" . $collectionName)) {
                $entityTable = $objectName . "_" . $collectionName;
            } elseif ($this->tableExists($collectionName)) {

                $qb = new QueryBuilder($collection);
                $qb->select()
                    ->where($entity);

                if ($exec)
                    return $qb->__getAll($recursif);
                else
                    return $qb;
            }
        }

        $tableinstance = ucfirst($entityTable);

        $qb = new QueryBuilder($collection);
        $qb->select()
            ->where($collectionName . ".id")
            ->in(
                $qb->addselect($collectionName . "_id", new $tableinstance)
                    ->where($entity)
                    ->close()
            );

        if ($exec)
            return $qb->__getAll($recursif);
        else
            return $qb;
    }

    /**
     * createDbal
     * persiste les entités en base de données.
     *
     * @param \stdClass $object
     * @return int l'id de l'entité persisté
     */
    public function insertserialiseDbal($object, $listentity)
    {
        if ($object)
            $this->instanciateVariable($object);

        foreach ($listentity as $entity) {
            $objectarray = (array)$entity;
            $objectvalue = array_values($objectarray);
            $rowvalue = [];
            foreach ($objectarray as $key => $value) {
                if (is_object($value) and get_class($value) != 'DateTime')
                    $rowvalue[] = $value->getId();
                elseif (is_object($value) and get_class($value) == 'DateTime') {
                    //$rowvalue[] = $value->getDate();
                    //echo "entre la";
                    $date = array_values((array)$value);
                    $rowvalue[] = $date[0];
                } else
                    $rowvalue[] = $value;
            }

            $finalvalue[] = "(''" . implode(",", $rowvalue) . ")";
        }
        $parameterQuery = 'id';

        for ($i = 1; $i < $this->nbVar; $i++) {
            $parameterQuery .= ',' . $this->objectVar[$i];
        }

        $sql = "insert into " . $this->table . " (" . $parameterQuery . ")  values ";
        //$sql = "insert into ".$this->objectName." value ";
        $sql .= implode(",", $finalvalue) . ';';
        //die(var_dump($sql));
        return $sql;
    }

    /**
     * createDbal
     * persiste les entités en base de données.
     *
     * @param \stdClass $object
     * @return int l'id de l'entité persisté
     */
    public function updateserialiseDbal($table, $var, $arrayvalues)
    {

        if (is_object($table))
            $table = strtolower(get_class($table));

        $ids = array_keys($arrayvalues);
        $sql = "";
        if (count($arrayvalues) == 1) {
            $sql = " update " . $table . " set $var = '" . $arrayvalues[$ids[0]] . "' WHERE id = " . $ids[0] . "; ";
        } else {
            $parameterQuery = "";
            foreach ($arrayvalues as $key => $value) {
                //$parameterQuery .= " WHEN $key THEN $value ";
                $sql .= " update " . $table . " set $var = '" . $value . "' WHERE id = " . $key . "; ";
            }
        }

        return $sql;
    }

    /**
     * createDbal
     * persiste les entités en base de données.
     *
     * @param \stdClass $object
     * @return int l'id de l'entité persisté
     */
    public function deleteserialiseDbal($object, $listid)
    {
        if ($object)
            $this->instanciateVariable($object);

        $sql = "DELETE from " . $this->table . " WHERE id IN (" . implode(",", $listid) . ")";

        return $sql;
    }

    public static $NOTHING = 0;
    public static $INSERT = 1;
    public static $FETCHALL = 2;
    public static $FETCHALLROWS = 5;
    public static $FETCHOBJECT = 3;
    public static $FETCH = 4;

    /**
     * createDbal
     * persiste les entités en base de données.
     *
     * @param \stdClass $object
     * @return int l'id de l'entité persisté
     */
    public function executeDbal($sql, $values = [], $action = 0)
    {

        $query = $this->link->prepare($sql);
        $return = $query->execute($values) or die (Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $query->errorInfo(), $sql, $values));

//        if(!$return["success"])
//            return $return;

        if ($action == self::$NOTHING) {
            // nothing
            if (dbtransaction) {
                $bd_dump = new \dclass\devups\DB_dumper();
                $bd_dump->transaction($this->table, $sql, $values);
            }
        } elseif ($action == self::$FETCH) {
            $return = $query->fetch() or die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $query->errorInfo(), $sql));
            //$return = 33;
        } elseif ($action == self::$INSERT) {
            if (dbtransaction) {
                $bd_dump = new \dclass\devups\DB_dumper();
                $bd_dump->transaction($this->table, $sql, $values);
            }
            $req = $this->link->prepare("select @@IDENTITY as id");
            $req->execute();
            $id = $req->fetch() or die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $query->errorInfo(), $sql));
            $return = $id['id'];
        } elseif ($action == self::$FETCHALL) {
            $return = $query->fetchAll();// or die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $query->errorInfo(), $sql));
        } elseif ($action == self::$FETCHOBJECT) {
            $return = $query->fetchObject($this->objectName) or die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $query->errorInfo(), $sql));
        }

        return $return;
    }

    /**
     * createDbal
     * persiste les entités en base de données.
     *
     * @param \stdClass $object
     * @return int l'id de l'entité persisté
     */
    public function createDbal($object = null)
    {
        if ($object)
            $this->instanciateVariable($object);

        $values = [];
        $parameterQuery = ':' . implode(", :", $this->objectVar);

        $sql = "insert into `" . $this->table . "` (`" . strtolower(implode('` ,`', $this->objectVar)) . "`) 
        values (" . strtolower($parameterQuery) . ")";

        $id = $this->executeDbal($sql, $this->objectKeyValue, 1);
        $this->object->setId($id);

        // implement translation if anabled in class
        if (method_exists($this->object, 'dvupsTranslate')) {
            $this->object->dvupsTranslate();
        }

        if (isset($this->objectCollection) && is_array($this->objectCollection) && !empty($this->objectCollection)) {
            $this->manyToManyAdd($id, false, null);
        }

        $eventListners = \dclass\devups\Controller\Controller::$eventListners["after"]["create"];

        if(isset($eventListners[$this->objectName])){
            $methods = $eventListners[$this->objectName];
            foreach ($methods as $method) {
                if(is_array($method))
                    $this->object->{$method[0]}();
                else
                    $this->object->{$method}();
            }
        }

        return $this->object->getId();
    }
    /**
     * createDbal
     * persiste les entités en base de données.
     *
     * @param \stdClass $object
     * @return int l'id de l'entité persisté
     */
    public static function _createDbal($object, $keyvalue)
    {

        $values = [];
        $objectvar = array_keys($keyvalue);
        $parameterQuery = ':' . implode(", :", $objectvar);

        $sql = "insert into `" . strtolower($object) . "` (`" . strtolower(implode('` ,`', $objectvar)) . "`) values (" . strtolower($parameterQuery) . ")";

        $db = new DBAL();
        return $db->executeDbal($sql, $keyvalue, 1);

    }

    /**
     * updateDbal
     * met à jour l'entité passé en parametre. et celon la valeur de $change_collection, la collection d'objet de l'entité en question.
     *
     * @param \stdClass $object l'entité a persister
     * @param array $change_collection Autorise la modification de la collection d'objet en bd true par defaut
     * @return \stdClass
     */
    public function updateDbal($object = null)
    {

        global $_ENTITY_COLLECTION;

        if ($object):
            $this->instanciateVariable($object);
        endif;

        $this->update = true;
        //$parameterQuery = '`' . implode("`= :".$this->objectVar.", `", $this->objectVar);

        $parameterQuery = '`' . $this->objectVar[1] . '`= :'. $this->objectVar[1];
        for ($i = 2; $i < $this->nbVar; $i++) {
            $parameterQuery .= ', `' . $this->objectVar[$i] . '`= :'.$this->objectVar[$i];
        }
        $values = $this->objectValue;
        array_splice($values, 0, 1);
        $values[] = $this->objectValue[0];

        $sql = "update `" . $this->table . "` set " . strtolower($parameterQuery) . " where id = :id ";

        $query = $this->link->prepare($sql);

        $result = $query->execute($this->objectKeyValue) or die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $query->errorInfo(), $sql, $values));

        if (dbtransaction) {
            $bd_dump = new \dclass\devups\DB_dumper();
            $bd_dump->transaction($this->table, $sql, $values);
        }

        // implement translation if anabled in class
        if (method_exists($this->object, 'dvupsTranslate')) {
            $this->object->dvupsTranslate();
        }

        $this->manyToManyDelete($this->objectValue[0], $_ENTITY_COLLECTION);

        if (isset($this->objectCollection) && is_array($this->objectCollection) && !empty($this->objectCollection)) {

            $this->manyToManyAdd($object->getId(), false, null);
        }

        return $result;
    }

    /**
     * findAllDbal
     * returne toutes les occurences de l'entite en bd
     *
     * @return array
     */
    public function findAllDbal($critere = "")
    {
        $sql = 'select * from `' . $this->table . '` ' . $critere;
        $query = $this->link->prepare($sql);
        $query->execute();
        $flowBD = $query->fetchAll(PDO::FETCH_CLASS, $this->objectName);

        return $flowBD;
    }

    protected function initdefaultjoin()
    {

        if (!empty($this->entity_link_list)) {
            $entity_links = array_keys($this->entity_link_list);
            foreach ($entity_links as $entity_link) {
                $class_attrib = explode(":", $entity_link);
                if ($class_attrib[0] != $class_attrib[1])
                    $this->defaultjoin .= " left join `" . $class_attrib[0] . "` " . $class_attrib[1] . " on " . $class_attrib[1] . ".id = " . $this->table . "." . $class_attrib[1] . "_id";
                else
                    $this->defaultjoin .= " left join `" . $class_attrib[0] . "` on " . $class_attrib[0] . ".id = " . $this->table . "." . $class_attrib[0] . "_id";
            }
        }
    }

    public function findByIdDbal($object = null, $recursif = true, $collection = false)
    {
        $this->defaultjoin = "";
        if ($object):
            $this->instanciateVariable($object);
        endif;

        $sql = 'select * from `' . $this->table . '`';
        $this->initdefaultjoin();

//        if (!empty($this->entity_link_list)) {
//            foreach ($this->entity_link_list as $entity_link) {
//                $sql .= " left join `" . strtolower(get_class($entity_link)) . "` on " . strtolower(get_class($entity_link)) . ".id = " . $this->table . "." . strtolower(get_class($entity_link)) . "_id";
//            }
//        }
//        var_dump( $this->objectVar);
        $sql .= $this->defaultjoin . ' where ' . $this->table . '.' . $this->objectVar[0] . ' = ? ';
        if ($this->softdelete)
            $sql .= ' and ' . $this->table . '.deleted_at is null ';

        return $this->__findOne($sql, array($this->objectValue[0]), $collection, $recursif);
    }

    public function deleteDbal($object = null)
    {

        if ($object):
            $this->instanciateVariable($object);
        endif;

        if ($this->softdelete)
            $sql = "update `" . $this->table . "` set deleted_at = NOW() where " . $this->objectVar[0] . " = ?";
        else
            $sql = "delete from `" . $this->table . "` where " . $this->objectVar[0] . " = ?";

        $query = $this->link->prepare($sql);
        $retour = $query->execute(array($this->objectValue[0])) or die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $query->errorInfo(), $sql, array($this->objectValue[0])));

        if (dbtransaction) {
            $bd_dump = new \dclass\devups\DB_dumper();
            $bd_dump->transaction($this->table, $sql, array($this->objectValue[0]));
        }

        return $retour;
    }

    protected function __count($sql, $values = [])
    {

        $query = $this->link->prepare($sql);
        $query->execute($values) or die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__,  $query->errorInfo(), $sql, $values));

        return $query->fetchColumn();
    }

    private function dbrow($flowBD)
    {


        $object_array = (array)$this->object;

        foreach ($object_array as $key => $value) {

            $k = str_replace(get_class($this->object), '', $key);
            $k = str_replace('*', '', $k);
            $k2 = substr($k, 2);

            foreach ($flowBD as $key2 => $value2) {

                if (is_object($value)) {
                    $classname = strtolower(get_class($value));
                    if ($classname . '_id' == $key2) {

                        if (is_array($flowBD[$key2])) {
                            $object_array[$key] = null;//$classname;
                            $object_array[$key . "_id"] = $flowBD[$key2][0];
                        } else {
                            $object_array[$key] = null;// $classname;
                            $object_array[$key . "_id"] = $flowBD[$key2];
                        }
                        break;
                    }
                } elseif (is_array($value)) {
                    $object_array[$key] = [];
                    break;
                } else {
                    if ($k2 == $key2) {
                        if (is_array($flowBD[$key2])) {
                            $object_array[$key] = $flowBD[$key2][0];
                        } else {
                            $object_array[$key] = $flowBD[$key2];
                        }
                        break;
                    }
                }
            }
        }

        $flowBD = Bugmanager::cast((object)$object_array, get_class($this->object));
        $flowBD->dvfetched = true;
        $flowBD->dvinrelation = true;

        return $flowBD;

    }

    /**
     * Return the row of the database map with the object.
     *
     * @param String $sql
     * @param Array $values
     * @return Object
     */
    protected function __findOneRow($sql, $values = [])
    {

        $req = $this->link->prepare($sql);
        $req->execute($values) or die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $sql, $req->errorInfo()));

        if (empty($this->entity_link_list) and empty($this->objectCollection))
            return $req->fetchObject($this->objectName);

        $flowBD = $req->fetch(PDO::FETCH_NAMED);

        if (!$flowBD) {
            return new $this->objectName;
        }

        return $this->dbrow($flowBD);

    }

    /**
     * return entire entity with all linked one
     *
     * @param type $sql
     * @param type $values
     * @param type $collection
     * @param type $recursif
     * @return type
     */
    protected function __findOne($sql, $values = [], $collection = false, $recursif = true)
    {

        $req = $this->link->prepare($sql);
        $req->execute($values) or die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $sql, $req->errorInfo()));

        $arrayReturn = $this->listeEntity;

        if (empty($this->entity_link_list) and empty($this->objectCollection))
            $flowBD = $req->fetchObject($this->objectName);
        elseif ($arrayReturn)
            $flowBD = $this->djoin($req->fetch(PDO::FETCH_NAMED), $this->object, true, $recursif);
        else
            $flowBD = $this->djoin($req->fetch(PDO::FETCH_NAMED), $this->object, $collection, $recursif);

        if (!$flowBD)
            $flowBD = $this->object;

        $flowBD->dvfetched = true;

        return $flowBD;
    }


    /**
     * Return array of base entity
     *
     * @param type $sql
     * @param type $values
     * @return type
     */
    protected function __findAllRow($sql, $values = [], $callbackexport = null)
    {
        $result = [];
        $query = $this->link->prepare($sql);
        $query->execute($values) or die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $query->errorInfo(), $sql));

//        $flowBD = $query->fetchAll(PDO::FETCH_CLASS);
        if (is_callable($callbackexport)) {

            $rows = $query->fetchAll(PDO::FETCH_NAMED);
            foreach ($rows as $row) {
                $callbackexport($row, $this->objectName);
            }
            return true;
        }

        if (empty($this->entity_link_list) and empty($this->objectCollection))
            return $query->fetchAll(PDO::FETCH_CLASS, $this->objectName);

        $rows = $query->fetchAll(PDO::FETCH_NAMED);
        foreach ($rows as $row) {
            $result[] = $this->dbrow($row);
        }

        return $result;
    }

    /**
     * Return array of entire entity
     *
     * @param type $sql
     * @param type $values
     * @param type $collection
     * @param type $recursif
     * @return array
     */
    protected function __findAll($sql, $values = [], $collection = false, $recursif = false)
    {

        $query = $this->link->prepare($sql);
        $query->execute($values) or die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $query->errorInfo(), $sql));

        if (empty($this->entity_link_list))
            $retour = $query->fetchAll(PDO::FETCH_CLASS, $this->objectName);
        elseif ($arraybd = $query->fetchAll(PDO::FETCH_NAMED)) {
            foreach ($arraybd as $row)
                $liste[] = $this->djoin($row, $this->object, $collection, $recursif);
            $retour = $liste;
        } else
            $retour = array();

//            $this->ResetObject();
        return $retour;
    }

    protected function __cursor($sql, $values, $callback = null)
    {

        $query = $this->link->prepare($sql);
        $query->execute($values) or die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $query->errorInfo(), $sql));

        if (is_callable($callback)) {
            while ($row = $query->fetch(PDO::FETCH_NAMED)) {
                $row = $this->djoin($row, $this->object, false, false);
                $callback($row);
            }
//            while ($row = $query->fetch(PDO::FETCH_OBJ)) {
//                $callback($row);
//            }
            return;
        }
        if (empty($this->entity_link_list))
            $retour = $query->fetchAll(PDO::FETCH_CLASS, $this->objectName);
        elseif ($arraybd = $query->fetchAll(PDO::FETCH_NAMED)) {
            return $arraybd;
        } else
            $retour = array();

//            $this->ResetObject();
        return $retour;
    }


    private function inarray4($flowvalue)
    {
        $return = null;
        for ($i = 0; $i < count($flowvalue); $i++) {
            if (isset($flowvalue[$i])) {
                $return = $flowvalue[$i];
                unset($flowvalue[$i]);
                break;
            }
        }
        return $return;
    }

    /**
     * orm v_3.0
     * methode recurcivi qui permet de recreer les entités imbriques dans l'entité courantes
     * prend en parametre un tableau qui est le résultat d'une requete avec jointure et retourne
     * l'entité souhaité.
     * la version actuelle ne peut traiter que la premiere couche d'imbrication mais c'est deja un bon debut
     *
     * @param type $flowBD
     * @param type $object
     * @param type $entity_link_list
     * @param type $arrayReturn
     * @param type $list
     * @param type $recursif
     *
     * @return type
     */


    protected $iteration = 0;
    protected $limit_iteration = 0;

    private function orm($flowBD, $object, $imbricateindex = 0, $recursif = true, $collection = false)
    {

        $object_array = (array)$object;

        /*if(get_class($object) == "Enterprise")
            die(var_dump($object_array));*/

        if ($this->limit_iteration != 0 && $this->iteration >= $this->limit_iteration) {

            $object_array["dvinrelation"] = true;

            return $object_array;
        }

        foreach ($object_array as $key => $value) {
//                    $imbricateindex = 0;

            $k = str_replace(get_class($object), '', $key);
            $k = str_replace('*', '', $k);
            $k2 = substr($k, 2);

            foreach ($flowBD as $key2 => $value2) {

                if (is_object($value)) {
                    // object imbricate
                    $innerrecursif = $recursif;

                    $attclassname = strtolower(get_class($value));

                    if (isset($this->entity_link_list[$attclassname . ":" . $key])
                        && $key == substr($key2, 0, -3)
                        //&& $this->entity_link_list[$attclassname.":".$key] == $attclassname.":".substr($key2, 0, -3)
                    ) {
                        //if (strtolower(get_class($value)) . '_id' == $key2) {
                        /*if($attclassname.":".$key == "tree_item:enterprise_type"){ //  && $key2 == "enterprise_type_id"
                            die(var_dump($key, $flowBD, $flowBD[$key."_id"], $attclassname, $attclassname.":".substr($key, 0, -3)));
                        }*/
                        if (!empty($this->collect)) {
                            $el = strtolower(get_class($object)) . "." . strtolower(get_class($value));
                            if (!in_array($el, $this->collect)) {
                                //break;
                                $innerrecursif = false;
                            }
                        }
                        if (is_array($flowBD[$key2])) {

                            $imbricateindex++;
                            $this->iteration++;
                            $value->setId($this->inarray4($flowBD[$key2]));

                            if ($innerrecursif)
                                $object_array[$key] = $this->findByIdDbal($value);
                            else
                                $object_array[$key] = $value;
                        } else {

                            $this->iteration++;
                            $value->setId($flowBD[$key . "_id"]);
                            if ($innerrecursif)
                                $object_array[$key] = $this->findByIdDbal($value);
                            else
                                $object_array[$key] = $value;
                        }

                        $this->instanciateVariable($object);
                        break;
                    }
                } elseif (is_array($value)) {
                    if ($collection)
                        $object_array[$key] = $object->__hasmany(strtolower(get_class($value[0])));
                    else
                        $object_array[$key] = $value;

                    break;
                } else {
                    if ($k2 == $key2) {
                        if (is_array($flowBD[$key2])) {
                            $object_array[$key] = $flowBD[$key2][0];
                        } else {
                            $object_array[$key] = $flowBD[$key2];
                        }

                        break;
                    }
                }
            }

        }

        $object_array["dvinrelation"] = true;

        return $object_array;
    }

    /**
     *
     * @param type $flowBD les données de la bd extrait par PDO avec le parametre PDO::FETCH_NAMED
     * @param type $object the instance of the entity
     * @param Boolean $collection
     * @param Boolean $recursif weither or not the requeste should go deeper in finding entity relation.
     * @return type
     */
    private function djoin($flowBD, $object, $collection = false, $recursif = true)
    {

        if (!is_array($flowBD)) {
            return null;
        }

        $object_array = $this->orm($flowBD, $object, 0, $recursif, $collection);

        return Bugmanager::cast((object)$object_array, get_class($object));

    }

    public $hasrelation = false;
    public $objectKeyValue = [];

    /**
     * methode qui initialise les variables d'instance. elle est notament utilisé pour permetre de persister
     * des entités en utilisant directement les methodes du dbal sans passé par le dao comme ça se faisait
     * avant.
     *
     * @param type $object
     */
    protected function instanciateVariable($object)
    {
        global $em;

        $this->entity_link_list = [];
        $this->listeEntity = [];
        $this->objectCollection = [];
        $this->objectKeyValue = [];
        $this->select = false;

        if (is_object($object)) {

            $this->object = $object;
            $this->objectName = strtolower(get_class($object));
            $this->table = strtolower($this->objectName);

            if (!$this->tableExists($this->table)) {
                if ($metadata = $em->getClassMetadata("\\" . $this->objectName)) {
                    $this->table = strtolower($metadata->table['name']);
                }
            }

            $this->instanceid = $object->getId();
            $keys = $object->entityKey($this->entity_link_list, $this->objectCollection, $this->softdelete);
            $this->objectVar = array_keys($keys);
            $this->objectValue = array_values($keys);
            $this->objectKeyValue = $keys;
            $this->hasrelation = !empty($this->entity_link_list);
            $this->nbVar = count($this->objectVar);
            $this->en = $this->nbVar - 1;

            //var_dump($this);

        }
    }

    /**
     * Réinitialise l'instance du DBAL
     * c'est notament utile pour la persistance des objets avec des attributs null dans le cas d'une relation 1:n
     */
    private function ResetObject()
    {
        $link = $this->link;
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
        $this->link = $link;
    }

    /**
     * Check if a table exists in the current database.
     *
     * @param PDO $pdo PDO instance connected to a database.
     * @param string $table Table to search for.
     * @return bool TRUE if table exists, FALSE if no table found.
     */
    public function tableExists($table, $pdo = null)
    {

        // Try a select statement against the table
        // Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
        try {
            $query = $this->link->query("SELECT 1 FROM " . strtolower($table) . " LIMIT 1");
        } catch (Exception $e) {
            // We got an exception == table not found
            return FALSE;
        }
        // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
        if ($query) {
            $result = $query->fetch();
            return true;
        } else {
            return false;
        }
    }

}
