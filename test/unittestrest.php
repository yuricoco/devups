<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 9/6/2018
 * Time: 1:52 PM
 */

require '../header.php';

header("Access-Control-Allow-Origin: *");


$result = Dfile::init("file")->moveto("/");

echo json_encode($result);
