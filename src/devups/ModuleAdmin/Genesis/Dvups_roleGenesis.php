<?php 
				
	class Dvups_roleGenesis{
		
		static function genesis($view, $controllers, \Dvups_roleController $dvups_roleCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					Genesis::renderView('dvups_role.index',  $dvups_roleCtrl->listAction(), 'list');
					break;
					
				case '_new':
                    Genesis::renderView( 'dvups_role.form',  $dvups_roleCtrl->__newAction(), 'new');
					break;
					
				case 'create':
                    Genesis::renderView( 'dvups_role.form', $dvups_roleCtrl->createAction(), 'error creation', true);
					break;
					
				case '_edit':
                    Genesis::renderView( 'dvups_role.form',  $dvups_roleCtrl->__editAction($_GET['id']), 'edite');
					break;
					
				case 'update':
					Genesis::renderView( 'dvups_role.form',  $dvups_roleCtrl->updateAction($_GET['id']),'error updating', true);
					break;
					
				case 'show':
                    Genesis::renderView( 'dvups_role.show', $dvups_roleCtrl->showAction($_GET['id']), 'Show');
					break;
					
				case 'delete':
                    Genesis::renderView( 'dvups_role.show', $dvups_roleCtrl->deleteAction($_GET['id']), 'delete', true);
					break;
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}
		}			
			
		static function restGenesis($view, $controllers, \Dvups_roleController $dvups_roleCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					echo json_encode($dvups_roleCtrl->listAction());
					break;
					
				case 'new':
					echo json_encode($dvups_roleCtrl->createAction());
					break;
					
				case 'edit':
					echo json_encode($dvups_roleCtrl->editAction($_GET['id']));
					break;
					
				case 'show':
					echo json_encode($dvups_roleCtrl->showAction($_GET['id']));
					break;
					
				case 'delete':
					echo json_encode($dvups_roleCtrl->deleteAction($_GET['id']));
					break;
		
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}  
		}
	}
		
