<?php
            //ModuleStock
        
        require '../../../admin/header.php';
        
        global $views;
        $views = __DIR__ . '/Ressource/views';
                


    
    define('CHEMINMODULE', ' <a href="index.php" target="_self" class="titre_module">Administration du system global</a> &gt; <a href="index.php?path=layout" target="_self" class="titre_module">Module ModuleStock</a> ');

    
        		$storageCtrl = new StorageController();		

        if(isset($_GET['path'])){

            $path = explode('/', $_GET['path']);

            switch ($_GET['path']) {

                case 'layout':
                    Genesis::renderBladeView("layout");
                    break;
                        
				case 'storage/index':
					Genesis::renderView('storage.index',  $storageCtrl->listAction(), 'list');
					break;					
				case 'storage/create':
                    Genesis::renderView( 'storage.form', $storageCtrl->createAction(), 'error creation', true);
					break;					
				case 'storage/update':
					Genesis::renderView( 'storage.form',  $storageCtrl->updateAction($_GET['id']),'error updating', true);
					break;


		
                default:
                    echo 'la route n\'existe pas!';
                    break;
            }
    
        }else{
            Genesis::renderBladeView("layout");
        }		
        