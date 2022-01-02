<?php

require __DIR__ . '/header.php';

(new Request('dashboard'));

// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and Request::get('path') != 'connexion') {
    //$token = sha1(\DClass\lib\Util::randomcode());
    header("location: " . __env . 'admin/login.php');

}

//$path = explode("/", Request::get("path"));
if (Request::get("dcomp")) {
    //Request::$uri_get_param["path"] = $path[1];
    $entity = Dvups_entity::where("this.url", Request::get("dclass"))->firstOrNull();

    if ($entity) {
        \dclass\devups\Controller\Controller::views($entity);
        die();
    }
}

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
                        
	