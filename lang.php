<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 01/11/2018
 * Time: 12:47 PM
 */

global $lang;

function t($ref, $default = "", $local = null ){

    $lang = GeneralinfoController::getdata()["info"];

    if($local != "fr" && $local != "en"){
        $local = DClass\lib\Util::local();
    }

    if(!$default)
        $default = $ref;

    $ref = strtolower($ref);

    if(!isset($lang[$ref])){
        if(!isset($_SESSION[LANG."_collection"]))
            $_SESSION[LANG."_collection"] = [];

        $_SESSION[LANG."_collection"][$ref] = $default;
        return $default;
    }

    if(!isset($lang[$ref][$local]))
        return $default;

    return $lang[$ref][$local];

}

function gettranslation($ref, $local = null, $default = "no translation found"){
    global $lang;

    if($local != "fr" && $local != "en")
        $local = \DClass\lib\Util::local();

    if(!isset($lang[$ref]))
        return "reference: <b>".$ref."</b> not found!";

    if(!isset($lang[$ref][$local]))
        return $default;

    return $lang[$ref][$local];

}