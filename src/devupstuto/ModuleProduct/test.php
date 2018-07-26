<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 7/18/2018
 * Time: 12:06 AM
 */require '../../../admin/header.php';

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");

$productCtrl = new ProductController();
//die(var_dump($_SESSION["dv_datatable"]));
g::json_encode($productCtrl->datatable(R::get('next'), R::get('per_page')));