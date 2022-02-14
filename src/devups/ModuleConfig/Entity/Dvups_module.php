<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="dvups_module")
 * */
class Dvups_module extends Dvups_config_item implements JsonSerializable, DvupsTranslation
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;

    /**
     * @Column(name="favicon", type="string" , length=255, nullable=true )
     * @var string
     * */
    protected $favicon = "fas fa-fw fa-cog";
    /**
     * @Column(name="label", type="string" , length=255, nullable=true )
     * @var string
     * */
    protected $label;

    /**
     * @Column(name="project", type="string" , length=25 )
     * @var string
     * */
    protected $project;

    /**
     * @ManyToOne(targetEntity="\Dvups_component")
     * @JoinColumn(onDelete="cascade")
     * @var \Dvups_component
     */
    public $dvups_component;


    public function __construct($id = null)
    {

//        $this->dvtranslate = true;
//        $this->dvtranslated_columns = ["label"];

        if ($id) {
            $this->id = $id;
        }

        $this->dvups_component = new Dvups_component();
    }

    public function getId()
    {
        return $this->id;
    }

    public function collectEntities(){
        return $this->__hasmany(Dvups_entity::class);
    }

    public static function init($name)
    {
        $admin = getadmin();
        $dvmodule = Dvups_module::getbyattribut("this.name", $name);
        $dvmodule->dvups_entity = $admin->dvups_role->collectDvups_entityOfModule($dvmodule);
//        $dvups_navigation = unserialize($_SESSION[dv_role_navigation]);
//        foreach ($dvups_navigation as $key => $module) {
//            if ($module["module"]->getName() == $name) {
//                $dvmodule = $module["module"];
//                $dvmodule->dvups_entity = $module["entities"];
//                return $dvmodule;
//            }
//        }
//            $module = Dvups_module::select()->where("name", $name)->__getOne();
//            $module->dvups_entity = $module->__hasmany(Dvups_entity::class);
        return $dvmodule;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        if($this->label)
            return $this->label;
        return  $this->name;
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *  manyToOne
     * @return \Dvups_component
     */
    function getDvups_component()
    {
        $this->dvups_component = $this->dvups_component->__show();
        return $this->dvups_component;
    }

    function setDvups_component(\Dvups_component $dvups_component)
    {
        $this->dvups_component = $dvups_component;
    }

    /**
     * @return string
     */
    public function getFavicon()
    {
        if($this->favicon)
            return $this->favicon;

        return 'mdi mdi-alpha';
    }

    /**
     * @param string $favicon
     */
    public function setFavicon($favicon)
    {
        $this->favicon = $favicon;
    }

    /**
     * @return string
     */
    public function getPrinticon($width = "23")
    {
        if(!file_exists(self::classroot("/icon.svg"))) {
            $icone = $this->route("icon.svg");
            return '<img src="' . $icone . '" width=25 />';
        }
        return '<i class="' . $this->favicon . '"></i>';
    }

    /**
     * @return string
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param string $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'dvups_component' => $this->dvups_component,
        ];
    }
/*
    public function dvupsTranslate()
    {
        // we can iterate on howmuch lang the system may have to initiate all the lang of the new entry
//        $this->__inittranslate("label", $this->label, "en");
//        $this->__inittranslate("label", $this->label, "fr");
        $this->__persistlang(["label"=>$this->name]);
    }*/

    public function route($path = ""){
        return route('src/' . strtolower($this->project) . '/' . $this->name . '/'.$path);
    }

    public function moduleRoot(){

            return ROOT . "src/" . $this->project."/".$this->name."/";
            //return ROOT . "src" . $this->dvups_component->name."/".$this->name."/";

    }

}
