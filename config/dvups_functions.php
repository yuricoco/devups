<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function url_format($str, $charset='utf-8')
{
    $str = htmlentities($str, ENT_NOQUOTES, $charset);

    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
    $str = str_replace(' ', '-', $str); // supprime les autres caractères

    return '/' .strtolower($str);
}


global $__lang;
if(!isset($_SESSION["__lang"] )){
    $_SESSION["__lang"] = "fr";
}

/**
 * @return \Dvups_admin Description
 */
function getadmin() {
    return unserialize($_SESSION[ADMIN]);
}

function local() {
    return $_SESSION["__lang"];
}

function setlang() {
    if (Request::get('lang')) {
        if (in_array(Request::get('lang'), ["en", "fr"]) && $_SESSION["__lang"] != Request::get('lang')) {
            $_SESSION["__lang"] = Request::get('lang');
        }
    }
}

function url($path, $id = "", $title = "") {
    global $__lang;

    $path = $__lang . $path;
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