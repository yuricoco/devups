<?php

/**
 * @Entity @Table(name="image")
 * */
class Image extends \Model implements JsonSerializable {

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;

    /**
     * @Column(name="image", type="string" , length=255 )
     * @var string
     * */
    private $image;

    public function __construct($id = null) {

        if ($id) {
            $this->id = $id;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function showImage() {
        return Dfile::show($this->image, 'image');
    }

    public function getImage() {
        return $this->image;
    }
    function setImage($image) {
        $this->image = $image;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'image' => $this->image,
        ];
    }

}
