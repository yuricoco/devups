<?php

global $_start;
$_start = microtime(true);

require __DIR__ . '/header.php';

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");

$productCtrl = new ProductController();

(new Request('hello'));

switch (Request::get('path')) {

    case 'product.list':
        g::json_encode($productCtrl->listdata());
        break;

    default :
        g::json_encode(["success" => false, "message" => "404 :".Request::get('path')." page note found"]);
        break;
}
