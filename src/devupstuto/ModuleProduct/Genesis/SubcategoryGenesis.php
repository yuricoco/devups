<?php 
				
	class SubcategoryGenesis{
		
		static function genesis($view, $controllers, \SubcategoryController $subcategoryCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					Genesis::renderView('subcategory.index',  $subcategoryCtrl->listAction(), 'list');
					break;
					
				case '_new':
                                                                                                            Genesis::renderView( 'subcategory.form',  $subcategoryCtrl->__newAction(), 'new');
					break;
					
				case 'create':
                                                                                                            Genesis::renderView( 'subcategory.form', $subcategoryCtrl->createAction(), 'error creation', true);
					break;
					
				case '_edit':
                                                                                                            Genesis::renderView( 'subcategory.form',  $subcategoryCtrl->__editAction($_GET['id']), 'edite');
					break;
					
				case 'update':
					Genesis::renderView( 'subcategory.form',  $subcategoryCtrl->updateAction($_GET['id']),'error updating', true);
					break;
					
				case 'show':
                                                                                                                Genesis::renderView( 'subcategory.show', $subcategoryCtrl->showAction($_GET['id']), 'Show');
					break;
					
				case 'delete':
                                                                                                                Genesis::renderView( 'subcategory.show', $subcategoryCtrl->deleteAction($_GET['id']), 'delete', true);
					break;
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}
		}			
			
		static function restGenesis($view, $controllers, \SubcategoryController $subcategoryCtrl = null ){
			extract($controllers);
			
			switch($view){
				
				case 'index':
					echo json_encode($subcategoryCtrl->listAction());
					break;
					
				case 'new':
					echo json_encode($subcategoryCtrl->createAction());
					break;
					
				case 'edit':
					echo json_encode($subcategoryCtrl->editAction($_GET['id']));
					break;
					
				case 'show':
					echo json_encode($subcategoryCtrl->showAction($_GET['id']));
					break;
					
				case 'delete':
					echo json_encode($subcategoryCtrl->deleteAction($_GET['id']));
					break;
		
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}  
		}
	}
		
