<?php 
				
	class Dvups_rightGenesis{
		
		static function genesis($view, $controllers, \Dvups_rightController $dvups_rightCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					Genesis::renderView('dvups_right.index',  $dvups_rightCtrl->listAction(), 'list');
					break;
					
				case '_new':
                    Genesis::renderView( 'dvups_right.form',  $dvups_rightCtrl->__newAction(), 'new');
					break;
					
				case 'create':
                    Genesis::renderView( 'dvups_right.form', $dvups_rightCtrl->createAction(), 'error creation', true);
					break;
					
				case '_edit':
                    Genesis::renderView( 'dvups_right.form',  $dvups_rightCtrl->__editAction($_GET['id']), 'edite');
					break;
					
				case 'update':
					Genesis::renderView( 'dvups_right.form',  $dvups_rightCtrl->updateAction($_GET['id']),'error updating', true);
					break;
					
				case 'show':
                    Genesis::renderView( 'dvups_right.show', $dvups_rightCtrl->showAction($_GET['id']), 'Show');
					break;
					
				case 'delete':
                    Genesis::renderView( 'dvups_right.show', $dvups_rightCtrl->deleteAction($_GET['id']), 'delete', true);
					break;
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}
		}			
			
		static function restGenesis($view, $controllers, \Dvups_rightController $dvups_rightCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					echo json_encode($dvups_rightCtrl->listAction());
					break;
					
				case 'new':
					echo json_encode($dvups_rightCtrl->createAction());
					break;
					
				case 'edit':
					echo json_encode($dvups_rightCtrl->editAction($_GET['id']));
					break;
					
				case 'show':
					echo json_encode($dvups_rightCtrl->showAction($_GET['id']));
					break;
					
				case 'delete':
					echo json_encode($dvups_rightCtrl->deleteAction($_GET['id']));
					break;
		
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}  
		}
	}
		
