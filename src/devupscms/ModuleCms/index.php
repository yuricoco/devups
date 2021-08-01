<?php
//ModuleCms

require '../../../admin/header.php';

// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {
    header("location: " . __env . 'admin/login.php');
}

global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Ressource/views';

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
    case 'cmstext/new':
        CmstextForm::renderWidget();
        break;
    case 'cmstext/create':
        $cmstextCtrl->createWidgetAction();
        break;
    case 'cmstext/edit':
        CmstextForm::renderWidget(Request::get("id"));
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
    
    