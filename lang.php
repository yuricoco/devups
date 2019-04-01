<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 01/11/2018
 * Time: 12:47 PM
 */

global $lang;

function gettranslation($ref, $local = null, $default = "no translation found"){

    $lang = GeneralinfoController::getdata()["info"];

    if($local != "fr" && $local != "en")
        $local = local();

    if(!isset($lang[$ref]))
        return $ref;

    if(!isset($lang[$ref][$local]))
        return $default;

    return $lang[$ref][$local];

}


function translatecollection($local = null){

    $lang = GeneralinfoController::getdata()["info"];
    $contentcollection = [];

    if($local != "fr" && $local != "en")
        $local = local();

    foreach ($lang as $ref => $translate){
        $contentcollection[str_replace(".", "_", $ref)] = $translate[$local];
    }

    return $contentcollection;
}