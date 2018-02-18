<?php
    //ModuleStock
		
        require '../../../admin/header.php';
        
        global $views;
        $views = __DIR__ . '/Ressource/views';
        

           // require 'devupstuto.modulestock.php';		
    define('CHEMINMODULE', ' <a href="'. __env .'admin" target="_self" class="titre_module">Administration du system global</a> &gt; <a href="index.php?path=layout" target="_self" class="titre_module">Module ModuleStock</a> ');


    $controllers = [
			'storageCtrl' => new StorageController(),
		 ];
			
		if(isset($_GET['path'])){
			
			$path = explode('/', $_GET['path']);
		
			switch ($path[ENTITY]) {
				
				case 'layout':
                                                                                                              Genesis::renderBladeView("layout");
					break;
						
				case 'storage':
					StorageGenesis::genesis($path[VIEW], $controllers);
					break;

				case 'storage.rest':
					StorageGenesis::restGenesis($path[VIEW], $controllers);
					break;

		
				default:
					echo 'la route n\'existe pas!';
					break;
			}

		}else{
                        Genesis::renderBladeView("layout");
                }		
    