<?php
//ModuleProduct

require '../../../admin/header.php';

// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {
    header("location: " . __env . 'admin/login.php');
}

global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Ressource/views';

$moduledata = Dvups_module::init('ModuleProduct');


define('CHEMINMODULE', ' ');


$categoryCtrl = new CategoryController();
$productCtrl = new ProductController();


(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView("overview");
        break;

    case 'category/index':
        $categoryCtrl->listView();
        break;

    case 'product/index':
        $productCtrl->listView();
        break;


    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
