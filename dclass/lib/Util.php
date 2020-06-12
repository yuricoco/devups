<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 20/04/2019
 * Time: 11:56 AM
 */

namespace DClass\lib;

use Request;

class Util
{

    const dateformat = 'Y-m-d H:i:s';

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

    public static function local() {
        if (Request::get('lang')) {
            return Request::get('lang');
        }elseif (isset($_SESSION[LANG]))
            return $_SESSION[LANG];

        return __lang;
    }

    public static function log($root, $file, $content) {
        $moddepend = fopen($root.'/'.$file, "a+");
        fputs($moddepend, "  ". $content."\n");
        fclose($moddepend);
    }

    public static function nfacture($nbcaract, $emptycarat, $value)
    {
        $acte = "";
        $remaincarat = $nbcaract - strlen($value);
        for ($i = 0; $i < $remaincarat; $i++)
            $acte .= $emptycarat;
        //$acte = "0000";
        return $acte . $value;
    }

    /**
     * @param mixed
     */
    public static function randomcode()
    {
        $list = "0123456789abcdefghijklmnopqrstvwxyz+-@%";
        mt_srand((double)microtime() * 1000000);
        $password = "";
        while (strlen($password) < 8) {
            $password .= $list[mt_rand(0, strlen($list) - 1)];
        }
        return $password;

    }

    public static function validation($value, $type = "telephone")
    {
        if($type == "telephone"){
            if(!is_numeric($value))
                return t("Entrer une valeur numérique");
            if (strlen($value."") != 9)
                return t("le numéro doit etre constitué de 9 caractères");
        }
        return null;
    }

}
