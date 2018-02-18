<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Request
 *
 * @author Aurelien Atemkeng
 */
class Request {
    
    private static  $uri_param = [];
    
    function __construct($default_path = 'hello') {
        
        Request::$uri_param["path"] = $default_path;
        
        $uri = explode('?', $_SERVER['REQUEST_URI']);
        
        if(isset($uri[1])){
            $param = explode('&', $uri[1]);
            foreach ($param as $el) {
                $kv = explode("=", $el);
                if(isset($kv[1])){
                    Request::$uri_param[$kv[0]] = $kv[1];
                }                
            }
        }
        
        if(isset($_GET)){
            foreach ($_GET as $key => $value) {
                    Request::$uri_param[$key] = $value;
            }
        }
        
        if(isset($_POST)){
            foreach ($_POST as $key => $value) {
                    Request::$uri_param[$key] = $value;
            }
        }

    }
    
    public static function get($key) {
        return Request::$uri_param[$key];
    }
    
}
