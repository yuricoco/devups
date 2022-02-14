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

    /**
     * this method write file with path setted on ROOT folder of the project by default
     * @param $content
     * @param string $file
     * @param string $root
     */
    static function writein($content, $file = "log", $root = ""){

        if (!file_exists(ROOT . $root))
            mkdir(ROOT . $root, 0777, true);

        $moddepend = fopen(ROOT .$root.'/'.$file, "a+");
        fputs($moddepend, $content."\n");
        fclose($moddepend);
    }

    public static function log($content, $file = "log", $root = ROOT, $mode = "a+") {

        if (!$content)
            return;

        $moddepend = fopen($root.'/'.$file, $mode);
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
    public static function randomcode($length = 8)
    {
        $list = "0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTVWXYZ+-@%*$";
        mt_srand((double)microtime() * 1000000);
        $password = "";
        while (strlen($password) < $length) {
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

    public static function urlsanitize($str, $charset = 'utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
        $str = str_replace(' ', '-', $str); // supprime les autres caractères
        $str = str_replace(',', '', $str); // supprime les autres caractères
        $str = str_replace('\'', '', $str); // supprime les autres caractères

        return strtolower($str);
    }

    public static function setcookie($key, $value)
    {
        setcookie($key, $value, time() + 365 * 24 * 3600, null, null, false, true); // On écrit un cookie
    }
    public static function clearcookie($key)
    {
        setcookie($key, null, -1, null, null, false, true);
    }

    public static function dateadd($duration, $period, $from)
    {
        return date("Y-m-d H:i:s", strtotime($duration . " $period", strtotime($from)));
    }

    public static function sanitizePhonenumber($phonenumber, $phone_code){
        $telephone = str_replace(" ","", $phonenumber);
        $telephone = str_replace("(","", $telephone);
        $telephone = str_replace(")","", $telephone);
        $telephone = str_replace("+".$phone_code,"", "+".$telephone);
        return str_replace("+","", $telephone);
    }

}
