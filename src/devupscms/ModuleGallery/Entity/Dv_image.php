<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="dv_image")
 * */
class Dv_image extends ImageCore implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;


    /**
     * @ManyToOne(targetEntity="\Tree_item")
     *
     * @var \Tree_item
     */
    public $folder;
    /**
     * @ManyToOne(targetEntity="\Tree_item")
     *
     * @var \Tree_item
     */
    public $position;


    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

        $this->folder = new Tree_item();
        $this->position = new Tree_item();

    }

    /**
     * get all image in a specific folder
     * @param string $foldername
     * @return array
     */
    public static function infolder(string $foldername)
    {
        $folder = Tree_item::where(["tree.name" => "folder", "this.name" => $foldername])->__getOne();
        return self::where("folder_id", $folder->getId())->__getAll();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Tree_item
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param Tree_item $position
     */
    public function setPosition($position)
    {
        Dv_image::where("this.position_id", $position->getId())->update(["position_id" => null]);

        $this->position = $position;
    }

    /**
     * @return Tree_item
     */
    public function getFolder(): Tree_item
    {
        return $this->folder;
    }

    /**
     * @param Tree_item $folder
     */
    public function setFolder(Tree_item $folder): void
    {
        $this->folder = $folder;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }


    public function uploadImage($file = 'image')
    {
        $dfile = self::Dfile($file);
        if (!$dfile->errornofile) {

            $filedir = 'gallery/';
            $url = $dfile
                ->sanitize($this->id . "_")
                ->addresize([150, 150], "150_", "", true)
                ->addresize([50, 50], "50_", "", false)
                ->moveto($filedir);

            if (!$url['success']) {
                return array('success' => false,
                    'error' => $url);
            }

            $this->image = $url['file']['hashname'];
            $this->name = $url['file']['hashname'];
            $this->reference = $url['file']['hashname'];

            $this->setName(Request::post("name"));
//            $this->setWidth($url["file"]["width"]);
//            $this->setHeight($url["file"]["height"]);
            $this->setSize($url["file"]["imagesize"]);
            $this->setImage($url["file"]["hashname"]);

        }
    }

    public function uploadSlide($file = 'image')
    {
        $dfile = self::Dfile($file);
        if (!$dfile->errornofile) {

            $filedir = 'slider/';
            $url = $dfile
                ->sanitize()
                ->moveto($filedir);

            if (!$url['success']) {
                return array('success' => false,
                    'error' => $url);
            }

            $this->uploaddir = 'slider/';
            $this->image = $url['file']['hashname'];
            $this->name = $url['file']['hashname'];

        }
    }

    public function showImage()
    {
        $url = Dfile::show($this->image, 'dv_image');
        return Dfile::fileadapter($url, $this->image);
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'name' => $this->name,
            'description' => $this->description,
            'position' => $this->position,
            'image' => $this->image,
            'size' => $this->size,
            'width' => $this->width,
            'height' => $this->height,
        ];
    }

    public function __delete($exec = true)
    {
        Dfile::deleteFile($this->image, $this->uploaddir);
        Dfile::deleteFile("150_" . $this->image, $this->uploaddir);
        Dfile::deleteFile("50_" . $this->image, $this->uploaddir);

        return parent::__delete($exec); // TODO: Change the autogenerated stub
    }

    public static function templatePosition($ref)
    {
        $ti = Tree_item::position($ref);
        return self::getbyattribut("this.position_id", $ti->getId())->srcImage();
    }

}
