<?php
//ModuleConfig

require '../../../admin/header.php';

// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {
    header("location: " . __env . 'admin/login.php');
}

global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Resource/views';

$moduledata = Dvups_module::init('ModuleConfig');


define('CHEMINMODULE', ' ');


$dvups_componentCtrl = new Dvups_componentController();
$dvups_entityCtrl = new Dvups_entityController();
$dvups_moduleCtrl = new Dvups_moduleController();
$configurationCtrl = new ConfigurationController();


(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView("admin.overview");
        break;

    case 'dvups-component/index':
        $dvups_componentCtrl->listView();
        break;

    case 'dvups-entity/index':
        $dvups_entityCtrl->listView();
        break;

    case 'dvups-module/index':
        $dvups_moduleCtrl->listView();
        break;

    case 'configuration/index':
        $configurationCtrl->listView();
        break;


    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
    