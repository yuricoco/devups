<?php


class Response
{
    static  function varName( $v ) {
        $trace = debug_backtrace();
        $vLine = file( __FILE__ );
        $fLine = $vLine[ $trace[0]['line'] - 1 ];
        preg_match( "#\\$(\w+)#", $fLine, $match );
        return $match [1];
    }
    public static $data = ["success" => true];
    public static function set($key, $value = ""){
        if(!$value){
            $value = $key;
            $key = self::varName($key);
        }
        self::$data[$key] = $value;
    }
    public static function fail($key = "", $value = ""){
        self::$data["success"] = false;
        if($key && $value){
            self::$data[$key] = $value;
        }
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

    /**
     * @return Response
     */
    public static function success()
    {
        $response = new Response();
        $response->success = true;
        return $response;
    }
    public function message($content){
        $this->message = $content;
        return $this;
    }
    public function json(){
        $data = (Array) $this;
        self::$data += $data;
        self::json_response();
    }

}