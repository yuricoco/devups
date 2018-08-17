<?php

/**
 * @Entity @Table(name="category")
 * */
class Category extends \Model implements JsonSerializable, DvupsTranslation
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="name", type="string" , length=25 )
     * @var string
     **/
    protected $name;


    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->__gettranslate("name", "en");
    }

    public function setName($name)
    {
        $this->name = $name;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    public function dvupsTranslate()
    {
        $this->__inittranslate("name", $this->name, "fr");
    }
}
