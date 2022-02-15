<?php
//ModuleReporting

require '../../../admin/header.php';

// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {
    header("location: " . __env . 'admin/login.php');
}

global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Resource/views';

$moduledata = Dvups_module::init('ModuleReporting');


$emaillogCtrl = new EmaillogController();
$reportingmodelCtrl = new ReportingmodelController();


(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView("admin.overview");
        break;

    case 'reportingmodel/preview':
        $reportingmodelCtrl = Reportingmodel::find(Request::get("id"));
        echo $reportingmodelCtrl->getPreview();
        break;
    case 'reportingmodel/pdf':
        $reportingmodelCtrl = Reportingmodel::find(Request::get("id"));
        $mpdf = new \Mpdf\Mpdf([
            "margin_left" => 0,
            "margin_right" => 0,
            "margin_top" => 0,
            "margin_bottom" => 0,
        ]);

// Write some HTML code:
        $mpdf->WriteHTML($reportingmodelCtrl->getPreview());

// Output a PDF file directly to the browser
        $mpdf->Output();
        // echo $reportingmodel->getPreview();
        break;
    case 'reportingmodel/index':
        $reportingmodelCtrl->listView();
        break;
    case 'reportingmodel/create':
        $reportingmodelCtrl->createAction();
        break;
    case 'reportingmodel/edit-email':
        $reportingmodelCtrl->editmailView(Request::get("id"));
        //ReportingmodelForm::renderWidget(Request::get("id"));
        break;
    case 'reportingmodel/update':
        $reportingmodelCtrl->updateAction(Request::get("id"));
        break;

    case 'emaillog/index':
        $emaillogCtrl->listView();
        break;

    case 'reportingmodel/index':
        $reportingmodelCtrl->listView();
        break;


    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
    