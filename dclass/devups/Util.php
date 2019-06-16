<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 20/04/2019
 * Time: 11:56 AM
 */
namespace DClass\devups;

class Util
{

    public static function nicecomponent(string $component) : string {
        return str_replace("-", "_", $component) ;
    }

    public static function initLocation($reload = false)
    {

        if(!isset($_SESSION[USERLOCATION]) || $reload){
            $location = ip_info("154.72.171.182");
            $_SESSION[USERLOCATION] = serialize($location);

            return;
        }

//        $location = self::getLocation();
//        if(!isset($location["city"]))
//            self::initLocation(true);

    }
    public static function getLocation()
    {
        return unserialize($_SESSION[USERLOCATION]);
    }

    public static function dateiso($creationdate)
    {
        return date("Y-m-d H:i:s", strtotime($creationdate));
    }

}
