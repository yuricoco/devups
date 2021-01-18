<?php
//ModuleGallery

require '../../../admin/header.php';

// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {
    header("location: " . __env . 'admin/login.php');
}

global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Resource/views';

$moduledata = Dvups_module::init('ModuleGallery');

$dv_imageCtrl = new Dv_imageController();


(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView("admin.overview");
        break;

    case 'dv-image/index':
        $dv_imageCtrl->listView();
        break;


    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
    