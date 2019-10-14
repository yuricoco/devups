<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 20/04/2019
 * Time: 11:56 AM
 */

namespace DClass\lib;

class Util
{

    public static function handleSessionLost($redirect = "admin/"){

        if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {
            header("location: " . __env . $redirect);
        }
    }

    public static function nicecomponent($component)
    {
        return str_replace("-", "_", $component);
    }

    public static function initLocation($reload = false)
    {

        if (!isset($_SESSION[USERLOCATION]) || $reload) {
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

    public static function money($amount)
    {
        return number_format($amount, 0, '', ' ');
    }

    public static function quantity($quantity)
    {
        return number_format($quantity, 2, ',', ' ');
    }

}
