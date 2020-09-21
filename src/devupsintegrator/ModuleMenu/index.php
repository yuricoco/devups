<?php
            //ModuleMenu
        
        require '../../../admin/header.php';
        
// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {
    header("location: " . __env . 'admin/login.php');
}

        global $viewdir, $moduledata;
        $viewdir[] = __DIR__ . '/Ressource/views';
        
$moduledata = Dvups_module::init('ModuleMenu');
                


    
        define('CHEMINMODULE', ' ');

    
        		$menuCtrl = new MenuController();
		$encreCtrl = new EncreController();
		$menuencreCtrl = new MenuencreController();
		

(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView("overview");
        break;
        
    case 'menu/index':
        $menuCtrl->listView();
        break;

    case 'encre/index':
        $encreCtrl->listView();
        break;

    case 'menuencre/index':
        $menuencreCtrl->listView();
        break;

		
    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
    