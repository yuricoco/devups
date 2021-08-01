<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="slide")
 * */
class Slide extends Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="activated", type="integer" , nullable=true)
     * @var string
     **/
    protected $activated;
    /**
     * @Column(name="redirect", type="string" , length=150 , nullable=true)
     * @var string
     **/
    protected $redirect;
    /**
     * @Column(name="title", type="string" , length=150 , nullable=true)
     * @var string
     **/
    protected $title;
    /**
     * @Column(name="content", type="text" , nullable=true)
     * @var string
     **/
    protected $content;
    /**
     * @Column(name="position", type="string" , length=55 , nullable=true)
     * @var string
     **/
    private $position;

    /**
     * OneToOne
     * @ManyToOne(targetEntity="\Dv_image")
     * @JoinColumn(onDelete="cascade")
     * @var \Dv_image
     */
    public $image;


    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

        $this->image = new Dv_image();

    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    public function getActivated()
    {
        return $this->activated;
    }

    public function setActivated($activated)
    {
        $this->activated = $activated;
    }

    public function getRedirect()
    {
        return $this->redirect;
    }

    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }
    public function setDv_image($redirect)
    {
        $this->image = $redirect;
    }

    /**
     *  oneToOne
     * @return \Dv_image
     */
    function getImage()
    {
        $this->image = $this->image->__show();
        return $this->image;
    }

    function setImage(\Dv_image $dv_image = null)
    {
        $this->image = $dv_image;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'activated' => $this->activated,
            'redirect' => $this->redirect,
            'image' => $this->image,
            'position' => $this->position,
        ];
    }

    public static function getactivatedslides($position = "slider", $limit=6)
    {
        return self::where("this.activated", 1)
            //->andwhere("position", $position)
            ->orderby("this.position")
            ->limit($limit)->__getAll();
    }

    public function uploadImage($file){

        //$dfile = Dfile::init("croppedImage");
        //$data = file_get_contents($dfile->tmp_name);
        //\DClass\lib\Util::writein($data, "uploads/slider/test.png");
        $dfile = self::Dfile($file);
        if (!$dfile->errornofile) {

            $filedir = "slider/";
            $url = $dfile
                ->setfile_name($this->id."-slider.jpg")
                //->sanitize()
                //->setUploaddir($filedir)
                ->saveoriginal(false)
                ->addresize([1900, 600], "", "", false, 30)
                ->addresize([720, 360], "720_", "", false)
                ->addresize([150, 150], "150_", "", false)
                ->addresize([50, 50], "50_", "", false)
                //->resizethisimage("slider/test.png");
                ->moveto($filedir);

            if (!$url['success']) {
                return array('success' => false,
                    'error' => $url);
            }

            if($this->image->getId())
                $dv_image = $this->image;
            else
                $dv_image = new Dv_image();

            $dv_image->folder = Tree_item::mainmenu("folder")->andwhere("this.name", "slider")->__getOne();
            $dv_image->setImage($url["file"]["hashname"]);
            $dv_image->setUploaddir($filedir);
            $dv_image->setSize($url["file"]["imagesize"]);
            $dv_image->__save();

            $this->image = $dv_image;

        }

    }

}
