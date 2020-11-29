<?php
            //ModuleNotification
        
        require '../../../admin/header.php';
        
// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {
    header("location: " . __env . 'admin/login.php');
}

        global $viewdir, $moduledata;
        $viewdir[] = __DIR__ . '/Ressource/views';
        
$moduledata = Dvups_module::init('ModuleNotification');
                


    
        define('CHEMINMODULE', ' ');

    
        		$emailmodelCtrl = new EmailmodelController();
		$notificationCtrl = new NotificationController();
		$notificationbroadcastedCtrl = new NotificationbroadcastedController();
		

(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView("overview");
        break;

    case 'emailmodel/index':
        $emailmodelCtrl->listView();
        break;
    case 'emailmodel/new':
        EmailmodelForm::renderWidget();
        break;
    case 'emailmodel/create':
        $emailmodelCtrl->createAction();
        break;
    case 'emailmodel/edit':
        EmailmodelForm::renderWidget(Request::get("id"));
        break;
    case 'emailmodel/update':
        $emailmodelCtrl->updateAction(Request::get("id"));
        break;

    case 'notification/index':
        $notificationCtrl->listView();
        break;

    case 'notificationbroadcasted/index':
        $notificationbroadcastedCtrl->listView();
        break;

		
    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
    