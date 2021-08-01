<?php
//ModuleSlide

require '../../../admin/header.php';

// verification token
//

global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Resource/views';

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");


$slideCtrl = new SlideController();

(new Request('hello'));

switch (R::get('path')) {

    case 'slide._new':
        SlideForm::render();
        break;
    case 'slide.orderlist':
        g::json_encode($slideCtrl->sortlistAction());
        break;
    case 'slide.change-status':
        g::json_encode($slideCtrl->changeStatusAction(R::get("id")));
        break;
    case 'slide.create':
        g::json_encode($slideCtrl->createAction());
        break;
    case 'slide._edit':
        SlideForm::render(R::get("id"));
        break;
    case 'slide.update':
        g::json_encode($slideCtrl->updateAction(R::get("id")));
        break;
    case 'slide._show':
        $slideCtrl->detailView(R::get("id"));
        break;
    case 'slide._delete':
        g::json_encode($slideCtrl->deleteAction(R::get("id")));
        break;
    case 'slide._deletegroup':
        g::json_encode($slideCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'slide.datatable':
        g::json_encode($slideCtrl->datatable(R::get('next'), R::get('per_page')));
        break;


    default:
        g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
        break;
}

