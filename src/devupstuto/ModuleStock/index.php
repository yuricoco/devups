<?php
            //ModuleStock
        
        require '../../../admin/header.php';
        global $viewdir;
        $viewdir[] = __DIR__ . '/Ressource/views';
                


    
        define('CHEMINMODULE', ' ');

    
        		$storageCtrl = new StorageController();
		

(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView("layout");
        break;
        
    case 'storage/index':
        Genesis::renderView('storage.index',  $storageCtrl->listAction());
        break;

		
    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
    