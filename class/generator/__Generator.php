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
        $commend[] = "core:g:module <component\module>                  // generate an entity crud from core eg: component\module\entity";
        $commend[] = "core:g:crud <component\module\entity>             // generate an entity crud from core";
        $commend[] = "core:g:entity <component\module\entity>           // generate an entity from core eg: component\module\entity";
        $commend[] = "core:g:controller <component\module\entity>       // generate a controller from core eg: component\module\entity";
        $commend[] = "core:g:form <component\module\entity>             // generate an entity from core eg: component\module\entity";
        $commend[] = "core:g:views <component\module\entity>            // generate an entity from core eg: component\module\entity";
        $commend[] = "core:g:genesis <component\module\entity>          // generate an entity from core eg: component\module\entity\n ";

        $commend[] = "install                 // create database, create database schema and create master admin ";
        $commend[] = "dvups_:update           // update right of master admin on new modules and entities ";

        echo implode("\n\t -> ", $commend);
        
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
            $modules[] = $module->name;
            if ($module->name == $search) {
                $modulecore = $module;
                break;
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
        $ns = str_replace("\\", "/", $namespace);
        $mn = explode("/", $ns);
        
        $module = json_decode(file_get_contents(__DIR__ . "/../../src/" . $ns . "/" . strtolower($mn[1]) . "Core.json"));
        
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

       $ns = str_replace("\\", "/", $namespace);
        $mn = explode("/", $ns);
        $module = __Generator::findmodule($project, $mn[1]);
//        die(var_dump($module));
//        $module = json_decode(file_get_contents(ROOT . "src/" . $ns . "/" . strtolower($mn[1]) . "Core.json"));
//        __Generator::$modulecore = $module;
        __Generator::$projectcore = $project;
        
        __Generator::moduleendless(__Generator::$projectcore, $module, $module->listentity);
        
    }

    /**
     * 
     * @param type $namespace
     */
    public static function views($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false, ['entity' => false, 'dao' => false, 'ctrl' => false, 'form' => false, 'genes' => false, 'views' => true]);
    }

    /**
     * 
     * @param type $namespace
     */
    public static function genesis($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false, ['entity' => false, 'dao' => false, 'ctrl' => false, 'form' => false, 'genes' => true, 'views' => false]);
    }

    /**
     * 
     * @param type $namespace
     */
    public static function controller($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false, ['entity' => false, 'dao' => false, 'ctrl' => true, 'form' => false, 'genes' => false, 'views' => false]);
    }

    /**
     * 
     * @param type $namespace
     */
    public static function form($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false, ['entity' => false, 'dao' => false, 'ctrl' => false, 'form' => true, 'genes' => false, 'views' => false]);
    }

    /**
     *
     * @param type $namespace
     */
    public static function formfield($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false, ['entity' => false, 'dao' => false, 'ctrl' => false, 'form' => false, 'formfield' => true, 'genes' => false, 'views' => false]);
    }

    /**
     * 
     * @param type $namespace
     */
    public static function entity($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project, false, ['entity' => true, 'dao' => false, 'ctrl' => false, 'form' => false, 'genes' => false, 'views' => false]);
    }

    /**
     * 
     * @param type $namespace
     */
    public static function crud($namespace, $project) {

        $ns = explode("\\", $namespace);
        $entity = __Generator::findentity($project, $ns[1], $ns[2]);
        __Generator::__entity($entity, $project);
    }

    /**
     * 
     * @param type $namespace
     */
    private static function __entity($entity, $project, $setdependance = false, $crud = ['entity' => true, 'dao' => true, 'ctrl' => true, 'form' => true, 'genes' => true, 'views' => true]) {

        $backend = new BackendGenerator();
        $frontend = new FrontendGenerator();
        $rootgenerate = new RootGenerator();

//        $entity = Core::findentitycore($ns[0].'/'.$ns[1].'/Core/'.$ns[0].'.json');

        $repertoire = ucfirst(__Generator::$modulecore->name);

//        if (!file_exists($repertoire)) {            
        __Generator::__module(__Generator::$modulecore, $setdependance);
//        }

        chdir($repertoire);

//        if(!$setdependance)
//            __Generator::moduleendless(__Generator::$projectcore, __Generator::$modulecore, [$entity]);

        $entity->attribut = (array) $entity->attribut;


        if ($crud['entity'])
            $backend->entityGenerator($entity);

        if ($crud['dao'])
            $backend->daoGenerator($entity);

        if ($crud['ctrl'])
            $backend->controllerGenerator($entity);

        if ($crud['form'])
            $backend->formGenerator($entity, $project->listmodule);

        if (isset($crud['formfield']) && $crud['formfield'])
            $backend->formFieldGenerator($entity, $project->listmodule);

        if ($crud['genes'])
            $rootgenerate->entityRooting($entity);

        if ($crud['views']) {
            if (!file_exists('Ressource'))
                mkdir('Ressource', 0777);

            if (!file_exists('Ressource/views'))
                mkdir('Ressource/views', 0777);

            if (!file_exists('Ressource/views/' . strtolower($entity->name)))
                mkdir('Ressource/views/' . strtolower($entity->name), 0777);

            if (!file_exists('Ressource/js'))
                mkdir("Ressource/js", 0777);

            $vue = "Ressource/views/" . strtolower($entity->name);
            $frontend->viewsGenerator(__Generator::$projectcore->listmodule, $entity, __Generator::$projectcore->template, $vue);
        }

        $name = strtolower($entity->name);

        $entitycore = fopen('Core/' . ucfirst($name) . 'Core.json', 'w');
        $contenu = json_encode($entity);
        fputs($entitycore, $contenu);

        fclose($entitycore);

        chdir('../');
    }

    /**
     * 
     * @param type $namespace
     */
    public static function __module($module, $setdependance = true) {

        //$repertoire = explode('/', $module->name);
        $retour = '';

        $repertoire = ucfirst($module->name);
        if (!file_exists($repertoire)) {
            mkdir($repertoire, 0777);
        }
        chdir($repertoire);

        /* ENTITY */

        if (!file_exists("Entity")) {
            mkdir('Entity', 0777);
        }

        /* ENTITYCORE */

        if (!file_exists("Core")) {
            mkdir('Core', 0777);
        }
        /* ENTITYDAO */

        if (!file_exists("Dao")) {
            mkdir('Dao', 0777);
        }
        /* ENTITYDAO */

        if (!file_exists("Genesis")) {
            mkdir('Genesis', 0777);
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

        if (!file_exists("Ressource")) {
            mkdir('Ressource', 0777);
        }


        /* MODULE CORE */
        if (!file_exists(strtolower($module->name) . 'Core.json')) {
            
            $modulecore = fopen(strtolower($module->name) . 'Core.json', 'w');
//            $module->listentity = [];
            $contenu = json_encode($module);
            fputs($modulecore, $contenu);

            fclose($modulecore);
//            $module->listentity = $module_entities;
        }

//        if (!file_exists('index.php') && $setdependance) {
//            __Generator::moduleendless(__Generator::$projectcore, $module, $module->listentity);
//        }

        // on sort du module
        chdir('../');
    }

    private static function moduleendless($projet, $module, $modulelistentity) {

        $repertoire = ucfirst($module->name);
        if (!file_exists($repertoire)) {
            mkdir($repertoire, 0777);
        }
        chdir($repertoire);

        $traitement = new Traitement();
        $root = fopen('index.php', 'w');

        $contenu = "<?php
            //" . $module->name . "
		
        require '../../../admin/header.php';
        
        global $" . "views;
        $" . "views = __DIR__ . '/Ressource/views';
                \n\n";

        $dependance = array();
        $requiremanytomany = [];
//        foreach ($module->listentity as $entity) {
//           $dependance[] = $module->name;
//        }
        $arraycontroller = array();
        foreach ($modulelistentity as $entity) {
            $dependance[] = $module->name;

//             if(!is_object($entity)){
//                 die(var_dump($entity));
//             }

            if (!empty($entity->relation)) {
                foreach ($entity->relation as $relation) {
//							if($relation->entity != 'admin'){
                    if ($relation->cardinality == 'manyToMany')
                        $requiremanytomany[] = "require 'Entity/" . ucfirst(strtolower($entity->name."_".$relation->entity)) . ".php';";
                    
                    $moduleentity = $traitement->dependancesinjection($projet->listmodule, strtolower($relation->entity));
                    if (!in_array($moduleentity->name, $dependance)) {
                        $modulearray = explode('/', $moduleentity->name);
//                        $contenu .= "\t\trequire '../" . ucfirst($moduleentity->name) . "/" . strtolower($projet->name) . "." . strtolower($moduleentity->name) . ".php';\n";
                        $dependance[] = $moduleentity->name;
                        foreach ($moduleentity->listentity as $entityrelation) {
                            //$name = ucfirst(strtolower($entityrelation->name));
                            //$arraycontroller[] = "\t\t$".strtolower($name)."Ctrl = new ".$name."Controller();\n";
                            $arraycontroller[] = "\t\t'" . strtolower($entityrelation->name) . "Ctrl' => new " . ucfirst(strtolower($entityrelation->name)) . "Controller(),\n";
                        }
                    }
                }
            }
        }

        $package = "<?php ";
        foreach ($modulelistentity as $entity) {
            $name = ucfirst(strtolower($entity->name));

            $package .= "
    require 'Entity/" . $name . ".php';
    require 'Dao/" . $name . "DAO.php';
    require 'Form/" . $name . "Form.php';
    require 'Controller/" . $name . "Controller.php';
    require 'Genesis/" . $name . "Genesis.php';\n";
        }
        
        if($requiremanytomany){
            $package .= "\n";
            $package .= implode("\n\t", $requiremanytomany);
        }

        //$filename = strtolower(str_replace('/', '.', $module->name));
        $moddepend = fopen(strtolower($projet->name) . "." . strtolower($module->name) . '.php', 'w');
        fputs($moddepend, $package);
        fclose($moddepend);

        $contenu .= "

    define('CHEMINMODULE', ' <a href=\"index.php\" target=\"_self\" class=\"titre_module\">Administration du system global</a> &gt; <a href=\"index.php?path=layout\" target=\"_self\" class=\"titre_module\">Module " . ucfirst($module->name) . "</a> ');\n


    $" . "controllers = [
	";
        foreach ($arraycontroller as $controller) {
            $contenu .= $controller;
        }
        foreach ($modulelistentity as $entity) {
            //$contenu .= "\t\t$".strtolower($entity->name)."Ctrl = new ".ucfirst($entity->name)."Controller();\n";
            $contenu .= "\t\t'" . strtolower($entity->name) . "Ctrl' => new " . ucfirst($entity->name) . "Controller(),\n";
        }

        $contenu .= "\t\t];

            if(isset($" . "_GET['path'])){

                    $" . "path = explode('/', $" . "_GET['path']);

                    switch ($" . "path[ENTITY]) {

                            case 'layout':
                                    Genesis::renderBladeView(\"layout\");
                                    break;
                                            ";

        foreach ($modulelistentity as $entity) {
            $name = strtolower($entity->name);
            $contenu .= "
                            case '" . $name . "':
                                    " . ucfirst($name) . "Genesis::genesis($" . "path[VIEW], $" . "controllers);
                                    break;\n
                            case '" . $name . ".rest':
                                    " . ucfirst($name) . "Genesis::restGenesis($" . "path[VIEW], $" . "controllers);
                                    break;\n";
        }

        $contenu .= "\n\t\t
                            default:
                                    echo 'la route n\'existe pas!';
                                    break;
                    }

            }else{
                    Genesis::renderBladeView(\"layout\");
            }		
        ";

        fputs($root, $contenu);
        fclose($root);

        $frontend = new FrontendGenerator();
        $frontend->layoutGenerator($module, $projet->template, "Ressource/views/");
        
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
        
	define ('RESSOURCE', __DIR__ . '/../admin/Ressource/' );
	define ('RESSOURCE2', sanitize_src( '/../admin/Ressource/') );
	define ('VENDOR', sanitize_src( '/../admin/vendor/') );
	define ('UPLOAD_DIR_SRC', sanitize_src( '/../admin/Ressource/js/') );
	define ('UPLOAD_DIR', __DIR__. '/../uploads/' );
        define('JS', sanitize_src( '/../admin/Ressource/js/') );
        define('IMG', sanitize_src( '/../admin/Ressource/img/') );
        define('CSS', sanitize_src( '/../admin/Ressource/css/') );
        define('IHM', sanitize_src( '/../admin/Ressource/ihm/') );
	
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
