<?php

/**
 * @Entity @Table(name="dvups_module")
 * */
class Dvups_module extends Model implements JsonSerializable, DvupsTranslation
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="name", type="string" , length=25 )
     * @var string
     * */
    private $name;
    /**
     * @Column(name="favicon", type="string" , length=255, nullable=true )
     * @var string
     * */
    private $favicon = "fas fa-fw fa-cog";
    /**
     * @Column(name="label", type="string" , length=125, nullable=true )
     * @var string
     * */
    private $label;
    /**
     * @Column(name="project", type="string" , length=25 )
     * @var string
     * */
    private $project;

    /**
     * @var \Dvups_entity
     */
    //public $dvups_entity;


    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

    }

    public static function init($name)
    {
        $dvmodule = new Dvups_module();
        $dvups_navigation = unserialize($_SESSION[dv_role_navigation]);
        foreach ($dvups_navigation as $key => $module) {
            if ($module["module"]->getName() == $name) {
                $dvmodule = $module["module"];
                $dvmodule->dvups_entity = $module["entities"];
                return $dvmodule;
            }
        }
//            $module = Dvups_module::select()->where("name", $name)->__getOne();
//            $module->dvups_entity = $module->__hasmany(Dvups_entity::class);
        return $dvmodule;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        if (!$this->label)
            return $this->name;

        return $label = $this->__gettranslate("label", $this->label);
        if($label)
            return $label;

        return  $this->label;

    }

    function getLabelform()
    {

        $view = '<div style="width: 100%;"><span> ' . $this->label . ' </span>
<span  class="btn btn-default"  onclick="editlabel(this)" data-id="' . $this->id . ' ">edit</span></div>
<div hidden ><input id="input-' . $this->id . '" style="width: 100px;" name="label" value="' . $this->label . '" />
<span class="btn btn-default" onclick="updatelabel(' . $this->id . ')">update</span>
<!--span class="btn" onclick="cancelupdate()">cancel</span-->
</div>';
        return $view;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getFavicon()
    {
        return $this->favicon;
    }

    /**
     * @return string
     */
    public function getPrinticon()
    {
        return '<i class="' . $this->favicon . '"></i>';
    }

    /**
     * @param string $favicon
     */
    public function setFavicon($favicon)
    {
        $this->favicon = $favicon;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    function getProject()
    {
        return $this->project;
    }

    function setProject($project)
    {
        $this->project = $project;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
        ];
    }

    public function dvupsTranslate()
    {
        // we can iterate on howmuch lang the system may have to initiate all the lang of the new entry
        $this->__inittranslate("label", $this->label, "en");
        $this->__inittranslate("label", $this->label, "fr");
    }
}
