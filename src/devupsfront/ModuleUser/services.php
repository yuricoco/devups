<?php
//ModuleUser

require '../../../admin/header.php';

// verification token
//

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");


$userCtrl = new UserController();

(new Request('hello'));

switch (R::get('path')) {

    case 'user._new':
        UserForm::render();
        break;
    case 'user.create':
        g::json_encode($userCtrl->createAction());
        break;
    case 'user.form':
        UserForm::render(R::get("id"));
        break;
    case 'user.update':
        g::json_encode($userCtrl->updateAction(R::get("id")));
        break;
    case 'user._show':
        $userCtrl->detailView(R::get("id"));
        break;
    case 'user._delete':
        g::json_encode($userCtrl->deleteAction(R::get("id")));
        break;
    case 'user._deletegroup':
        g::json_encode($userCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'user.datatable':
        g::json_encode($userCtrl->datatable(R::get('next'), R::get('per_page')));
        break;


    default:
        g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
        break;
}

