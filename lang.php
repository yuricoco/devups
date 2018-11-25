<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 01/11/2018
 * Time: 12:47 PM
 */

global $lang;

$lang = [
    "datatable.add" => [
        "fr" => "Créer un nouveau contract",
        "en" => "Create a new Contract",
    ],
    "contract_list" => [
        "fr" => "Liste des Contracts",
        "en" => "Contract List",
    ],
    "morning" => [
        "fr" => "Bonjour",
        "en" => "Good morning",
    ],
    "dashboard" => [
        "fr" => "Tableau de bord",
        "en" => "Dashboard",
    ],
];

function gettranslation($ref, $local, $default = "no translation found"){
    global $lang;
    if(!isset($lang[$ref]))
        return "reference: <b>".$ref."</b> not found!";

    if(!isset($lang[$ref][$local]))
        return $default;

    return $lang[$ref][$local];

}