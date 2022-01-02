<?php
//ModuleCms

require '../../../admin/header.php';

// verification token
//

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");

global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Ressource/views';


$cmstextCtrl = new CmstextController();
$imagecmsCtrl = new ImagecmsController();

(new Request('hello'));

switch (R::get('path')) {

    case 'cmstext._new':
        CmstextForm::render();
        break;
    case 'cmstext.create':
        g::json_encode($cmstextCtrl->createAction());
        break;
    case 'cmstext.form':
        CmstextForm::render(R::get("id"));
        break;
    case 'cmstext/update':
        g::json_encode($cmstextCtrl->updateAction(R::get("id")));
        break;
    case 'cmstext.update':
        g::json_encode($cmstextCtrl->updateAction(R::get("id")));
        break;
    case 'cmstext.uploadimage':
        g::json_encode($cmstextCtrl->uploadAction());
        break;
    case 'cmstext.loadimage':
        g::json_encode($cmstextCtrl->loadAction());
        break;
    case 'cmstext.deleteimage':
        g::json_encode($cmstextCtrl->deleteimageAction());
        break;
    case 'cmstext._show':
        $cmstextCtrl->detailView(R::get("id"));
        break;
    case 'cmstext._delete':
        g::json_encode($cmstextCtrl->deleteAction(R::get("id")));
        break;
    case 'cmstext._deletegroup':
        g::json_encode($cmstextCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'cmstext.datatable':
        g::json_encode($cmstextCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'imagecms._new':
        ImagecmsForm::renderWidget();
        break;
    case 'imagecms.create':
        g::json_encode($imagecmsCtrl->createAction());
        break;
    case 'imagecms.form':
        ImagecmsForm::renderWidget(R::get("id"));
        break;
    case 'imagecms.update':
        g::json_encode($imagecmsCtrl->updateAction(R::get("id")));
        break;
    case 'imagecms._show':
        $imagecmsCtrl->detailView(R::get("id"));
        break;
    case 'imagecms._delete':
        g::json_encode($imagecmsCtrl->deleteAction(R::get("id")));
        break;
    case 'imagecms._deletegroup':
        g::json_encode($imagecmsCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'imagecms.datatable':
        g::json_encode($imagecmsCtrl->datatable(R::get('next'), R::get('per_page')));
        break;


    default:
        g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
        break;
}

