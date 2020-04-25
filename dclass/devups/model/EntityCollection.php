<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EntityCollection
 *
 * @author aurelien.ATEMKENG
 */
class EntityCollection{
    
        public static function entity_collection($classe_name, $entitycollection = true, $recursif = true) {
                /**
                 * on instantie la class $entityTable trop cool
                 */
            
                $reflection = new ReflectionClass(trim($classe_name)); 
//                $entitycore = $reflect->scan_entity_core();
                return [$reflection->newInstanceWithoutConstructor()];
                
        }
        
        public static function entity_reflection($classe_name, $recursive = true) {
                /**
                 * on instantie la class $entityTable trop cool
                 */
                $classe_name = ucfirst($classe_name);
                $reflect = new ReflectionClass($classe_name);
                    
                $entity = $reflect->newInstanceWithoutConstructor();
                
                return $entity;
        }
        
        /**
         * 
         * @param type $listentity
         * @param type $listentity2 the second list
         * @param type $cmp the attribut to compare ( id by default )
         * @return Array $intersection
         */
        public static function intersection($listentity, $listentity2, $cmp = "id"){
            $intersection = [];
            if(!empty($listentity) && !empty($listentity2)):
            foreach ($listentity as $key => $value){
                foreach ($listentity2 as $key2 => $value2){
                        if($value->getId() == $value2->getId()){
                            $intersection[] = $value;
                            unset ($listentity[$key]);
                            unset ($listentity2[$key2]);
                            break;
                        }
                }
            }
            endif;
            return $intersection;
	}
        
        /**
         * the function check the greates list then do the difference between it and the lower.
         * 
         * @param type $listentity
         * @param type $listentity2 the second list
         * @param type $cmp the attribut to compare ( id by default )
         * @return Array $diff
         */
        public static function diff($listentity, $listentity2, $cmp = "id"){
            $intersection = [];
            if(empty($listentity)):
                return $listentity2;
            elseif(empty($listentity2)):
                return $listentity;
            endif;
            
            if(count($intersection) >= count($intersection)){
                foreach ($listentity as $key => $value){
                    foreach ($listentity2 as $key2 => $value2){
                            if($value->getId() == $value2->getId()){
                                unset ($listentity[$key]);
                                unset ($listentity2[$key2]);
                                break;
                            }
                    }
                }
                
                return $listentity;
            }else{
                foreach ($listentity2 as $key2 => $value2){
                    foreach ($listentity as $key => $value){
                            if($value->getId() == $value2->getId()){
                                unset ($listentity[$key]);
                                unset ($listentity2[$key2]);
                                break;
                            }
                    }
                }
                
                return $listentity2;
            }
	}
        
}
