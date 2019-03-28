<?php

require 'header.php';

//instanciation des controllers


if (isset($_GET['path'])) {
    $path = explode('/', $_GET['path']);
} else
    $path = ['dashboard']; // Default entry


switch ($path[ENTITY]) {
    case 'dashboard':
        Genesis::render("dashboard");
        break;

    default :
        // inclusion du layout du site 
        include 'web/404.html';
        break;
}
                        
	