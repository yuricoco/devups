<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Core
 *
 * @author azankang
 */
class Core extends stdClass
{

    public function __construct($entity)
    {
        $this->entity = $entity;
        $this->classname = get_class($entity);
        $this->name = strtolower(get_class($entity));
        $this->addjs = [];
        return $this;
    }

    public function addDformjs($action = true)
    {
        if ($action) $this->addjs[] = CLASSJS . "dform";
    }

    public function addjs($js, $path = "")
    {
        $this->addjs[] = $path . $js;//.".js";
    }

    public function addcss($css, $path = "")
    {
        $this->addcss[] = $path . $css;//.".css";
    }

    public static function __extract($entity, $asarray = false)
    {

        global $enittycollection;

        $entityname = strtolower(get_class($entity));
        $path = $enittycollection[$entityname] . '/Core/' . $entityname . 'Core.json';
//        $path = $__DIR__ . '/../Core/' . ucfirst(get_class($entity)) . 'Core.json';

        $json_file_content = file_get_contents($path);

        if ($asarray)
            $entitycore = json_decode($json_file_content, true);
        else
            $entitycore = json_decode($json_file_content);

        $entitycore->instance = $entity;
        $entitycore->name = strtolower($entitycore->name);

        return $entitycore;
    }

    public static function findprojectcore($dir, $file)
    {
//            var_dump($dir."/".strtolower($file) . ".json");
        if (!file_exists($dir . "/" . strtolower($file) . "Core.json"))
            return [];

        $files = array_diff(scandir($dir), array('.', '..'));
        $modulecores = [];

        $projectcore = json_decode(file_get_contents($dir . "/" . strtolower($file) . "Core.json"));

        foreach ($files as $file) {

            if (is_dir($dir . "/" . $file)) {

//                if (!file_exists($dir . "/" . strtolower($file) . "Core.json")){
                $modulecores[] = Core::findmodulecore($dir . "/" . $file, $file);
//                }

            }
        }
        $projectcore->listmodule = $modulecores;

        return $projectcore;
    }

    public static function findmodulecore($dir, $file)
    {
        if (!file_exists($dir . "/" . strtolower($file) . "Core.json"))
            return [];

        $modulecore = json_decode(file_get_contents($dir . "/" . strtolower($file) . "Core.json"));

        $entitycores = Core::findentitycore($dir . "/Core");

        $modulecore->listentity = $entitycores;

        return $modulecore;
    }

    public static function findentitycore($dir)
    {
        if (!file_exists($dir))
            return [];

        $entitycores = [];
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {

            if (!is_dir($dir . "/" . $file)) {

                $entitycores[] = json_decode(file_get_contents($dir . "/" . $file));
            }
        }
        return $entitycores;

    }

    public static function buildOriginCore()
    {

        $dir = __DIR__ . '/../../src';
        $navigation = [];
        if (file_exists($dir)) {
            $files = array_diff(scandir($dir), array('.', '..'));

            foreach ($files as $file) {
                if ($file != "requires.php")
                    $navigation[] = Core::findprojectcore($dir . "/" . $file, $file);
            }

            return $navigation;
        } else {
            return [];
        }
    }

    public static function getComponentCore($component)
    {

        $dir = __DIR__ . '/../../src';

        if (file_exists($dir . "/" . $component)) {
            if (file_exists($dir))
                return json_decode(file_get_contents($dir . "/" . $component . "/" . $component . "Core.json"));
            else
                return null;

        } else {
            return null;
        }
    }

    public static function updateDvupsTable()
    {
        $updated = false;
        $global_navigation = Core::buildOriginCore();

        foreach ($global_navigation as $key => $project) {
            if (is_object($project)) {

                $projectname = ($project->name);

                $qb = new QueryBuilder(new Dvups_component());
                $dvcomponent = $qb->select()->where("name", '=', $projectname)
                    ->firstOrNull();
                /*(function () use ($projectname, &$updated){


                    var_dump($projectname);
                    $updated = true;

                    return $rolecomponent;

                });*/

                if (is_null($dvcomponent)) {
                    $dvcomponent = new Dvups_component();
                    $dvcomponent->setName($projectname);
                    $dvcomponent->setLabel($projectname);
                    $dvcomponent->__insert();

                    $rolecomponent = new Dvups_role_dvups_component();
                    $rolecomponent->setDvups_component($dvcomponent);
                    $rolecomponent->setDvups_role(new Dvups_role(1));
                    $rolecomponent->__insert();
                }


                foreach ($project->listmodule as $key => $module) {

                    if (!is_object($module)) {
                        continue;
                    }
                    $modulename = ucfirst($module->name);
                    $qb = new QueryBuilder(new Dvups_module());
                    $dvmodule = $qb->select()->where("this.name", '=', $modulename)->first();

                    $dvmodule->setProject($project->name);
                    $dvmodule->dvups_component = $dvcomponent;
                    if (!$dvmodule->getId()) {
                        //var_dump("component_id name", $dvcomponent->id);
                        $dvmodule->setName($modulename);
                        $dvmodule->setLabel($modulename);
                        $dvmodule->__insert();

                        $rolemodule = new Dvups_role_dvups_module();
                        $rolemodule->setDvups_module($dvmodule);
                        $rolemodule->setDvups_role(new Dvups_role(1));
                        $rolemodule->__insert();

                        $updated = true;

                    } else {
                        $dvmodule->__update();
                    }

                    foreach ($module->listentity as $key => $entity) {

                        $entityname = strtolower($entity->name);
                        $qb = new QueryBuilder(new Dvups_entity());
                        $dventity = $qb->select()->where("dvups_entity.name", '=', $entityname)->first();

                        $dventity->setDvups_module($dvmodule);
                        if (!$dventity->getId()) {
                            $dventity = new Dvups_entity();
                            $dventity->setName($entityname);
                            $dventity->setLabel($entityname);
                            $dventity->setUrl($entityname);
                            $dventity->dvups_module = $dvmodule;
                            $dventity->__insert();

                            $roleentity = new Dvups_role_dvups_entity();
                            $roleentity->setDvups_entity($dventity);
                            $roleentity->setDvups_role(new Dvups_role(1));
                            $roleentity->__insert();

                            $updated = true;

                        } else {
                            $dventity->dvups_module = $dvmodule;
                            $dventity->__update();
                        }
                    }
                }
            }
        }

        return $updated;

    }

}
