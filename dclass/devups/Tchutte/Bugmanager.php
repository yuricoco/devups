<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bugmanager
 *
 * @author aurelien.ATEMKENG
 */
class Bugmanager {
    
    static function getError($class, $methode, $line, $error = null, $sql = null, $values = [],$entity = null) {
        $debug = [
            "success"=> false,
            'class' => $class,
            'methode' => $methode,
            'at line' => $line,
            'entity' => $entity,
            'error' => $error,
            'request' => $sql,
            'values' => $values ,
        ];
        
//        if(__prod){
//            header("location: /");
//            die;
//        }
        //return $debug;
//        if(SYSTEM_DEBUG){
//        Genesis::json_encode($debug);
//        die;
        echo "<pre>";
        $calledfrom = debug_backtrace();
        print_r($debug);
        print_r($calledfrom);
        die;
//        }
//        else{
//            return json_encode($debug);
//        }
        
    }
    
        
        /**
        * Cast an object into a different class.
        *
        * Currently this only supports casting DOWN the inheritance chain,
        * that is, an object may only be cast into a class if that class 
        * is a descendant of the object's current class.
        *
        * This is mostly to avoid potentially losing data by casting across
        * incompatable classes.
        *
        * @param object $object The object to cast.
        * @param string $class The class to cast the object into.
        * @return object
        */
        public static function cast($object, $class) {
                if( !is_object($object) ) 
                        throw new InvalidArgumentException('$object must be an object.');
                if( !is_string($class) )
                        throw new InvalidArgumentException('$class must be a string.');
                if( !class_exists($class) )
                        throw new InvalidArgumentException(sprintf('Unknown class: %s.', $class));
                if( !is_subclass_of($class, get_class($object)) ) 
                        throw new InvalidArgumentException(sprintf(
                                '%s is not a descendant of $object class: %s.',
                                $class, get_class($object)
                        ));
                /**
                 * This is a beautifully ugly hack.
                 *
                 * First, we serialize our object, which turns it into a string, allowing
                 * us to muck about with it using standard string manipulation methods.
                 *
                 * Then, we use preg_replace to change it's defined type to the class
                 * we're casting it to, and then serialize the string back into an
                 * object.
                 */
                return unserialize(
                        preg_replace(
                                '/^O:\d+:"[^"]++"/', 
                                'O:'.strlen($class).':"'.$class.'"',
                                serialize($object)
                        )
                );
        }
}
