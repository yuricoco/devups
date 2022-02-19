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

define('__debug', false);

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

global $global_navigation, $viewdir;

$viewdir = [admin_dir . "views"];
$dvups_navigation = [];
if (isset($_SESSION[__project_id . "_navigation"])) {
    $dvups_navigation = unserialize($_SESSION[__project_id . "_navigation"]);

    if (isset($_GET["notified"]) && $idnb = $_GET["notified"]) {
        Notificationbroadcasted::readed($idnb);
    }
}
//$global_navigation = Core::buildOriginCore();

