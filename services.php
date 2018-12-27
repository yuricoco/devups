<?php

require __DIR__ . '/header.php';

use Genesis as g;

header("Access-Control-Allow-Origin: *");

(new Request('hello'));

switch (Request::get('path')) {

    case 'hello':
        g::json_encode(["success" => true, "message" => "Hello Devups. Services are available :)"]);
        break;

//    case 'service':
//        g::json_encode([]);
//        break;

    default :
        echo json_encode("404 :".Request::get('path')." page note found");
        break;
}