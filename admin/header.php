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
require __DIR__.'/../config/dependanceInjection.php';
require __DIR__.'/../lang.php';
require __DIR__.'/../src/requires.php';

define('VENDOR', __env. 'admin/vendors/');
define('assets', __env. 'admin/assets/');

define('_cssversion', '1');
define('_jsversion', '1');

global $global_navigation, $viewdir;

$viewdir = [admin_dir . "views"];
$dvups_navigation = unserialize($_SESSION['navigation']);

//$global_navigation = Core::buildOriginCore();

