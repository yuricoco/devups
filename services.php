<?php

require __DIR__ . '/header.php';

use Genesis as g;

header("Access-Control-Allow-Origin: *");

(new Request('hello'));

$storageCtrl = new StorageController();

switch (Request::get('path')) {

    case 'hello':
        g::json_encode(["success" => true, "message" => "Hello Devups. Services are available :)"]);
        break;

    case 'storage.get':
        g::json_encode($storageCtrl->getStorage());
        break;

    default :
        echo json_encode(["success" => false, "message" => "404 :".Request::get('path')." page note found"]);
        break;
}
