<?php

class Templatemodel extends \Model implements JsonSerializable {

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;

    /**
     * @Column(name="label", type="string" , length=50 )
     * @var string
     * */
    protected $label;

    /**
     * @Column(name="position", type="integer" )
     * */
    protected $position;


    public function getId() {
        return $this->id;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

    function getPosition() {
        return $this->position;
    }

    function setPosition($position) {
        $this->position = $position;
    }

    function dropArticleCollection() {
        $this->article = EntityCollection::entity_collection('article');
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'article' => $this->article,
        ];
    }

}
