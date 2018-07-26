<?php 
				
	class TestentityGenesis{
		
		static function genesis($view, $controllers, \TestentityController $testentityCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					Genesis::renderView('testentity.index',  $testentityCtrl->listAction(), 'list');
					break;
					
				case '_new':
                    Genesis::renderView( 'testentity.form',  $testentityCtrl->__newAction(), 'new');
					break;
					
				case 'create':
                    Genesis::renderView( 'testentity.form', $testentityCtrl->createAction(), 'error creation', true);
					break;
					
				case '_edit':
                    Genesis::renderView( 'testentity.form',  $testentityCtrl->__editAction($_GET['id']), 'edite');
					break;
					
				case 'update':
					Genesis::renderView( 'testentity.form',  $testentityCtrl->updateAction($_GET['id']),'error updating', true);
					break;
					
				case 'show':
                    Genesis::renderView( 'testentity.show', $testentityCtrl->showAction($_GET['id']), 'Show');
					break;
					
				case 'delete':
                    Genesis::renderView( 'testentity.show', $testentityCtrl->deleteAction($_GET['id']), 'delete', true);
					break;
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}
		}			
			
		static function restGenesis($view, $controllers, \TestentityController $testentityCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					echo json_encode($testentityCtrl->listAction());
					break;
					
				case 'new':
					echo json_encode($testentityCtrl->createAction());
					break;
					
				case 'edit':
					echo json_encode($testentityCtrl->editAction($_GET['id']));
					break;
					
				case 'show':
					echo json_encode($testentityCtrl->showAction($_GET['id']));
					break;
					
				case 'delete':
					echo json_encode($testentityCtrl->deleteAction($_GET['id']));
					break;
		
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}  
		}
	}
		
