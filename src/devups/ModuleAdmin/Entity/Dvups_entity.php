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
     * @Column(name="name", type="string" , length=25 )
     * @var string
     * */
    private $name;

    /**
     * @Column(name="label", type="string" , length=125, nullable=true )
     * @var string
     * */
    private $label;

    /**
     * @return string
     */
    public function getLabel()
    {
        if(!$this->label)
            return $this->name;

        return $this->label;
    }

    function getLabelform()
    {

        $view = '<div style="width: 100%;"><span> ' . $this->label . ' </span>
<span  class="btn btn-default"  onclick="editlabel(this)" data-id="' . $this->id . ' ">edit</span></div>
<div hidden ><input id="input-' . $this->id . '" style="width: 100px;" name="label" value="' . $this->label . '" />
<span class="btn btn-default" onclick="updatelabel(' . $this->id . ')">update</span>
<!--span class="btn" onclick="cancelupdate()">cancel</span-->
</div>';
        return $view;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

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
            'label' => $this->label,
            'dvups_module' => $this->dvups_module,
            'dvups_right' => $this->dvups_right,
        ];
    }

}
