<?php


class Response
{
    public static $data = ["success" => true];
    public static function set($key, $value){
        self::$data[$key] = $value;
    }
    public static function json_response($options = 0, $depth = 512){
        global $_start;
        $value = self::$data;

        if(is_array($value)){
            $_end = microtime(true);
            $value["exectime"] = $_end - $_start;
        }
        echo json_encode($value, $options, $depth);
        die;
    }
}