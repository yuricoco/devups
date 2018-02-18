<?php 
				
	class ImageGenesis{
		
		static function genesis($view, $controllers, \ImageController $imageCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					Genesis::renderView('image.index',  $imageCtrl->listAction(), 'list');
					break;
					
				case '_new':
                                                                                                            Genesis::renderView( 'image.form',  $imageCtrl->__newAction(), 'new');
					break;
					
				case 'create':
                                                                                                            Genesis::renderView( 'image.form', $imageCtrl->createAction(), 'error creation', true);
					break;
					
				case '_edit':
                                                                                                            Genesis::renderView( 'image.form',  $imageCtrl->__editAction($_GET['id']), 'edite');
					break;
					
				case 'update':
					Genesis::renderView( 'image.form',  $imageCtrl->updateAction($_GET['id']),'error updating', true);
					break;
					
				case 'show':
                                                                                                                Genesis::renderView( 'image.show', $imageCtrl->showAction($_GET['id']), 'Show');
					break;
					
				case 'delete':
                                                                                                                Genesis::renderView( 'image.show', $imageCtrl->deleteAction($_GET['id']), 'delete', true);
					break;
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}
		}			
			
		static function restGenesis($view, $controllers, \ImageController $imageCtrl = null ){
			extract($controllers);
			
			switch($view){
				
				case 'index':
					echo json_encode($imageCtrl->listAction());
					break;
					
				case 'new':
					echo json_encode($imageCtrl->createAction());
					break;
					
				case 'edit':
					echo json_encode($imageCtrl->editAction($_GET['id']));
					break;
					
				case 'show':
					echo json_encode($imageCtrl->showAction($_GET['id']));
					break;
					
				case 'delete':
					echo json_encode($imageCtrl->deleteAction($_GET['id']));
					break;
		
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}  
		}
	}
		
