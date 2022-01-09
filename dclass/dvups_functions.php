<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $__lang;
if(!isset($_SESSION[LANG]))
    $_SESSION[LANG] = __lang;

//if(!isset($_SESSION[PREVIOUSPAGE]))
//    $_SESSION[PREVIOUSPAGE] = $_SERVER["url"];
//elseif ($_SESSION[PREVIOUSPAGE] != $_SERVER["url"])
//    $_SESSION[PREVIOUSPAGE] = $_SERVER["url"];

function local() {
    if (Request::get('lang')) {
        return Request::get('lang');
    }elseif (isset($_SESSION[LANG]))
        return $_SESSION[LANG];

    return __lang;
}

function setlang($lang) {
    $_SESSION[LANG] = $lang;
}

function redirect($url = "", $admin = false){
    header('location: '. $url );
    die;
}

if(!isset($_SESSION["__lang"] )){
    $_SESSION["__lang"] = "fr";
}


function d_assets($src){
    return __env .'web/assets/' . $src;
}

function path($src){
    return __env . $src;
}

function services($service){
    return __env ."admin/api/". $service;
}

function url_format($str, $charset='utf-8')
{
    $str = htmlentities($str, ENT_NOQUOTES, $charset);

    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
    $str = str_replace(' ', '-', $str); // supprime les autres caractères
    $str = str_replace('+', '', $str); // supprime les autres caractères

    return strtolower($str);
}

function remove_accents($str, $charset='utf-8')
{
    $str = htmlentities($str, ENT_NOQUOTES, $charset);

    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
//    $str = str_replace('\'', '.', $str); // supprime les autres caractères
//    $str = str_replace('"', '.', $str); // supprime les autres caractères

    return strtolower($str);
}

function clean($string) {
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
/**
 * @return \Dvups_admin Description
 */
function getadmin() {

    if(isset($_SESSION[ADMIN]))
        return unserialize($_SESSION[ADMIN]);

    return new Dvups_admin();
}

function setadmin($id) {

    $admin = Dvups_admin::find($id);
    $_SESSION[ADMIN] = serialize($admin);
    return $admin;

}

function d_url($path, $id = "", $title = "") {
    global $__lang;

    if(Request::$system != "admin") {
        $lang = local();
        $path = $lang . "/" . $path;
    }
    if ($id) {
        $path .= "/" . $id;
    }

    if ($title) {
        $path .= url_format($title);
    }

    $mode = "";
    if (Request::get('mode')) {
        $mode = "?mode=" . Request::get('mode');
    }

    return __env . $path . $mode;
}

function route($path, $id = "", $title = "") {
    return d_url($path, $id , $title);
}

function dv_dump(... $args){
    //echo json_encode($args);
    echo "<pre>";
    var_dump($args);
    die(1);
}

function randomtoken(){
    $randomtoken = base64_encode( openssl_random_pseudo_bytes(32));
}

function qb_sanitize($value){
    if(is_string($value))
        return "'$value'";

    return $value;
}
