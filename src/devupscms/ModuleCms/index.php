<?php
//ModuleCms

require '../../../admin/header.php';

// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {
    header("location: " . __env . 'admin/login.php');
}

global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Resource/views';

$moduledata = Dvups_module::init('ModuleCms');

$cmstextCtrl = new CmstextController();
$imagecmsCtrl = new ImagecmsController();


(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView("overview");
        break;

    case 'cmstext/index':
        $cmstextCtrl->listView();
        break;
    case 'cmstext/edit':
        $cmstextCtrl->editView(Request::get("id"));
        break;
    case 'cmstext/update':
        $cmstextCtrl->updateWidgetAction(Request::get("id"));
        break;

    case 'imagecms/index':
        $imagecmsCtrl->listView();
        break;


    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
    