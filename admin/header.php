<?php

/* header 1.3
 *
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require __DIR__ . '/../header.php';
define('VENDOR', __env. 'admin/vendor/');
define('assets', __env. 'admin/assets/');

// move comment scope to enable authentication 
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {

    header("location: " . __env . 'admin/login.php');
    
} 


global $global_navigation, $viewdir;

$viewdir = [admin_dir . "views"];
$dvups_navigation = unserialize($_SESSION['navigation']);

//$global_navigation = Core::buildOriginCore();

