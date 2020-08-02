<?php
//ModuleAdmin

require '../../../admin/header.php';

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");

global $viewdir;
$viewdir[] = __DIR__ . '/Ressource/views';

$dvups_adminCtrl = new Dvups_adminController();
$dvups_entityCtrl = new Dvups_entityController();
$dvups_moduleCtrl = new Dvups_moduleController();
$dvups_rightCtrl = new Dvups_rightController();
$dvups_roleCtrl = new Dvups_roleController();

(new Request('hello'));

switch (Request::get('path')) {

    case 'dvups_entity.updatelabel':
        g::json_encode(Dvups_entityController::updatelabel($_GET['id'], $_GET['label']));
        break;

    case 'dvups_module.updatelabel':
        g::json_encode(Dvups_moduleController::updatelabel($_GET['id'], $_GET['label']));
        break;

    case 'dvups_admin._new':
        g::json_encode(Dvups_adminController::renderForm());
        break;
    case 'dvups_admin.create':
        g::json_encode($dvups_adminCtrl->createAction());
        break;
    case 'dvups_admin._edit':
        g::json_encode(Dvups_adminController::renderForm(R::get("id")));
        break;
    case 'dvups_admin.update':
        g::json_encode($dvups_adminCtrl->updateAction(R::get("id")));
        break;
    case 'dvups_admin._show':
        g::json_encode(Dvups_adminController::renderDetail(R::get("id")));
        break;
    case 'dvups_admin._delete':
        g::json_encode($dvups_adminCtrl->deleteAction(R::get("id")));
        break;
    case 'dvups_admin._deletegroup':
        g::json_encode($dvups_adminCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'dvups_admin.datatable':
        g::json_encode($dvups_adminCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'dvups_entity._new':
        Dvups_entityForm::render();
        break;
    case 'dvups_entity.create':
        g::json_encode($dvups_entityCtrl->createAction());
        break;
    case 'dvups_entity.update':
        g::json_encode($dvups_entityCtrl->updateAction(R::get("id")));
        break;
    case 'dvups_entity._edit':
        Dvups_entityForm::render(R::get("id"));
        break;
    case 'dvups_entity._show':
        g::json_encode(Dvups_entityController::renderDetail(R::get("id")));
        break;
    case 'dvups_entity._delete':
        g::json_encode($dvups_entityCtrl->deleteAction(R::get("id")));
        break;
    case 'dvups_entity._deletegroup':
        g::json_encode($dvups_entityCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'dvups_entity.datatable':
        g::json_encode($dvups_entityCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'dvups_module._new':
        g::json_encode(Dvups_moduleController::renderForm());
        break;
    case 'dvups_module.create':
        g::json_encode($dvups_moduleCtrl->createAction());
        break;
    case 'dvups_module._edit':
        g::json_encode(Dvups_moduleController::renderForm(R::get("id")));
        break;
    case 'dvups_module.update':
        g::json_encode($dvups_moduleCtrl->updateAction(R::get("id")));
        break;
    case 'dvups_module._show':
        g::json_encode(Dvups_moduleController::renderDetail(R::get("id")));
        break;
    case 'dvups_module._delete':
        g::json_encode($dvups_moduleCtrl->deleteAction(R::get("id")));
        break;
    case 'dvups_module._deletegroup':
        g::json_encode($dvups_moduleCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'dvups_module.datatable':
        g::json_encode($dvups_moduleCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'dvups_right._new':
        g::json_encode(Dvups_rightController::renderForm());
        break;
    case 'dvups_right._edit':
        g::json_encode(Dvups_rightController::renderForm(R::get("id")));
        break;
    case 'dvups_right._show':
        g::json_encode(Dvups_rightController::renderDetail(R::get("id")));
        break;
    case 'dvups_right._delete':
        g::json_encode($dvups_rightCtrl->deleteAction(R::get("id")));
        break;
    case 'dvups_right._deletegroup':
        g::json_encode($dvups_rightCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'dvups_right.datatable':
        g::json_encode($dvups_rightCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'dvups_role._new':
        Dvups_roleForm::renderWidget();
        break;
    case 'dvups_role.create':
        g::json_encode($dvups_roleCtrl->createAction());
        break;
    case 'dvups_role.update':
        g::json_encode($dvups_roleCtrl->updateAction(R::get("id")));
        break;
    case 'dvups_role._edit':
        Dvups_roleForm::renderWidget(R::get("id"));
        break;
    case 'dvups_role._show':
        g::json_encode(Dvups_roleController::renderDetail(R::get("id")));
        break;
    case 'dvups_role._delete':
        g::json_encode($dvups_roleCtrl->deleteAction(R::get("id")));
        break;
    case 'dvups_role._deletegroup':
        g::json_encode($dvups_roleCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'dvups_role.datatable':
        g::json_encode($dvups_roleCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'dvups_:update':
        g::json_encode($dvups_roleCtrl->privilegeUpdate());
        break;

    default:
        g::json_encode("404 : page  '" . Request::get('path') . "' note found");
        break;
}

