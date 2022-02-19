<?php
//ModuleAdmin

require '../../../admin/header.php';
global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Resource/views';
$moduledata = Dvups_module::init("ModuleAdmin");
//require 'header.php';
//require 'App.php';

//$module = new \devups\ModuleAdmin\ModuleAdmin();
//die;

define('CHEMINMODULE', ' ');

$dvups_adminCtrl = new Dvups_adminController();
$dvups_rightCtrl = new Dvups_rightController();
$dvups_roleCtrl = new Dvups_roleController();


(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView("admin.overview");
        break;

    case 'dvups-admin/complete-registration':
        Genesis::renderView('admin.dvups_admin.complete_registration', $dvups_adminCtrl->completeRegistrationView(Request::get("id")));
        break;
    case 'dvups-admin/complete':
        $dvups_adminCtrl->completeRegistrationAction(Request::get("id"));
        break;
    case 'dvups-admin/profile':
        $dvups_adminCtrl->profile();
        break;
    case 'dvups-admin/credential':
        Genesis::renderView('admin.dvups_admin.credential', ["admin" => Dvups_admin::find(getadmin()->getId())], "profile");
        break;
    case 'dvups-admin/changepassword':
        Genesis::renderView('admin.dvups_admin.changepwd', $dvups_adminCtrl->changepwAction(), true);
        break;
    case 'dvups-admin/editpassword':
        Genesis::renderView('admin.dvups_admin.changepwd', ["detail" => ""], 'list');
        break;
    case 'dvups-admin/resetcredential':
        Genesis::renderView('admin.dvups_admin.index', $dvups_adminCtrl->resetcredential(Request::get("id")),  true);
        break;
    case 'dvups-admin/added':
        Genesis::renderView('admin.dvups_admin.added');
        break;
    case 'dvups-admin/index':
        $dvups_adminCtrl->listView();
        //Genesis::renderView('dvups_admin.index', $dvups_adminCtrl->listAction());
        break;

    case 'dvups-right/index':
        //$dvups_rightCtrl->listView();
        Genesis::renderView('admin.dvups_right.index',  $dvups_rightCtrl->listAction());
        break;

    case 'dvups-role/index':
        $dvups_roleCtrl->listView();
        //Genesis::renderView('dvups_role.index',  $dvups_roleCtrl->listAction());
        break;


    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
