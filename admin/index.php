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
        echo "<pre>";
        $dlangs = Dvups_lang::all();
        foreach ($dlangs as $dlang) {
            $items = Tree_item::all();
            foreach ($items as $item) {
                DBAL::_createDbal("tree_item_lang", [
                    "name" => $item->getName(),
                    "lang_id" => $dlang->getId(),
                    "tree_item_id" => $item->getId(),
                ]);

            }
            $items = Product::all();
            foreach ($items as $item) {
                DBAL::_createDbal("product_lang", [
                    "name" => $item->getName(),
                    "description" => $item->getDescription(),
                    "lang_id" => $dlang->getId(),
                    "product_id" => $item->getId(),
                ]);
            }
            $items = Category::all();
            foreach ($items as $item) {
                DBAL::_createDbal("category_lang", [
                    "name" => $item->getName(),
                    "description" => $item->getDescription(),
                    "lang_id" => $dlang->getId(),
                    "category_id" => $item->getId(),
                ]);
            }
            $items = Rate::all();
            foreach ($items as $item) {
                DBAL::_createDbal("rate_lang", [
                    "description" => $item->getDescription(),
                    "lang_id" => $dlang->getId(),
                    "rate_id" => $item->getId(),
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
                        
	