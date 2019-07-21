<?php
//ModuleAdmin

require '../../../admin/header.php';
global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Ressource/views';
$moduledata = Dvups_module::init("ModuleAdmin");

define('CHEMINMODULE', ' ');

$dvups_adminCtrl = new Dvups_adminController();
$dvups_entityCtrl = new Dvups_entityController();
$dvups_moduleCtrl = new Dvups_moduleController();
$dvups_rightCtrl = new Dvups_rightController();
$dvups_roleCtrl = new Dvups_roleController();


(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView("overview");
        break;

    case 'dvups-admin/profile':
        Genesis::renderView('dvups_admin.profile', ["admin" => Dvups_admin::find(getadmin()->getId())], "profile");
        break;
    case 'dvups-admin/changepassword':
        Genesis::renderView('dvups_admin.changepwd', $dvups_adminCtrl->changepwAction(), true);
        break;
    case 'dvups-admin/editpassword':
        Genesis::renderView('dvups_admin.changepwd', ["detail" => ""], 'list');
        break;
    case 'dvups-admin/resetcredential':
        Genesis::renderView('dvups_admin.index', $dvups_adminCtrl->resetcredential(Request::get("id")),  true);
        break;
    case 'dvups-admin/added':
        Genesis::renderView('dvups_admin.added');
        break;
    case 'dvups-admin/index':
        $dvups_adminCtrl->listView();
        //Genesis::renderView('dvups_admin.index', $dvups_adminCtrl->listAction());
        break;

    case 'dvups-entity/index':
        //$dvups_entityCtrl->listView();
        Genesis::renderView('dvups_entity.index',  $dvups_entityCtrl->listAction());
        break;

    case 'dvups-module/index':
        //$dvups_moduleCtrl->listView();
        Genesis::renderView('dvups_module.index',  $dvups_moduleCtrl->listAction());
        break;

    case 'dvups-right/index':
        //$dvups_rightCtrl->listView();
        Genesis::renderView('dvups_right.index',  $dvups_rightCtrl->listAction());
        break;

    case 'dvups-role/index':
        $dvups_roleCtrl->listView();
        //Genesis::renderView('dvups_role.index',  $dvups_roleCtrl->listAction());
        break;


    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
