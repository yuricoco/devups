<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 6/14/2018
 * Time: 7:39 AM
 */
require '../header.php';

$acte = "";
$nbcaract = 6;
$emptycarat = "0";
$value = 2;

$remaincarat = $nbcaract - strlen($value);
for($i = 0; $i < $remaincarat; $i++)
    $acte .= $emptycarat;

var_dump($acte.$value);