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

    public static $uri_get_param = [];
    public static $uri_post_param = [];

    function __construct($default_path = 'hello') {

        Request::$uri_get_param["path"] = $default_path;

        $uri = explode('?', $_SERVER['REQUEST_URI']);

        if (isset($uri[1])) {
            $param = explode('&', $uri[1]);
            foreach ($param as $el) {
                $kv = explode("=", $el);
                if (isset($kv[1])) {
                    Request::$uri_get_param[$kv[0]] = $kv[1];
                }
            }
        }

        if (isset($_GET)) {
            foreach ($_GET as $key => $value) {
                Request::$uri_get_param[$key] = $value;
            }
        }

        if (isset($_POST)) {
            foreach ($_POST as $key => $value) {
                Request::$uri_post_param[$key] = $value;
            }
        }
    }

    public static function classroot($key) {
        if (isset(Request::$uri_get_param[$key]))
            return explode("/", Request::$uri_get_param[$key])[ENTITY];
        else
            return false;
    }

    public static function get($key, $default = false) {
        if (isset(Request::$uri_get_param[$key]))
            return Request::$uri_get_param[$key];
        else
            return $default;
    }

    public static function post($key) {
        if (isset(Request::$uri_post_param[$key]))
            return Request::$uri_post_param[$key];
        else
            return false;
    }

    public static function raw($format = "json") {
        $rawdata = file_get_contents("php://input");
        //die($rawdata);
        if ($format == "json")
            return json_decode($rawdata, true);
        else
            return $rawdata;
    }

    public static function set($key, $value)
    {
        Request::$uri_get_param[$key] = $value;
    }

    public static function geturi()
    {
        $uri = $_SERVER["REQUEST_URI"];
        if(__prod)
            return substr($uri, -strlen($uri)+1);

        return str_replace(__base_dir, "", $uri);
    }

}
