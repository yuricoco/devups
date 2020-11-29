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

    case 'lazyloading':
        g::json_encode((new dclass\devups\Controller\Controller())->ll());
        break;

    case 'test.webservice': // test.webservice
        g::json_encode(Local_content::select()->__getAll(true, []));
        break;

    default :
        g::json_encode(["success" => false, "message" => "404 :".Request::get('path')." page note found"]);
        break;
}
