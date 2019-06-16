<?php

class Traitement {

    function relation($listemodule, $entityname) {

        $relation = [];
        foreach ($listemodule as $module) {
            if ($module) {
                foreach ($module->listentity as $entity) {
                    //var_dump($entity->name, $entityname);
                    if (strtolower($entityname) == strtolower($entity->name)) {
                        return $entity;
                        break;
                    }
                }
            }
        }
        return null;
    }

    function dependancesinjection($listemodule, $entityname) {
        $moduleentity = [];
        foreach ($listemodule as $module) {
            
            if ($module) {
                foreach ($module->listentity as $entity) {
                    if (strtolower($entityname) == strtolower($entity->name)) {
                        $moduleentity = $module;
                    }
                }
            }
        }
        return $moduleentity;
    }

    public function deleteDir($dir) {
        if (file_exists($dir)) {
            $files = array_diff(scandir($dir), array('.', '..'));
            foreach ($files as $file) {
                (is_dir("$dir/$file") && !is_link($dir)) ? $this->deleteDir("$dir/$file") : unlink("$dir/$file");
            }
            return rmdir($dir);
        } else {
            return true;
        }
    }

}
