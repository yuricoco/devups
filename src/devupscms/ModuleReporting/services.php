<?php
//ModuleReporting

require '../../../admin/header.php';

// verification token
//

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");

global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Resource/views';


$emaillogCtrl = new EmaillogController();
$reportingmodelCtrl = new ReportingmodelController();

(new Request('hello'));

switch (R::get('path')) {

    case 'emaillog._new':
        g::json_encode($emaillogCtrl->formView());
        break;
    case 'emaillog.create':
        g::json_encode($emaillogCtrl->createAction());
        break;
    case 'emaillog.form':
        g::json_encode($emaillogCtrl->formView(R::get("id")));
        break;
    case 'emaillog.update':
        g::json_encode($emaillogCtrl->updateAction(R::get("id")));
        break;
    case 'emaillog._show':
        $emaillogCtrl->detailView(R::get("id"));
        break;
    case 'emaillog._delete':
        g::json_encode($emaillogCtrl->deleteAction(R::get("id")));
        break;
    case 'emaillog._deletegroup':
        g::json_encode($emaillogCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'emaillog.datatable':
        g::json_encode($emaillogCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'reportingmodel._new':
        g::json_encode($reportingmodelCtrl->formView());
        break;
    case 'reportingmodel._clonerow':
        g::json_encode($reportingmodelCtrl->cloneAction(Request::get("id")));
        break;
    case 'reportingmodel.create':
        g::json_encode($reportingmodelCtrl->createAction());
        break;
    case 'reportingmodel.form':
        g::json_encode($reportingmodelCtrl->formView(R::get("id")));
        break;
    case 'reportingmodel.update':
        g::json_encode($reportingmodelCtrl->updateAction(R::get("id")));
        break;
    case 'reportingmodel.update-email':
        $reportingmodelCtrl->updateMailAction(R::get("id"));
        break;
    case 'reportingmodel._show':
        $reportingmodelCtrl->detailView(R::get("id"));
        break;
    case 'reportingmodel._delete':
        g::json_encode($reportingmodelCtrl->deleteAction(R::get("id")));
        break;
    case 'reportingmodel._deletegroup':
        g::json_encode($reportingmodelCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'reportingmodel.datatable':
        g::json_encode($reportingmodelCtrl->datatable(R::get('next'), R::get('per_page')));
        break;
    case 'reportingmodel.testmail':
        g::json_encode($reportingmodelCtrl->testmailAction(R::get('id'), R::get('email')));
        break;


    default:
        g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
        break;
}

