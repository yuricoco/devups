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
    
    function curl ($url, $order, $orderdetail) {

        $options = array(
            CURLOPT_RETURNTRANSFER => true, // return web page
            CURLOPT_HEADER => false, // don't return headers
            CURLOPT_FOLLOWLOCATION => true, // follow redirects
            CURLOPT_ENCODING => "", // handle all encodings
            CURLOPT_USERAGENT => "spider", // who am i
            CURLOPT_POST => 1, // who am i
            CURLOPT_POSTFIELDS => http_build_query(array(
                'orderjson' => $order,
                'orderdetailjson' => json_encode($orderdetail),
                'mappoint_id' => 122//$cart->id_marker,
            )), // who am i
            CURLOPT_AUTOREFERER => true, // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
            CURLOPT_TIMEOUT => 120, // timeout on response
            CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);

        $header['errno'] = $err;
        $header['errmsg'] = $errmsg;
        $header['content'] = $content;
        return $header;
        
    }
    
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
