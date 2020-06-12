<?php
            //ModuleLang
        
        require '../../../admin/header.php';
        
// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {
    header("location: " . __env . 'admin/login.php');
}

        global $viewdir, $moduledata;
        $viewdir[] = __DIR__ . '/Ressource/views';
        
$moduledata = Dvups_module::init('ModuleLang');
                


    
        define('CHEMINMODULE', ' ');

    
        		$local_content_keyCtrl = new Local_content_keyController();
		$local_contentCtrl = new Local_contentController();
		$page_mappedCtrl = new Page_mappedController();
		$page_local_contentCtrl = new Page_local_contentController();
		

(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView("overview");
        break;
        
    case 'local-content-key/index':
        $local_content_keyCtrl->listView();
        break;

    case 'local-content/index':
        $local_contentCtrl->listView();
        break;

    case 'page-mapped/index':
        $page_mappedCtrl->listView();
        break;

    case 'page-local-content/index':
        $page_local_contentCtrl->listView();
        break;

		
    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
    