<?php

require 'header.php';

//instanciation des controllers
$adminCtrl = new Dvups_adminController();

switch (Request::get("path")) {
    case 'dashboard':
        Genesis::render("dashboard", AdminTemplateGenerator::dashboardView());
        break;

    case 'initlang':
        $dlangs = Dvups_lang::all();
        foreach ($dlangs as $dlang) {
            $countries = Country::all();
            foreach ($countries as $country) {
                DBAL::_createDbal("country_lang", [
                    "nicename" => $country->name,
                    "lang_id" => $dlang->id,
                    "country_id" => $country->id,
                ]);

            }
        }
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
                        
	