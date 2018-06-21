<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EntityCore
 *
 * @author azankang
 */
class EntityCore {
    //put your code here
    public function __construct($entity)
    {
        return get_class($entity);
    }

    public static function __extract($__DIR__, $entity, $asarray = false){
        
        $path = $__DIR__ . '../Core/' . strtolower(get_class($entity)) . '.json';
        
        $json_file_content = fopen(__DIR__.$path, 'r+');
        if($asarray)
            $entitycore = json_decode(fgets($json_file_content), true);
        else
            $entitycore = json_decode(fgets($json_file_content));
        fclose($json_file_content);
        
        return $entitycore;
        
    }
}
