<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormManager
 *
 * @author azankang
 */

define('FORMTYPE_TEXT', 'text');
define('FORMTYPE_DATE', 'date');
define('FORMTYPE_DATETIME', 'datetime');
define('FORMTYPE_TEXTAREA', 'textarea');
define('FORMTYPE_SELECT', 'select');
define('FORMTYPE_SELECTGROUP', 'selectgroup');
define('FORMTYPE_CHECKBOX', 'checkbox');
define('FORMTYPE_RADIO', 'radio');
define('FORMTYPE_FILE', 'file');
define('FORMTYPE_FILEMULTIPLE', 'filemultiple');
define('FILETYPE_IMAGE', 'image');
define('FILETYPE_DOCUMENT', 'document');
define('FILETYPE_VIDEO', 'video');
define('FILETYPE_AUDIO', 'audio');
define('FORMTYPE_EMAIL', 'email');
define('FORMTYPE_NUMBER', 'number');
define('FORMTYPE_PASSWORD', 'password');
define('FORMTYPE_INJECTION', 'injection');
define('FORMTYPE_INJECT_COLLECTIONFORM', 'injectioncollection');

define('FH_TYPE', 'type');
define('FH_FILETYPE', 'filetype');
define('FH_VALUE', 'value');
define('FH_LABEL', 'label');
define('FH_DIRECTIVE', 'directive');
define('FH_ID', 'id');
define('FH_OPTIONS', 'options');
define('FH_IMBRICATE', 'imbricate');
define('FH_REQUIRE', 'require');
define('FH_ENABLECOLLECTIONFORMINJECTION', true);
define('FH_COLLECTIONFORMINJECTION', 'collectionforminjection');

abstract class FormManager {
    //put your code here
//    abstract function __renderForm($entity = null) ;

    public $entity;
    public $dventity;
    public $classname;
    public $name;
    public $js;
    public $css;
    public $formbutton;
    public $formaction;
    public $fields = [];

    public function __construct($entity, $action = "")
    {
        $this->formaction = $action;
        $this->formbutton = $action? true : false;
        $this->entity = $entity;
        $this->classname = get_class($entity);
        $this->name = strtolower(get_class($entity));
        $this->js = [];
        $this->css = [];
        $this->dventity = Dvups_entity::getbyattribut("this.name", $this->classname);

    }

    /**
     * @param $name
     * @param $option
     * @return $this
     */
    public function addField($name, $option){
        $this->fields[$name] = $option;
        return $this;
    }

    public function addJs($jsfile){
        $this->js[] = $jsfile;
        //$this->js[] = $this->dventity->hydrate()->dvups_module->route($jsfile);
        return $this;
    }

    public function addCss($cssfile){
        $this->css[] = $this->dventity->dvups_module->route($cssfile);
        return $this;
    }

    public function addDformjs(){
        $this->js[] = CLASSJS."dform";
        return $this;
    }

    public function buildEntityCore(){
        return (object) [
            "entity"=>$this->entity,
            "classname"=>$this->classname,
            "name"=>$this->name,
            "addcss"=>$this->css,
            "addjs"=>$this->js,
            "formbutton"=>$this->formbutton,
            "formaction"=>$this->formaction,
            "field"=>$this->fields,
        ];
    }

    public function renderForm(){
        FormFactory::$langs = Dvups_lang::allrows();
        return FormFactory::__renderForm($this->buildEntityCore());
    }

    public static function  printHtmlForm($entitycore, $rootdir){

        $fichier = fopen($rootdir.'/Ressource/html/' . ucfirst($entitycore->name) . '.html', 'w');
        fputs($fichier, FormFactory::__renderForm($entitycore));
        fclose($fichier);

    }
/*
    public static function addjs($js){
        $reflection = new ReflectionClass(get_called_class());
        $filename = explode("\src", str_replace(get_called_class().".php", "", $reflection->getFilename()));
        $filename = explode("\\", $filename[1]);

        return __env . "src/" .$filename[1]."/". $filename[2] ."/Ressource/js/" . $js;
    }*/

