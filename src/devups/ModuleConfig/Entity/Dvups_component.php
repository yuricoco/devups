<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="dvups_component")
 * */
class Dvups_component extends Dvups_config_item implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;


    public function __construct($id = null)
    {
        $this->dvsoftdelete = true;
        if ($id) {
            $this->id = $id;
        }

    }

    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getLabel()
    {
        if (!$this->label)
            return $this->name;

        return $this->label;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

}
