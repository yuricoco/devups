<?php

/**
 * @Entity @Table(name="dvups_role_dvups_component")
 * */
class Dvups_role_dvups_component extends Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;

    /**
     * @ManyToOne(targetEntity="\Dvups_component")
     * @JoinColumn(onDelete="cascade")
     * @var \Dvups_component
     */
    public $dvups_component;

    /**
     * @ManyToOne(targetEntity="\Dvups_role")
     * @JoinColumn(onDelete="cascade")
     * @var \Dvups_role
     */
    public $dvups_role;


    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

        $this->dvups_component = new Dvups_component();
        $this->dvups_role = new Dvups_role();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *  manyToOne
     * @return \Dvups_component
     */
    function getDvups_component()
    {
        return $this->dvups_component;
    }

    function setDvups_component(\Dvups_component $dvups_component)
    {
        $this->dvups_component = $dvups_component;
    }

    /**
     *  manyToOne
     * @return \Dvups_role
     */
    function getDvups_role()
    {
        return $this->dvups_role;
    }

    function setDvups_role(\Dvups_role $dvups_role)
    {
        $this->dvups_role = $dvups_role;
    }


    public function scan_entity_core()
    {
        return Core::__extract(__DIR__, $this);
    }

    public function jsonSerialize()
    {
        return [
            'dvups_component' => $this->dvups_component,
            'dvups_role' => $this->dvups_role,
        ];
    }

}
