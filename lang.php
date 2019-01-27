<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 01/11/2018
 * Time: 12:47 PM
 */

global $lang;

$lang = [
    "datatable.btnlist" => [
        "en" => "List",
        "fr" => "Lister",
    ],
    "datatable.btnsearch" => [
        "en" => "Search",
        "fr" => "Rechercher",
    ],
    "datatable.btndelete" => [
        "en" => "Delete",
        "fr" => "Supprimer",
    ],
    "datatable.btnview" => [
        "en" => "View",
        "fr" => "Voir",
    ],
    "datatable.btnedit" => [
        "en" => "Edit",
        "fr" => "Editer",
    ],
    "datatable.btnadd" => [
        "fr" => "Ajouter",
        "en" => "Add",
    ],
    "datatable.nbligne" => [
        "fr" => "Nombre de ligne",
        "en" => "Number of line",
    ],
    "datatable.groupedaction" => [
        "fr" => "Action groupée",
        "en" => "Grouped action",
    ],
    "menu.morning" => [
        "fr" => "Bonjour",
        "en" => "Good morning",
    ],
    "dashboard" => [
        "fr" => "Tableau de bord",
        "en" => "Dashboard",
    ],
];

function gettranslation($ref, $local = null, $default = "no translation found"){
    global $lang;

    if($local != "fr" && $local != "en")
        $local = local();

    if(!isset($lang[$ref]))
        return $ref;

    if(!isset($lang[$ref][$local]))
        return $default;

    return $lang[$ref][$local];

}


function translatecollection($local = null){
    global $lang;
    $contentcollection = [];

    if($local != "fr" && $local != "en")
        $local = local();

    foreach ($lang as $ref => $translate){
        $contentcollection[str_replace(".", "_", $ref)] = $translate[$local];
    }

    return $contentcollection;
}