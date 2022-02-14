<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Generator
 *
 * @author azankang
 */
class __Generator {

    private static $modulecore;
    private static $projectcore;
    private static $entitycore;

    public static function help() {

        echo "\nDevups Command Line Interface version 2.4.8

Usage:
  command [options] [arguments]\n\nAvailable commands:\n";

        $commend[] = "core:g:component <component>                      // generate an entity crud from core eg: component\module\entity";
        $commend[] = "core:g:module <component\\module>                  // generate an entity crud from core eg: component\module\entity";
        $commend[] = "core:g:crud <component\module\\entity>             // generate an entity crud from core";
        $commend[] = "core:g:entity <component\module\\entity>           // generate an entity from core eg: component\module\entity";
        $commend[] = "core:g:controller <component\module\\entity>       // generate a controller from core eg: component\module\entity";
        $commend[] = "core:g:form <component\module\\entity>             // generate an entity from core eg: component\module\entity";
        $commend[] = "core:g:formwidget <component\module\\entity>            // generate an entity from core eg: component\module\entity";
        $commend[] = "core:g:views <component\module\\entity>            // generate an entity from core eg: component\module\entity";
        $commend[] = "core:g:viewswidget <component\module\\entity>          // generate an entity from core eg: component\module\entity\n ";
        $commend[] = "core:g:dependencies <component\module\\entity>          // generate an entity from core eg: component\module\entity\n ";

        $commend[] = "core:g:moduleendless <component\module>          // generate the module index; services; dependencies and layout\n ";
        $commend[] = "core:g:moduledependencies <component\module>          // generate the module dependencies from core eg: component\module\entity\n ";
        $commend[] = "core:g:moduleindex <component\module>          // generate an entity from core eg: component\module\entity\n ";
        $commend[] = "core:g:moduleservices <component\module>          // generate an entity from core eg: component\module\entity\n ";
        $commend[] = "core:g:moduleressources <component\module>          // generate an entity from core eg: component\module\entity\n ";

        $commend[] = "entity:g:core <component\module\\entity>          // generate a core from entity eg: component\module\entity\n ";

        $commend[] = "install                 // create database, create database schema and create master admin ";
        $commend[] = "dvups_:update           // update right of master admin on new modules and entities ";

        echo "\n\t -> ".implode("\n\t -> ", $commend);
        
    }

    public static function findproject($components, $search) {
        $projectcore = null;
        foreach ($components as $project) {
            if(!is_object($project))
                break;
            
            $projects[] = $project->name;
            if ($project->name == $search) {
                $projectcore = $project;
                break;
            }
            // generator::module();
        }

        if (!$projectcore) {
            echo "ERROR : projectCore '" . $search . "' not found\n";
            echo("You may have tried : \n -> " . implode("\n -> ", $projects));
            die;
        }

        __Generator::$projectcore = $projectcore;
        return $projectcore;
    }

    private static function findmodule($project, $search) {
        $modulecore = null;
        foreach ($project->listmodule as $module) {
            if(is_object($module)){
                $modules[] = $module->name;
                if ($module->name == $search) {
                    $modulecore = $module;
                    break;
                }
            }
            // generator::module();
        }

        if (!$modulecore) {
            echo "ERROR : module '" . $search . "' not found\n";
            echo("You may have tried : \n -> " . implode("\n -> ", $modules));
            die;
        }

        __Generator::$modulecore = $modulecore;
        return $modulecore;
    }

    private static function findentity($project, $module, $entityname) {

        $modulecore = __Generator::findmodule($project, $module);

        if (!$modulecore)
            return null;

        $entitycore = null;
        foreach ($modulecore->listentity as $entity) {
            // generator::entity()
            $moduleentities[] = $entity->name;
            if ($entity->name == strtolower($entityname)) {
                $entitycore = $entity;
                break;
            }
        }

        if (!$entitycore) {
            echo "ERROR : entity '" . $entityname . "' not found\n";
            echo("You may have tried : \n -> " . implode("\n -> ", $moduleentities));
            die;
        }

        __Generator::$entitycore = $entitycore;
        return $entitycore;
    }

