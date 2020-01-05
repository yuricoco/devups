<?php

global $_start;
$_start = microtime(true);

require __DIR__ . '/header.php';

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");

$storageCtrl = new StorageFrontController();

(new Request('hello'));

switch (Request::get('path')) {

    case 'test.webservice': // test.webservice
        g::json_encode($storageCtrl->testwebservice());
        break;

    default :
        g::json_encode(["success" => false, "message" => "404 :".Request::get('path')." page note found"]);
        break;
}
