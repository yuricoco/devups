<?php 
				
	class Dvups_moduleGenesis{
		
		static function genesis($view, $controllers, \Dvups_moduleController $dvups_moduleCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					Genesis::renderView('dvups_module.index',  $dvups_moduleCtrl->listAction(), 'list');
					break;
					
				case '_new':
                    Genesis::renderView( 'dvups_module.form',  $dvups_moduleCtrl->__newAction(), 'new');
					break;
					
				case 'create':
                    Genesis::renderView( 'dvups_module.form', $dvups_moduleCtrl->createAction(), 'error creation', true);
					break;
					
				case '_edit':
                    Genesis::renderView( 'dvups_module.form',  $dvups_moduleCtrl->__editAction($_GET['id']), 'edite');
					break;
					
				case 'update':
					Genesis::renderView( 'dvups_module.form',  $dvups_moduleCtrl->updateAction($_GET['id']),'error updating', true);
					break;
					
				case 'show':
                    Genesis::renderView( 'dvups_module.show', $dvups_moduleCtrl->showAction($_GET['id']), 'Show');
					break;
					
				case 'delete':
                    Genesis::renderView( 'dvups_module.show', $dvups_moduleCtrl->deleteAction($_GET['id']), 'delete', true);
					break;
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}
		}			
			
		static function restGenesis($view, $controllers, \Dvups_moduleController $dvups_moduleCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					echo json_encode($dvups_moduleCtrl->listAction());
					break;
					
				case 'new':
					echo json_encode($dvups_moduleCtrl->createAction());
					break;
					
				case 'edit':
					echo json_encode($dvups_moduleCtrl->editAction($_GET['id']));
					break;
					
				case 'show':
					echo json_encode($dvups_moduleCtrl->showAction($_GET['id']));
					break;
					
				case 'delete':
					echo json_encode($dvups_moduleCtrl->deleteAction($_GET['id']));
					break;
		
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}  
		}
	}
		