    /**
     * 
     * @param type $namespace
     */
    public static function component($project) {

        __Generator::$projectcore = $project;
        foreach ($project->listmodule as $module) {

            __Generator::$modulecore = $module;
            foreach ($module->listentity as $entity) {

                __Generator::$entitycore = $entity;
                __Generator::__entity($entity, $project, true);
                
            }
            // generator::module();
             __Generator::moduleendless(__Generator::$projectcore, $module, $module->listentity);
        }
    }

    /**
     * 
     * @param type $namespace
     */
    public static function module($project, $namespace) {
        global $separator, $isWindows;
        if($isWindows)
            $ns = str_replace($separator, "/", $namespace);
        else $ns = $namespace;
        
        $mn = explode("/", $ns);

        $file = __DIR__ . "/../../src/" . $ns . "/" . strtolower($mn[1]) . "Core.json";
        if(!file_exists($file)) {
            echo "!!! Oops the modulev '".$mn[1]."' has not been founded !!!";
            die();
        }
        $module = json_decode(file_get_contents($file));

        __Generator::$modulecore = $module;
        __Generator::$projectcore = $project;
        __Generator::__module($module);

        foreach ($module->listentity as $entity) {
            __Generator::__entity($entity, $project);
        }
                
        __Generator::moduleendless(__Generator::$projectcore, $module, $module->listentity);
                
    }

    /**
     * 
     * @param type $namespace
     */
    public static function __moduleendless($project, $namespace) {

       global $separator, $isWindows;
        if($isWindows)
            $ns = str_replace($separator, "/", $namespace);
        else $ns = $namespace;

        $mn = explode("/", $ns);
        $module = __Generator::findmodule($project, $mn[1]);
//        die(var_dump($module));
//        $module = json_decode(file_get_contents(ROOT . "src/" . $ns . "/" . strtolower($mn[1]) . "Core.json"));
//        __Generator::$modulecore = $module;
        __Generator::$projectcore = $project;
        
        __Generator::moduleendless(__Generator::$projectcore, $module, $module->listentity, true);
        
    }
    /**
     *
     * @param type $namespace
     */
    public static function __index($project, $namespace) {

       global $separator, $isWindows;
        if($isWindows)
            $ns = str_replace($separator, "/", $namespace);
        else $ns = $namespace;
        $mn = explode("/", $ns);
        $module = __Generator::findmodule($project, $mn[1]);

        __Generator::index($module, $module->listentity);

    }

    /**
     *
     * @param type $namespace
     */
    public static function __dependencies($project, $namespace) {

        global $separator, $isWindows;
        if($isWindows)
            $ns = str_replace($separator, "/", $namespace);
        else $ns = $namespace;
        $mn = explode("/", $ns);
        $module = __Generator::findmodule($project, $mn[1]);

        __Generator::$projectcore = $project;

        __Generator::moduledependencies(__Generator::$projectcore, $module, $module->listentity);

    }

    /**
     *
     * @param type $namespace
     */
    public static function __services($project, $namespace) {

        global $separator, $isWindows;
        if($isWindows)
            $ns = str_replace($separator, "/", $namespace);
        else $ns = $namespace;
        $mn = explode("/", $ns);
        $module = __Generator::findmodule($project, $mn[1]);

        __Generator::services($module, $module->listentity);

    }

    /**
     *
     * @param type $namespace
     */
    public static function __ressources($project, $namespace) {

        global $separator, $isWindows;
        if($isWindows)
            $ns = str_replace($separator, "/", $namespace);
        else $ns = $namespace;
        $mn = explode("/", $ns);
        $module = __Generator::findmodule($project, $mn[1]);
        __Generator::$projectcore = $project;

        __Generator::moduleressources(__Generator::$projectcore, $module, $module->listentity);

    }

