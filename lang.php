<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 01/11/2018
 * Time: 12:47 PM
 */

global $lang;

function t($ref, $default = "", $local = null ){

    $lang = Local_contentController::getdata();
    $matcher = [];
    if(is_array($default)){
        $matcher = $default;
        $default = $ref;
    }else if(is_array($local)){
        $matcher = $local;
        // $default = $ref;
    }else if(!$default){
        $default = $ref;
    }

    $ref = Local_content_key::key_sanitise($ref);

    if(!isset($lang[$ref])){
        Local_contentController::newdatacollection($ref, $default);
        return $default;
    }

    if(empty($matcher))
        return $lang[$ref];

    $translate = $lang[$ref];

    foreach ($matcher as $search => $value){
        $translate = str_replace(":".$search, $value, $translate);

    }
    //dd($translate);
    return $translate;

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
