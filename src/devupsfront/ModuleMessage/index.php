<?php
            //ModuleMessage
        
        require '../../../admin/header.php';
        
// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {
    header("location: " . __env . 'admin/login.php');
}

global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Resource/views';

$moduledata = Dvups_module::init('ModuleMessage');
                

		$messageCtrl = new MessageController();
		$newsletterCtrl = new NewsletterController();
		

(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView("admin.overview");
        break;
        
    case 'message/index':
        $messageCtrl->listView();
        break;

    case 'newsletter/index':
        $newsletterCtrl->listView();
        break;

		
    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
    