    /**
     * 
     * @param type $namespace
     */
    public static function views($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false, ['entity' => false, 'table' => false, 'ctrl' => false, 'form' => false, 'genes' => false, 'views' => true]);
    }

    /**
     * 
     * @param type $namespace
     */
    public static function core($namespace, $sync = false) {

        $ns = explode("\\", $namespace);
        //__Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__core($ns[2], $ns[1], $sync);

    }
    /**
     *
     * @param type $namespace
     */
    public static function postmandoc($namespace, $project) {

        $ns = explode("\\", $namespace);
        //__Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__postmandoc($ns[2], $ns[1]);

    }
    /**
     *
     * @param type $namespace
     */
    public static function genesis($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false, ['entity' => false, 'table' => false, 'ctrl' => false, 'form' => false, 'genes' => true, 'views' => false]);
    }

    /**
     * 
     * @param type $namespace
     */
    public static function table($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false, ['entity' => false, 'table' => true, 'ctrl' => false, 'form' => false, 'genes' => false, 'views' => false]);
    }

    public static $ctrltype = '';
    /**
     *
     * @param type $namespace
     */
    public static function controller($namespace, $project) {
        self::$ctrltype = "both";
        //self::$ctrltype = "default";

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false, ['entity' => false, 'table' => false, 'ctrl' => true, 'form' => false, 'genes' => false, 'views' => false]);
    }
    /**
     *
     * @param type $namespace
     */
    public static function frontcontroller($namespace, $project) {
        self::$ctrltype = "front";

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false, ['entity' => false, 'table' => false, 'frontctrl' => true, 'ctrl' => false, 'form' => false, 'genes' => false, 'views' => false]);
    }

    /**
     * 
     * @param type $namespace
     */
    public static function form($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false, ['entity' => false, 'table' => false, 'ctrl' => false, 'form' => true, 'genes' => false, 'views' => false]);
    }

    /**
     *
     * @param type $namespace
     */
    public static function formwidget($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false, ['entity' => false, 'table' => false, 'ctrl' => false, 'form' => false, 'formwidget' => true, 'genes' => false, 'views' => false]);
    }

    /**
     *
     * @param type $namespace
     */
    public static function detailwidget($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false, ['entity' => false, 'table' => false, 'ctrl' => false, 'form' => false, 'formwidget' => false, 'genes' => false, 'views' => false, 'detailwidget' => true]);
    }

    /**
     * 
     * @param type $namespace
     */
    public static function entity($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false,
            ['entity' => true, 'table' => false, 'ctrl' => false, 'form' => false, 'genes' => false, 'views' => false]);
    }
    /**
     *
     * @param type $namespace
     */
    public static function entityLang($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false,
            ['lang' => true, 'entity' => false, 'table' => false, 'ctrl' => false, 'form' => false, 'genes' => false, 'views' => false]);
    }

    /**
     * 
     * @param type $namespace
     */
    public static function crud($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project);
        __Generator::dependencies($project, __Generator::$modulecore, $entity);
    }
    /**
     *
     * @param type $namespace
     */
    public static function __entitydependencies($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::dependencies($project, __Generator::$modulecore, $entity);
    }

    private static function __core($entity, $module, $sync = false){

        $backend = new BackendGenerator();
        $repertoire = ucfirst($module);
        //$repertoire = ucfirst(__Generator::$modulecore->name);
        chdir($repertoire);

        $backend->coreGenerator($entity, $sync);

        chdir('../');
    }

    private static function __postmandoc($entity, $module){

        $backend = new BackendGenerator();
        $repertoire = ucfirst($module);
        //$repertoire = ucfirst(__Generator::$modulecore->name);
        chdir($repertoire);

        $backend->postmandocGenerator($entity);

        chdir('../');
    }

    /**
     * 
     * @param type $namespace
     */
    private static function __entity($entity, $project, $setdependance = false, $crud = ['lang' => true, 'entity' => true, 'table' => true, 'ctrl' => true, 'form' => true, 'views' => false, 'detailwidget' => false]) {

        $backend = new BackendGenerator();
        $frontend = new AdminTemplateGenerator();

        $repertoire = ucfirst(__Generator::$modulecore->name);

        __Generator::__module(__Generator::$modulecore, $setdependance);

        chdir($repertoire);

        $entity->attribut = (array) $entity->attribut;

        if ($crud['entity'])
            $backend->entityGenerator($entity);

        if (isset($crud['lang']) && $crud['lang'] && isset($entity->lang))
            $backend->entityLangGenerator($entity);

        if ($crud['ctrl'])
            $backend->controllerGenerator($entity);

        if (isset($crud['frontctrl']))
            $backend->controllerGenerator($entity, true);

        if ($crud['table'])
            $backend->tableGenerator($entity, $project->listmodule);

        if ($crud['form'])
            $backend->formGenerator($entity, $project->listmodule);

        if (isset($crud['formwidget']) && $crud['formwidget'])
            $backend->formWidgetGenerator($entity, $project->listmodule);

        if (isset($crud['detailwidget']) && $crud['detailwidget'])
            $backend->detailWidgetGenerator($entity, $project->listmodule);

        //if ($crud['views']) {
        self::ressources($entity, $frontend, $crud['views']);
        //}

        $name = strtolower($entity->name);

        $entitycore = fopen('Core/' . ucfirst($name) . 'Core.json', 'w');
        $contenu = json_encode($entity);
        fputs($entitycore, $contenu);

        fclose($entitycore);

        chdir('../');
    }

    private static function ressources($entity, \AdminTemplateGenerator $frontend, $views = false){

        if (!file_exists('Resource/views')) {
            mkdir('Resource/views/admin', 0777, true);
            mkdir('Resource/views/front', 0777, true);
            mkdir("Resource/js", 0777, true);
            mkdir("Resource/css", 0777, true);
        }
        /*if (!file_exists('Resource/views'))
            mkdir('Resource/views', 0777, true);

        if (!file_exists('Resource/views/' . strtolower($entity->name)))
            mkdir('Resource/views/' . strtolower($entity->name), 0777);

        if (!file_exists('Resource/js'))
            mkdir("Resource/js", 0777);*/

        $js = "Resource/js/" . strtolower($entity->name);
        if (!file_exists($js."Ctrl.js")) {

            $jsctrl = fopen($js . 'Ctrl.js', 'w');
            fputs($jsctrl, "/**
            * " . $entity->name . "Ctrl
            * Generated by devups
            * on ".date("Y/m/d")."
            */\n\n");
            fclose($jsctrl);
        }
        if (!file_exists($js."Form.js")) {
            $jsform = fopen($js . 'Form.js', 'w');
            fputs($jsform, "/**
            * " . $entity->name . "Form
            * Generated by devups
            * on ".date("Y/m/d")."
            */\n\n");
            fclose($jsform);
        }

        if($views){
            $vue = "Resource/views/admin/" . strtolower($entity->name);
            $frontend->viewsGenerator(__Generator::$projectcore->listmodule, $entity, $vue."/");
        }

    }

    /**
     * 
     * @param type $namespace
     */
    public static function __module($module, $setdependance = true) {

        $repertoire = ucfirst($module->name);
        if (!file_exists($repertoire)) {
            mkdir($repertoire, 0777);
        }
        chdir($repertoire);

        /* ENTITY */

        if (!file_exists("Entity")) {
            mkdir('Entity', 0777);
        }

        /* TABLE */

        if (!file_exists("Datatable")) {
            mkdir('Datatable', 0777);
        }

        /* ENTITYCORE */

        if (!file_exists("Core")) {
            mkdir('Core', 0777);
        }

        /* CONTROLLER */

        if (!file_exists("Controller")) {
            mkdir('Controller', 0777);
        }
        /* FORM */

        if (!file_exists("Form")) {
            mkdir('Form', 0777);
        }

        /* RESSOURCE (VIEW) */

        if (!file_exists("Resource")) {
            mkdir('Resource', 0777);
        }


        /* MODULE CORE */
        if (!file_exists(strtolower($module->name) . 'Core.json')) {

            $modulecore = fopen(strtolower($module->name) . 'Core.json', 'w');

            $contenu = json_encode($module);
            fputs($modulecore, $contenu);

            fclose($modulecore);

        }

        // on sort du module
        chdir('../');
    }

    private static function moduledependencies($project, $module, $modulelistentity){

        $repertoire = ucfirst($module->name);

        chdir($repertoire);

        $filename = strtolower($project->name) . "." . strtolower($module->name) . '.php';
        $package = "<?php ";

        foreach ($modulelistentity as $entity) {
            $name = ucfirst(strtolower($entity->name));
            $requiremanytomany = "";

            foreach ($entity->relation as $relation) {
                if ($relation->cardinality == 'manyToMany') {
                    $requiremanytomany .= "\nrequire 'Entity/" . $name."_".$relation->entity. ".php';";
                }
            }

            $package .= "
    require 'Entity/" . $name . ".php';$requiremanytomany
    require 'Form/" . $name . "Form.php';
    require 'Datatable/" . $name . "Table.php';
    require 'Controller/" . $name . "Controller.php';
    //require 'Controller/" . $name . "FrontController.php';\n";

        }

        $moddepend = fopen($filename, "w");
        fputs($moddepend, $package);
        fclose($moddepend);

        chdir("../");
    }

    private static function moduleendless($projet, $module, $modulelistentity, $rewrite = false)
    {

        $repertoire = ucfirst($module->name);
        if (!file_exists($repertoire)) {
            mkdir($repertoire, 0777);
        }

        self::moduledependencies($projet, $module, $modulelistentity);

        self::index($module, $modulelistentity);

        self::moduleressources($projet, $module, $modulelistentity, false);

        self::services($module, $modulelistentity);

    }

    private static function moduleressources($projet, $module, $modulelistentity, $withentityviews = true){
        $repertoire = ucfirst($module->name);
        chdir($repertoire);

        $frontend = new AdminTemplateGenerator();
        $frontend->layoutGenerator($module, "Resource/views/admin/");

        //if($withentityviews)
            foreach ($modulelistentity as $entity) {
                $entity->attribut = (array) $entity->attribut;
                self::ressources($entity, $frontend, $withentityviews);
            }

        // on sort du module
        chdir('../');
    }

    private static function index($module, $modulelistentity) {
        $repertoire = ucfirst($module->name);
        chdir($repertoire);

        $root = fopen('.htaccess', 'w');

        $htaccess = "\n
RewriteEngine On

RewriteRule    ^/?$    index.php    [NC,L]
#RewriteRule    ^([A-Za-z0-9-]+)/?$    index.php?path=$1    [NC,L]    # Process all products
RewriteRule    ^([A-Za-z0-9-]+)/?$    index.php?path=$1/index    [NC,L]    # Process all products
RewriteRule    ^([A-Za-z0-9-]+)/([A-Za-z0-9-]+)/?$    index.php?path=$1/$2   [NC,L]    # Process all products

<IfModule mod_headers.c>
    Header always set X-FRAME-OPTIONS \"DENY\"
</IfModule>
                \n";

        fputs($root, $htaccess);
        fclose($root);


        $root = fopen('index.php', 'w');

        $contenu = "<?php
            //" . $module->name . "
        
        require '../../../admin/header.php';
        
// move comment scope to enable authentication
if (!isset($" . "_SESSION[ADMIN]) and $"."_GET['path']"." != 'connexion') {
    header(\"location: \" . __env . 'admin/login.php');
}

global $" . "viewdir, $" . "moduledata;
$" . "viewdir[] = __DIR__ . '/Resource/views';

$" . "moduledata = Dvups_module::init('" . $module->name . "');
                \n\n";

        $contenu .= "";

        foreach ($modulelistentity as $entity) {
            $contenu .= "\t\t$" . strtolower($entity->name) . "Ctrl = new " . ucfirst($entity->name) . "Controller();\n";
        }

        $contenu .= "\t\t

(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView(\"admin.overview\");
        break;
        ";

        foreach ($modulelistentity as $entity) {
            $name = strtolower($entity->name);
            $contenu .= "
    case '" . str_replace("_", "-", $name) . "/index':
        $".$name."Ctrl->listView();
        break;\n";
        }

        $contenu .= "\n\t\t
    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
    ";

        fputs($root, $contenu);
        fclose($root);

        chdir('../');
    }

    private static function dependencies($project, $module, $entity, $rewrite = false) {

        $repertoire = ucfirst($module->name);

        chdir($repertoire);

        $filename = strtolower($project->name) . "." . strtolower($module->name) . '.php';
        $package = "\n";
        $mode = "a+";
        if(!file_exists($filename) || $rewrite){
            $package = "<?php ";
            $mode = "w";
        }

        //foreach ($modulelistentity as $entity) {
        $name = ucfirst(strtolower($entity->name));
        $requiremanytomany = "";
        if(isset($entity->lang))
            $requiremanytomany .= "\nrequire 'Entity/" . $name."_lang.php';";

        foreach ($entity->relation as $relation) {
            if ($relation->cardinality == 'manyToMany') {
                $requiremanytomany .= "\nrequire 'Entity/" . $name."_".$relation->entity. ".php';";
            }
        }

        $package .= "
    require 'Entity/" . $name . ".php';$requiremanytomany
    require 'Form/" . $name . "Form.php';
    require 'Datatable/" . $name . "Table.php';
    require 'Controller/" . $name . "Controller.php';\n";
        //}

        //$filename = strtolower(str_replace('/', '.', $module->name));
        $moddepend = fopen($filename, $mode);
        fputs($moddepend, $package);
        fclose($moddepend);

        chdir("../");

    }

    private static function services($module, $modulelistentity) {

        $repertoire = ucfirst($module->name);
        if (!file_exists($repertoire)) {
            mkdir($repertoire, 0777);
        }
        chdir($repertoire);

        $services = fopen('services.php', 'w');

        $contenu = "<?php
            //" . $module->name . "
		
        require '../../../admin/header.php';
        
// verification token
//

        use Genesis as g;
        use Request as R;
        
        header(\"Access-Control-Allow-Origin: *\");
                \n\n";

        foreach ($modulelistentity as $entity) {
            $contenu .= "\t\t$" . strtolower($entity->name) . "Ctrl = new " . ucfirst($entity->name) . "Controller();\n";
        }

        $contenu .= "\t\t
     (new Request('hello'));

     switch (R::get('path')) {
                ";

        foreach ($modulelistentity as $entity) {
            $name = strtolower($entity->name);
            $contenu .= "
        case '" . $name . "._new':
                g::json_encode($" . $name . "Ctrl->formView());
                break;
        case '" . $name . ".create':
                g::json_encode($" . $name . "Ctrl->createAction());
                break;
        case '" . $name . "._edit':
                g::json_encode($" . $name . "Ctrl->formView(R::get(\"id\")));
                break;
        case '" . $name . ".update':
                g::json_encode($" . $name . "Ctrl->updateAction(R::get(\"id\")));
                break;
        case '" . $name . "._show':
                $" . $name . "Ctrl->detailView(R::get(\"id\"));
                break;
        case '" . $name . "._delete':
                g::json_encode($" . $name . "Ctrl->deleteAction(R::get(\"id\")));
                break;
        case '" . $name . "._deletegroup':
                g::json_encode($" . $name . "Ctrl->deletegroupAction(R::get(\"ids\")));
                break;
        case '" . $name . ".datatable':
                g::json_encode($" . $name . "Ctrl->datatable(R::get('next'), R::get('per_page')));
                break;\n";
        }

        $contenu .= "\n\t
        default:
            g::json_encode(['success' => false, 'error' => ['message' => \"404 : action note found\", 'route' => R::get('path')]]);
            break;
     }

";

        fputs($services, $contenu);
        fclose($services);

        // on sort du module
        chdir('../');
    }

    public static function init() {

        chdir('config');

        $constantes = "
    <?php
    
        define('PROJECT_NAME', '" . $projet->name . "');
            
        define ('dbname', '" . $projet->name . "_bd');
        define ('dbuser', 'root');
        define ('dbpassword',  '');
        define ('dbhost',  'localhost');
        
	define ('RESSOURCE', __DIR__ . '/../admin/Resource/' );
	define ('RESSOURCE2', sanitize_src( '/../admin/Resource/') );
	define ('UPLOAD_DIR', __DIR__. '/../uploads/' );
        define('JS', sanitize_src( '/../admin/Resource/js/') );
        define('IMG', sanitize_src( '/../admin/Resource/img/') );
        define('CSS', sanitize_src( '/../admin/Resource/css/') );
        define('IHM', sanitize_src( '/../admin/Resource/ihm/') );
	
	define('ENTITY', 0);
	define('VIEW', 1);
	define('ADMIN', 'admin_devups');
	define('ENTERPRISE', 'entreprise_devups');";
        //$filename = strtolower(str_replace('/', '.', $module->name));
        $moddepend = fopen('constante.php', 'w+');
        fputs($moddepend, $constantes);
        fclose($moddepend);

        chdir('../');

        // creeation de projet json
        if (!file_exists($projet->name)) {
            mkdir($projet->name, 0777);
        }
        // on se met dans le repertoire du projet
        chdir($projet->name);


        chdir('../../');
    }

    public static function formGenerator($formbuild) {
        $htmlform = "";

        return $htmlform;
    }

}
