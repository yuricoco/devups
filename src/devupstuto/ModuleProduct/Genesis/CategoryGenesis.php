<?php 
				
	class CategoryGenesis{
		
		static function genesis($view, $controllers, \CategoryController $categoryCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					Genesis::renderView('category.index',  $categoryCtrl->listAction(), 'list');
					break;
					
				case '_new':
                                                                                                            Genesis::renderView( 'category.form',  $categoryCtrl->__newAction(), 'new');
					break;
					
				case 'create':
                                                                                                            Genesis::renderView( 'category.form', $categoryCtrl->createAction(), 'error creation', true);
					break;
					
				case '_edit':
                                                                                                            Genesis::renderView( 'category.form',  $categoryCtrl->__editAction($_GET['id']), 'edite');
					break;
					
				case 'update':
					Genesis::renderView( 'category.form',  $categoryCtrl->updateAction($_GET['id']),'error updating', true);
					break;
					
				case 'show':
                                                                                                                Genesis::renderView( 'category.show', $categoryCtrl->showAction($_GET['id']), 'Show');
					break;
					
				case 'delete':
                                                                                                                Genesis::renderView( 'category.show', $categoryCtrl->deleteAction($_GET['id']), 'delete', true);
					break;
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}
		}			
			
		static function restGenesis($view, $controllers, \CategoryController $categoryCtrl = null ){
			extract($controllers);
			
			switch($view){
				
				case 'index':
					echo json_encode($categoryCtrl->listAction());
					break;
					
				case 'new':
					echo json_encode($categoryCtrl->createAction());
					break;
					
				case 'edit':
					echo json_encode($categoryCtrl->editAction($_GET['id']));
					break;
					
				case 'show':
					echo json_encode($categoryCtrl->showAction($_GET['id']));
					break;
					
				case 'delete':
					echo json_encode($categoryCtrl->deleteAction($_GET['id']));
					break;
		
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}  
		}
	}
		
