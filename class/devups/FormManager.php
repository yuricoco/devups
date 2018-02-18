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
define('FORMTYPE_CHECKBOX', 'checkbox');
define('FORMTYPE_RADIO', 'radio');
define('FORMTYPE_FILE', 'file');
define('FILETYPE_IMAGE', 'image');
define('FILETYPE_DOCUMENT', 'document');
define('FILETYPE_VIDEO', 'video');
define('FILETYPE_AUDIO', 'audio');
define('FORMTYPE_EMAIL', 'email');
define('FORMTYPE_NUMBER', 'number');
define('FORMTYPE_PASSWORD', 'password');
define('FORMTYPE_INJECTION', 'injection');

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
    
    static function Options_ToCollect_Helper($value, $entity, $currentcollection, $manageentity = false) {
        
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
        
        if($manageentity)
            return $entitylist;

        return FormManager::Options_Helper($value, $entitylist);
            
    }
    
    static function Options_Helper($value, $entitylist = [], $key = "id", $enablecollectionforminjection = false) {
        
        global $__controller_traitment;
        
        $key_value = [];
        
        if(isset($entitylist[0]) && is_object($entitylist[0]) && !$entitylist[0]->getId()) return [];
//        if($__controller_traitment) return EntityCollection::entity_collection($value);
        
        foreach ($entitylist as $entity) {
            $key_value[call_user_func(array( $entity, 'get' . ucfirst($key) ) )] = call_user_func(array( $entity, 'get' . ucfirst($value) ) ); 
            $entitylist2[call_user_func(array( $entity, 'getId' ) )] = $entity; 
        }
        
        if($enablecollectionforminjection)
            return ["list" => $key_value, "forcollectionform" => $entitylist2];
        else
            return $key_value;
        
    }
    
    
}
