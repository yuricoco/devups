<?php

/* header 1.3
 *
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $_start;
$_start = microtime(true);

session_start();

//require __DIR__ . '/../config/constante.php';
require __DIR__ . '/../config/dependanceInjection.php';
require __DIR__ . '/../lang.php';
require __DIR__ . '/../src/requires.php';

Request::$system = "admin";

define('VENDOR', __env . 'admin/vendors/');
define('assets', __env . 'admin/assets/');

define('__cssversion', '1');
define('__jsversion', '1');

Dvups_adminController::restartsessionAction();

(new Request('dashboard'));
if ($path = Request::get("dvpath")) {

// move comment scope to enable authentication
    if (!isset($_SESSION[ADMIN])) {

        Genesis::json_encode(["success" => false, "message" => "admin session expired!!"]);

    }

    switch ($path) {

        case 'dvexport':
            $classname = ucfirst(Request::get("classname"));
            $entity = new $classname;
            $entity->exportCsv($classname); //,
            $message = $classname . ": CSV generated with success";
//            Genesis::json_encode([
//                "message"=>$message
//            ]);
            Genesis::json_encode(compact("message", "entity"));
            break;
        case 'dvimport':
            $classname = ucfirst(Request::get("classname"));
            $entity = new $classname;
            $response = $entity->importCsv($classname); //,
            $message = $classname . ": Core generated with success";
            Genesis::json_encode(compact("response", "message"));
            break;

        default:
            Genesis::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => $path]]);
            break;

    }
    die;
}


// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and Request::get('path') != 'connexion') {
    //$token = sha1(\DClass\lib\Util::randomcode());
    header("location: " . __env . 'admin/login.php');

}

global $global_navigation, $viewdir;

$viewdir = [admin_dir . "views"];
$dvups_navigation = [];
if (isset($_SESSION[__project_id . "_navigation"]))
    $dvups_navigation = unserialize($_SESSION[__project_id . "_navigation"]);

//$global_navigation = Core::buildOriginCore();

