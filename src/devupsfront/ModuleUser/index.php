<?php
//ModuleUser

require '../../../admin/header.php';

// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {
    header("location: " . __env . 'admin/login.php');
}

global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Ressource/views';

$moduledata = Dvups_module::init('ModuleUser');


define('CHEMINMODULE', ' ');


$addressCtrl = new AddressController();
$userCtrl = new UserController();


(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView("overview");
        break;

    case 'address/index':
        $addressCtrl->listView();
        break;

    case 'user/index':
        $userCtrl->listView();
        break;


    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
    