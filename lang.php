<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 01/11/2018
 * Time: 12:47 PM
 */

global $lang;

function tt($ref, $default = "", $local = null){
    $content = t($ref, $default, $local);
    $ref = Local_content_key::key_sanitise($ref);

    if(isset($_SESSION['debuglang']) && $_SESSION['debuglang'])
        $content .= '<button title="'.$ref.'" style="background:#fff" type="button" data-toggle="modal" data-target="#dvContentModalCenter" onclick="model.editcontent(this, \''.$ref.'\')" class="btn btn-link" ><i class="fa fa-edit"></i></button>';

    return $content;
    // return editlang($translate, $ref);
}

function t($ref, $default = "", $local = null ){
    $params = [$ref,$default, $local];
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
        // t($params[0], $params[1], $params[2]);
        return $default;
    }

//    if(empty($matcher))
//        return editlang($lang[$ref], $ref);

    $translate = $lang[$ref];

    foreach ($matcher as $search => $value){
        $translate = str_replace(":".$search, $value, $translate);
    }

    return $translate;

}

function p($ref, $default = "no_image"){
    return "";
    return Dv_image::templatePosition($ref);

}