    static function Options_ToCollect_Helper($value, $entity, $currentcollection, $enablecollectionforminjection = false) {
        
        $qb = new QueryBuilder($entity);
        if($currentcollection && $currentcollection[0]->getId()){
            foreach ($currentcollection as $collected) {
                $ids[] = $collected->getId();
            }
            
            $entitylist = $qb->select()
                    ->where(strtolower(get_class($entity)).".id")
                    ->notin($ids)
                    ->__getAll(false);
            
        }else{
            
            $entitylist = $qb->select()->__getAll(false);
            
        }

        return FormManager::Options_Helper($value, $entitylist, "id", $enablecollectionforminjection);
            
    }
    
    static function Options_ToCollectFormInjection_Helper($value,  $entity, $currentcollection, $entitybaseon) {
        
        $qb = new QueryBuilder($entitybaseon);
        if($currentcollection && $currentcollection[0]->getId()){
            foreach ($currentcollection as $collected) {
                $ids[] = $collected->contentmodel->getId();
            }
            
//            $qb = new QueryBuilder(new Contentmodel());
            $entitylist = $qb->select()
                    ->where("contentmodel.id")
                    ->notin($ids)
                    ->__getAll(false);
            
        }else{
            
            $entitylist = $qb->select()->__getAll(false);
            
        }
        
        return FormManager::Options_Helper($value, $entitylist,  "id", true);
            
    }
    
    static function Options_Helper($value, $entitylist = [], $key = "id", $enablecollectionforminjection = false) {
        
        global $__controller_traitment;
        
        $key_value = [];
        
        if(isset($entitylist[0]) && is_object($entitylist[0]) && !$entitylist[0]->getId()) return [];
//        if($__controller_traitment) return EntityCollection::entity_collection($value);
        $entitylist2 = [];
        foreach ($entitylist as $entity) {
            $join = explode(".", $value);
                if (isset($join[1])) {

//                    $collection = explode("::", $join[0]);
//                    $src = explode(":", $join[0]);
//
//                    if (isset($src[1]) and $src[0] = 'src') {
//
//                        $entityjoin = call_user_func(array($entity, 'get' . ucfirst($src[1])));
//                        $file = call_user_func(array($entityjoin, 'show' . ucfirst($join[1])));
//
//                        $tr[] = "<img class='dv-img' width='50' src='" . $file . "' />";
//                        
//                        $entityjoin = call_user_func(array($entity, 'get' . ucfirst($join[1])));
//                        
//                        $key_value[call_user_func(array($entity, 'get' . ucfirst($key)))] = call_user_func(array($entityjoin, 'get' . ucfirst($join[1])));
//                    } 
//                    elseif (isset($collection[1])) {
//                        $td = [];
//                        $entitycollection = call_user_func(array($entity, 'get' . ucfirst($collection[1])));
//                        foreach ($entitycollection as $entity) {
//                            $entityjoin = call_user_func(array($entity, 'get' . ucfirst($join[0])));
//                            $td[] = '<td>' . call_user_func(array($entityjoin, 'get' . ucfirst($join[1]))) . '</td>';
//                        }
//                        $tr[] = '<td>' . call_user_func(array($entityjoin, 'get' . ucfirst($join[1]))) . '</td>';
//                    } 
//                    else {
                        $entityjoin = call_user_func(array($entity, 'get' . ucfirst($join[0])));
                        
                        $key_value[call_user_func(array($entity, 'get' . ucfirst($key)))] = call_user_func(array($entityjoin, 'get' . ucfirst($join[1])));
                    
//                    }
                }
                else {
                    if (method_exists($entity, 'get' . ucfirst($value)))
                        $key_value[call_user_func(array( $entity, 'get' . ucfirst($key)))] = call_user_func(array($entity, 'get' . ucfirst($value)));
                    else
                        $key_value[$entity->{$key}] = $entity->{$value};
                }
                $entitylist2[call_user_func(array($entity, 'getId' ) )] = $entity; 
        }
        
        if($enablecollectionforminjection)
            return ["list" => $key_value, "forcollectionform" => $entitylist2];
        else
            return $key_value;
        
    }

    public static function key_as_value(array $array, $translate = false)
    {
        $key_value = [];
        foreach ($array as $item){
            $key_value[$item] = t("option.".$item, $item);
        }
        return $key_value;
    }


}
