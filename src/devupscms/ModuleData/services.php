<?php
//ModuleData

require '../../../admin/header.php';

// verification token
//

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");


$statusCtrl = new StatusController();

(new Request('hello'));

switch (R::get('path')) {

    case 'status._new':
        StatusForm::render(R::get("id"));
        //g::json_encode($statusCtrl->formView());
        break;
    case 'status.create':
        g::json_encode($statusCtrl->createAction());
        break;
    case 'status.form':
        StatusForm::render(R::get("id"));
        //g::json_encode($statusCtrl->formView(R::get("id")));
        break;
    case 'status._clonerow':
        g::json_encode($statusCtrl->cloneAction(R::get("id")));
        break;
    case 'status.update':
        g::json_encode($statusCtrl->updateAction(R::get("id")));
        break;
    case 'status._show':
        $statusCtrl->detailView(R::get("id"));
        break;
    case 'status._delete':
        g::json_encode($statusCtrl->deleteAction(R::get("id")));
        break;
    case 'status._deletegroup':
        g::json_encode($statusCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'status.datatable':
        g::json_encode($statusCtrl->datatable(R::get('next'), R::get('per_page')));
        break;


    default:
        g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
        break;
}

