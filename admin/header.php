<?php

/* header 1.3
 *
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require __DIR__ . '/../header.php';

require __DIR__ . '/../src/devups/ModuleAdmin/devups.moduleadmin.php';

// move comment scope to enable authentication 
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {

    header("location: " . __env . 'admin/login.php');
    
} 


global $global_navigation;
$dvups_navigation = unserialize($_SESSION['navigation']);

//$global_navigation = Core::buildOriginCore();

