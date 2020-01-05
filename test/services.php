<?php
//ModuleTest

require '../header.php';
//require "ControllerTest.php";

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");

$prodCtrl = new ProductController();

(new Request('hello'));

switch (R::get('path')) {

    case 'product.create':
        g::json_encode($prodCtrl->createJsonAction());
        break;

    default:
        echo json_encode(['error' => "404 : page note found", 'route' => R::get('path')]);
        break;
}

