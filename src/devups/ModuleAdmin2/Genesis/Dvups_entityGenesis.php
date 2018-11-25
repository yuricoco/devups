<?php 
				
	class Dvups_entityGenesis{
		
		static function genesis($view, $controllers, \Dvups_entityController $dvups_entityCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					Genesis::renderView('dvups_entity.index',  $dvups_entityCtrl->listAction(), 'list');
					break;
					
				case '_new':
                    Genesis::renderView( 'dvups_entity.form',  $dvups_entityCtrl->__newAction(), 'new');
					break;
					
				case 'create':
                    Genesis::renderView( 'dvups_entity.form', $dvups_entityCtrl->createAction(), 'error creation', true);
					break;
					
				case '_edit':
                    Genesis::renderView( 'dvups_entity.form',  $dvups_entityCtrl->__editAction($_GET['id']), 'edite');
					break;
					
				case 'update':
					Genesis::renderView( 'dvups_entity.form',  $dvups_entityCtrl->updateAction($_GET['id']),'error updating', true);
					break;
					
				case 'show':
                    Genesis::renderView( 'dvups_entity.show', $dvups_entityCtrl->showAction($_GET['id']), 'Show');
					break;
					
				case 'delete':
                    Genesis::renderView( 'dvups_entity.show', $dvups_entityCtrl->deleteAction($_GET['id']), 'delete', true);
					break;
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}
		}			
			
		static function restGenesis($view, $controllers, \Dvups_entityController $dvups_entityCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					echo json_encode($dvups_entityCtrl->listAction());
					break;
					
				case 'new':
					echo json_encode($dvups_entityCtrl->createAction());
					break;
					
				case 'edit':
					echo json_encode($dvups_entityCtrl->editAction($_GET['id']));
					break;
					
				case 'show':
					echo json_encode($dvups_entityCtrl->showAction($_GET['id']));
					break;
					
				case 'delete':
					echo json_encode($dvups_entityCtrl->deleteAction($_GET['id']));
					break;
		
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}  
		}
	}
		
