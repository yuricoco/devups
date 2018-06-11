<?php

/**
 * @Entity @Table(name="dvups_entity")
 * */
class Dvups_entity extends Model implements JsonSerializable {

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    private $id;

    /**
     * @Column(name="name", type="string" , length=255 )
     * @var string
     * */
    private $name;

    /**
     * @ManyToOne(targetEntity="\Dvups_module")
     * @var \Dvups_module
     */
    public $dvups_module;

    /**
     * @var \Dvups_right
     */
    public $dvups_right;

    public function __construct($id = null) {

        if ($id) {
            $this->id = $id;
        }

        $this->dvups_module = new Dvups_module();
        $this->dvups_right = EntityCollection::entity_collection('dvups_right');
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    /**
     *  manyToOne
     * 	@return \Dvups_module
     */
    function getDvups_module() {
        return $this->dvups_module;
    }

    function setDvups_module(\Dvups_module $dvups_module) {
        $this->dvups_module = $dvups_module;
    }

    /**
     *  manyToMany
     * 	@return \Dvups_right
     */
    function getDvups_right() {
        return $this->dvups_right;
    }

    function collectDvups_right() {
        $this->dvups_right = $this->__hasmany('dvups_right');
        return $this->dvups_right;
    }

    function availableright() {
        $this->dvups_right = $this->__hasmany('dvups_right');
        if ($this->dvups_right) {
            foreach ($this->dvups_right as $right) {
                $rights[] = $right->getName();
            }
            return $rights;
        }

        return [];
    }

    function addDvups_right(\Dvups_right $dvups_right) {
        $this->dvups_right[] = $dvups_right;
    }

    function dropDvups_rightCollection() {
        $this->dvups_right = EntityCollection::entity_collection('dvups_right');
    }

    public function jsonSerialize() {
        return [
            'name' => $this->name,
            'dvups_module' => $this->dvups_module,
            'dvups_right' => $this->dvups_right,
        ];
    }

}
