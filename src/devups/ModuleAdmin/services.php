<?php
//ModuleAdmin

require '../../../admin/header.php';

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");

global $viewdir;
$viewdir[] = __DIR__ . '/Resource/views';

$dvups_adminCtrl = new Dvups_adminController();
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

    case 'dvups_admin.create':
        g::json_encode($dvups_adminCtrl->createAction());
        break;
    case 'dvups_admin.form':
        g::json_encode(Dvups_adminController::renderForm(R::get("id")));
        break;
    case 'dvups_admin.update':
        g::json_encode($dvups_adminCtrl->updateAction(R::get("id")));
        break;
    case 'dvups_admin.delete':
        g::json_encode($dvups_adminCtrl->deleteAction(R::get("id")));
        break;
    case 'dvups_admin.deletegroup':
        g::json_encode($dvups_adminCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'dvups_admin.datatable':
        g::json_encode($dvups_adminCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'dvups_right._new':
        g::json_encode(Dvups_rightController::renderForm());
        break;
    case 'dvups_right.form':
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
        g::json_encode(Dvups_roleForm::renderWidget());
        break;
    case 'dvups_role.create':
        g::json_encode($dvups_roleCtrl->createAction());
        break;
    case 'dvups_role.update':
        g::json_encode($dvups_roleCtrl->updateAction(R::get("id")));
        break;
    case 'dvups_role.form':
        g::json_encode(Dvups_roleForm::renderWidget(R::get("id")));
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

