<?php 
				
	class ProductGenesis{
		
		static function genesis($view, $controllers, \ProductController $productCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					Genesis::renderView('product.index',  $productCtrl->listAction(), 'list');
					break;
					
				case '_new':
                                                                                                            Genesis::renderView( 'product.form',  $productCtrl->__newAction(), 'new');
					break;
					
				case 'create':
                                                                                                            Genesis::renderView( 'product.form', $productCtrl->createAction(), 'error creation', true);
					break;
					
				case '_edit':
                                                                                                            Genesis::renderView( 'product.form',  $productCtrl->__editAction($_GET['id']), 'edite');
					break;
					
				case 'update':
					Genesis::renderView( 'product.form',  $productCtrl->updateAction($_GET['id']),'error updating', true);
					break;
					
				case 'show':
                                                                                                                Genesis::renderView( 'product.show', $productCtrl->showAction($_GET['id']), 'Show');
					break;
					
				case 'delete':
                                                                                                                Genesis::renderView( 'product.show', $productCtrl->deleteAction($_GET['id']), 'delete', true);
					break;
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}
		}			
			
		static function restGenesis($view, $controllers, \ProductController $productCtrl = null ){
			extract($controllers);
			
			switch($view){
				
				case 'index':
					echo json_encode($productCtrl->listAction());
					break;
					
				case 'new':
					echo json_encode($productCtrl->createAction());
					break;
					
				case 'edit':
					echo json_encode($productCtrl->editAction($_GET['id']));
					break;
					
				case 'show':
					echo json_encode($productCtrl->showAction($_GET['id']));
					break;
					
				case 'delete':
					echo json_encode($productCtrl->deleteAction($_GET['id']));
					break;
		
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}  
		}
	}
		
