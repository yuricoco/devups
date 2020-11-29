<?php

require 'header.php';

//instanciation des controllers
$adminCtrl = new Dvups_adminController();

switch (Request::get("path")) {
    case 'dashboard':
        Genesis::render("dashboard", AdminTemplateGenerator::dashboardView());
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
                        
	