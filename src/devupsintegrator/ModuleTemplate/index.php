<?php
            //ModuleTemplate
        
        require '../../../admin/header.php';
        
// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {
    header("location: " . __env . 'admin/login.php');
}

        global $viewdir, $moduledata;
        $viewdir[] = __DIR__ . '/Ressource/views';
        
$moduledata = Dvups_module::init('ModuleTemplate');
                


    
        define('CHEMINMODULE', ' ');

    
        		$templateCtrl = new TemplateController();
		$pageCtrl = new PageController();
		$hooksCtrl = new HooksController();
		$blockCtrl = new BlockController();
		

(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView("overview");
        break;
        
    case 'template/index':
        $templateCtrl->listView();
        break;

    case 'page/index':
        $pageCtrl->listView();
        break;

    case 'hooks/index':
        $hooksCtrl->listView();
        break;

    case 'block/index':
        $blockCtrl->listView();
        break;

		
    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
    