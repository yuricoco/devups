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
        // $this->tree_item = new Tree_item();

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
    /**
     * get all image in a specific folder
     * @param string $foldername
     * @return QueryBuilder
     */
    public static function folderhas(string $foldername)
    {
        $folder = Tree_item::where(["tree.name" => "folder", "this.name" => $foldername])->__getOne();
        return self::where("folder_id", $folder->getId());
    }

    public static $image_attribut;

    public static function uploaded(Model $entity, \Dv_image $old_image, $url, $filedir, $sizes = [])
    {
        $dv_image = new Dv_image();

        $dv_image->folder = Tree_item::mainmenu("folder")
            ->andwhere("this.name", "fund")->__getOne();
        $dv_image->setImage($url["file"]["hashname"]);
        $dv_image->setUploaddir($filedir);
        $dv_image->setSize($url["file"]["imagesize"]);
        $dv_image->__save();

        if(!self::$image_attribut)
            die(print_r("you must specify the Dv_image::\$image_attribut"));

        $entity->__update([
            self::$image_attribut."_id" => $dv_image->getId()
        ]);

        if ($old_image->getId()
            && $old_image->getName() != $dv_image->getName()
        ) {
            $old_image->__show()->__deleteImage($sizes);
        }

        return $dv_image;

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
                ->addresize([270, 270], "270_", "", true)
                ->addresize([50, 50], "50_", "", true)
                ->moveto($filedir);

            if (!$url['success']) {
                return array('success' => false,
                    'error' => $url);
            }

            $this->uploaddir = $filedir;
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

    public function uploadImagecontent($file = 'image')
    {
        $dfile = self::Dfile($file);
        if (!$dfile->errornofile) {

            $filedir = 'gallery/';
            $url = $dfile
                ->sanitize($this->id . "_")
                ->addresize([150, 150], "150_", "", true)
                ->addresize([270, 270], "270_", "", true)
                ->addresize([700, 500], "700_", "", false)
                ->addresize([50, 50], "50_", "", true)
                ->moveto($filedir);

            if (!$url['success']) {
                return array('success' => false,
                    'error' => $url);
            }

            $this->uploaddir = $filedir;
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

    public function uploadImagepost($file = 'image')
    {
        $dfile = self::Dfile($file);
        if (!$dfile->errornofile) {

            $filedir = 'gallery/';
            $url = $dfile
                ->hashname()
                ->addresize([150, 150], "150_", "", true)
                ->addresize([270, 270], "270_", "", true)
                ->addresize([800, 500], "700_", "", false)
                ->addresize([50, 50], "50_", "", true)
                ->moveto($filedir);

            if (!$url['success']) {
                return array('success' => false,
                    'error' => $url);
            }

            $this->uploaddir = $filedir;
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

    public function showImage($prefix = "")
    {
        if(is_array($prefix)) {
            if($prefix)
                $prefix = $prefix[0];
            else
                $prefix = "";
        }
        $url = Dfile::show($prefix.$this->image, $this->uploaddir);
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
            'reference' => $this->uploaddir,
            'name' => $this->name,
            'description' => $this->description,
            //'position' => $this->position,
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
        Dfile::deleteFile("270_" . $this->image, $this->uploaddir);
        Dfile::deleteFile("50_" . $this->image, $this->uploaddir);
        Dfile::deleteFile("700_" . $this->image, $this->uploaddir);

        return parent::__delete($exec); // TODO: Change the autogenerated stub
    }

    public function __deleteImage($sizes)
    {
        Dfile::deleteFile($this->image, $this->uploaddir);
        foreach ($sizes as $size){
            Dfile::deleteFile($size . $this->image, $this->uploaddir);
        }

        return parent::__delete(); // TODO: Change the autogenerated stub
    }

    public static function templatePosition($ref)
    {
        $ti = Tree_item::position($ref);
        return self::getbyattribut("this.position_id", $ti->getId())->srcImage();
    }

}
