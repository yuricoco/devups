<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="imagecms")
 * */
class Imagecms extends Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * OneToOne
     * @ManyToOne(targetEntity="\Dv_image")
     * @JoinColumn(onDelete="cascade")
     * @var \Dv_image
     */
    public $image;
    /**
     * OneToOne
     * @ManyToOne(targetEntity="\Cmstext")
     * @JoinColumn(onDelete="cascade")
     * @var \Cmstext
     */
    public $cmstext;

    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }
        $this->cmstext = new Cmstext();
        $this->image = new Dv_image();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Dv_image
     */
    public function getImage(): Dv_image
    {
        return $this->image->__show();
    }

    /**
     * @param Dv_image $image
     */
    public function setImage(Dv_image $image): void
    {
        $this->image = $image;
    }

    /**
     * @return Cmstext
     */
    public function getCmstext(): Cmstext
    {
        return $this->cmstext;
    }

    /**
     * @param Cmstext $cmstext
     */
    public function setCmstext(Cmstext $cmstext): void
    {
        $this->cmstext = $cmstext;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
        ];
    }

}
