<?php

require 'header.php';

//instanciation des controllers
$adminCtrl = new Dvups_adminController();


if (isset($_GET['path'])) {
    $path = explode('/', $_GET['path']);
} else
    $path = ['dashboard']; // Default entry


switch ($path[ENTITY]) {
    case 'dashboard':
        Genesis::render("dashboard");
        break;

    case 'connexion':
        $adminCtrl->connexionAction();
        break;
    case 'deconnexion':
        $adminCtrl->deconnexionAction();
        break;

    default :
        // inclusion du layout du site
        Genesis::render("404");
        break;
}
                        
	