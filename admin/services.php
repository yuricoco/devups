<?php

global $_start;
$_start = microtime(true);

require __DIR__ . '/header.php';

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if (!isset($_SESSION[ADMIN])) {

    Genesis::json_encode(["success" => false, "message" => "admin session expired!!"]);

}

(new Request('hello'));

$path = explode(".",Request::get("path"));
if (count($path) > 1) {
//if ($dclass = Request::get("dclass")) {
    Request::$uri_get_param["path"] = $path[1];
    Request::$uri_get_param["dclass"] = $path[0];
    $entity = Dvups_entity::where("this.url", $path[0])
        ->orwhere("this.name", $path[0])->firstOrNull();

    if ($entity)
        g::json_encode(\dclass\devups\Controller\Controller::serve($entity));
}

switch (Request::get('path')) {

    case 'hello':
        g::json_encode(["success" => true, "message" => "hello devups you made your first apicall"]);
        break;

    case 'export':
        $classname = ucfirst(Request::get("classname"));
        $entity = new $classname;
        $result = $entity->exportCsv($classname); //,
        $message = $classname . ": CSV generated with success";
//            Genesis::json_encode([
//                "message"=>$message
//            ]);
        Genesis::json_encode(compact("message", "entity", "result"));
        break;
    case 'import':
        $classname = ucfirst(Request::get("classname"));
        $entity = new $classname;
        $response = $entity->importCsv($classname); //,
        $message = $classname . ": Core generated with success";
        Genesis::json_encode(compact("response", "message"));
        break;

    default :
        g::json_encode(["success" => false, "message" => "404 :" . Request::get('path') . " page note found"]);
        break;
}
