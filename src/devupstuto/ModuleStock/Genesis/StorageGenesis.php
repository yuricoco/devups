<?php 
				
	class StorageGenesis{
		
		static function genesis($view, $controllers, \StorageController $storageCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					Genesis::renderView('storage.index',  $storageCtrl->listAction(), 'list');
					break;
					
				case '_new':
                    Genesis::renderView( 'storage.form',  $storageCtrl->__newAction(), 'new');
					break;
					
				case 'create':
                    Genesis::renderView( 'storage.form', $storageCtrl->createAction(), 'error creation', true);
					break;
					
				case '_edit':
                    Genesis::renderView( 'storage.form',  $storageCtrl->__editAction($_GET['id']), 'edite');
					break;
					
				case 'update':
					Genesis::renderView( 'storage.form',  $storageCtrl->updateAction($_GET['id']),'error updating', true);
					break;
					
				case 'show':
                    Genesis::renderView( 'storage.show', $storageCtrl->showAction($_GET['id']), 'Show');
					break;
					
				case 'delete':
                    Genesis::renderView( 'storage.show', $storageCtrl->deleteAction($_GET['id']), 'delete', true);
					break;
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}
		}			
			
		static function restGenesis($view, $controllers, \StorageController $storageCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					echo json_encode($storageCtrl->listAction());
					break;
					
				case 'new':
					echo json_encode($storageCtrl->createAction());
					break;
					
				case 'edit':
					echo json_encode($storageCtrl->editAction($_GET['id']));
					break;
					
				case 'show':
					echo json_encode($storageCtrl->showAction($_GET['id']));
					break;
					
				case 'delete':
					echo json_encode($storageCtrl->deleteAction($_GET['id']));
					break;
		
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}  
		}
	}
		
