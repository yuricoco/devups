<?php

/**
 * @Entity @Table(name="dvups_role")
 * */
class Dvups_role extends Model implements JsonSerializable
{

    static $SELLER = "seller";

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="name", type="string" , length=255 )
     * @var string
     * */
    protected $name;
    /**
     * @Column(name="alias", type="string" , length=255 )
     * @var string
     * */
    protected $alias;

    /**
     * @var \Dvups_right
     */
    public $dvups_right;

    /**
     * @var \Dvups_module
     */
    public $dvups_module;

    /**
     * @var \Dvups_entity
     */
    public $dvups_entity;

    public $dv_collection = ["dvups_component","dvups_right", "dvups_module", "dvups_entity"];

    public function array_rigth()
    {
        $array_rigth = [];

        foreach ($this->rigth as $rigth) {
//                var_dump(EntityCollection::getCollection($rigth));
//                var_dump($rigth);
            $array_rigth[] = strtolower($rigth->getNom());
        }
        return $array_rigth;
    }

    public function array_gestion()
    {
        $array_gestion = [];
        $array_gestion_avance = [];
        $gestionDao = new GestionDAO();
        foreach ($this->gestion as $gestion) {
            $gestion = $gestionDao->findById($gestion->getId());
//				$privilege = $gestion->array_rigth();
//				$array_gestion[] = strtolower($gestion->getNom());
//				if(!empty($privilege)):
//					$array_gestion_avance[strtolower($gestion->getNom())] = $privilege;
//				endif;
            $array_gestion[] = strtolower($gestion->getNom());
            if (!empty($this->rigth)):
                $array_gestion_avance[strtolower($gestion->getNom())] = $this->array_rigth();
            elseif (empty($this->rigth)):
                $privilege = $gestion->array_rigth();
                if (!empty($privilege))
                    $array_gestion_avance[strtolower($gestion->getNom())] = $privilege;
            endif;
        }
        $_SESSION['privilege_avance'] = $array_gestion_avance;

        return $array_gestion;
    }

    public function __construct($id = null)
    {

        if ($id)
            $this->id = $id;

        $this->dvups_right = [];
        $this->dvups_component = [];
        $this->dvups_module = [];
        $this->dvups_entity = [];
    }

    function collectDvups_right()
    {
        $this->dvups_right = $this->__hasmany('dvups_right');
        return $this->dvups_right;
    }

    function collectDvups_component()
    {
        $this->dvups_component = $this->__hasmany('dvups_component');
        return $this->dvups_component;
    }

    function collectDvups_moduleOfComponent(\Dvups_component $component)
    {
        $this->dvups_module = $this->__hasmany('dvups_module', false)
            ->andwhere("dvups_module.dvups_component_id", $component->getId())
            ->__getAll();

        return $this->dvups_module;
    }

    function collectDvups_module()
    {
        $this->dvups_module = $this->__hasmany('dvups_module');

        return $this->dvups_module;
    }

    function collectDvups_entityOfModule(\Dvups_module $module)
    {
        $this->dvups_entity = $this->__hasmany('dvups_entity', false)
            ->andwhere("dvups_entity.dvups_module_id", $module->getId())
            ->__getAll();

        return $this->dvups_entity;
    }
    function collectDvups_entity()
    {
        $this->dvups_entity = $this->__hasmany('dvups_entity');
        return $this->dvups_entity;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     *  manyToMany
     * @return \Dvups_right
     */
    function setDvups_right($rigth)
    {
        $this->dvups_right = $rigth;
    }

    function setDvups_module($dvups_module)
    {
        $this->dvups_module = $dvups_module;
    }

    function setDvups_component($dvups_module)
    {
        $this->dvups_component = $dvups_module;
    }

    function setDvups_entity($dvups_entity)
    {
        $this->dvups_entity = $dvups_entity;
    }

    /**
     *  manyToMany
     * @return \Dvups_right
     */
    function getDvups_right()
    {
        return $this->dvups_right;
    }

    function addDvups_right(\Dvups_right $dvups_right)
    {
        $this->dvups_right[] = $dvups_right;
    }

    function dropDvups_rightCollection()
    {
        $this->dvups_right = EntityCollection::entity_collection('dvups_right');
    }

    /**
     *  manyToMany
     * @return \Dvups_module
     */
    function getDvups_module()
    {
        return $this->dvups_module;
    }

    function addDvups_module(\Dvups_module $dvups_module)
    {
        $this->dvups_module[] = $dvups_module;
    }

    function dropDvups_moduleCollection()
    {
        $this->dvups_module = EntityCollection::entity_collection('dvups_module');
    }

    /**
     *  manyToMany
     * @return \Dvups_entity
     */
    function getDvups_entity()
    {
        return $this->dvups_entity;
    }

    function addDvups_entity(\Dvups_entity $dvups_entity)
    {
        $this->dvups_entity[] = $dvups_entity;
    }

    function dropDvups_entityCollection()
    {
        $this->dvups_entity = EntityCollection::entity_collection('dvups_entity');
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'alias' => $this->alias,
            'dvups_right' => $this->dvups_right,
            'dvups_module' => $this->dvups_module,
            'dvups_entity' => $this->dvups_entity,
        ];
    }

    public function is($role)
    {
        if ($this->name == $role)
            return true;

        return false;
    }

    public function isIn($roles)
    {
        if (in_array($this->name, $roles))
            return true;

        return false;
    }

    public static function updateprivilegeAction()
    {

        $admin = getadmin();
        if ($admin->dvups_role->hydrate()->is("admin"))
            return '<button onclick="model.updateprivilege(this)"  class=\'btn btn-info\'> ' . t("Update Privilege") . ' </button>';

    }

}
