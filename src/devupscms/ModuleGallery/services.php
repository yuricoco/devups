<?php
//ModuleGallery

require '../../../admin/header.php';

// verification token
//

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");


$dv_imageCtrl = new Dv_imageController();

(new Request('hello'));

switch (R::get('path')) {

    case 'dv_image._new':
        Dv_imageForm::render();
        break;
    case 'dv_image.create':
        g::json_encode($dv_imageCtrl->createAction());
        break;
    case 'dv_image.store':
        g::json_encode($dv_imageCtrl->storeImage());
        break;
    case 'dv_image.form':
        Dv_imageForm::render(R::get("id"));
        break;
    case 'dv_image.update':
        g::json_encode($dv_imageCtrl->updateAction(R::get("id")));
        break;
    case 'dv_image._show':
        $dv_imageCtrl->detailView(R::get("id"));
        break;
    case 'dv_image._delete':
        g::json_encode($dv_imageCtrl->deleteAction(R::get("id")));
        break;
    case 'dv_image._deletegroup':
        g::json_encode($dv_imageCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'dv_image.datatable':
        g::json_encode($dv_imageCtrl->datatable(R::get('next'), R::get('per_page')));
        break;


    default:
        g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
        break;
}

