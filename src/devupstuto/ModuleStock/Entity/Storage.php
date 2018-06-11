<?php

/**
 * @Entity @Table(name="storage")
 * */
class Storage extends \Model implements JsonSerializable {

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;

    /**
     * @Column(name="town", type="string" , length=25 )
     * @var string
     * */
    public $town;

    public function __construct($id = null) {

        if ($id) {
            $this->id = $id;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getTown() {
        return $this->town;
    }

    public function setTown($town) {
        $this->town = $town;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'town' => $this->town,
        ];
    }

}
