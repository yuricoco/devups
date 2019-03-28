<?php 
				
	class Dvups_contentlangGenesis{
		
		static function genesis($view, $controllers, \Dvups_contentlangController $dvups_contentlangCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					Genesis::renderView('dvups_contentlang.index',  $dvups_contentlangCtrl->listAction(), 'list');
					break;
					
				case '_new':
                    Genesis::renderView( 'dvups_contentlang.form',  $dvups_contentlangCtrl->__newAction(), 'new');
					break;
					
				case 'create':
                    Genesis::renderView( 'dvups_contentlang.form', $dvups_contentlangCtrl->createAction(), 'error creation', true);
					break;
					
				case '_edit':
                    Genesis::renderView( 'dvups_contentlang.form',  $dvups_contentlangCtrl->__editAction($_GET['id']), 'edite');
					break;
					
				case 'update':
					Genesis::renderView( 'dvups_contentlang.form',  $dvups_contentlangCtrl->updateAction($_GET['id']),'error updating', true);
					break;
					
				case 'show':
                    Genesis::renderView( 'dvups_contentlang.show', $dvups_contentlangCtrl->showAction($_GET['id']), 'Show');
					break;
					
				case 'delete':
                    Genesis::renderView( 'dvups_contentlang.show', $dvups_contentlangCtrl->deleteAction($_GET['id']), 'delete', true);
					break;
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}
		}			
			
		static function restGenesis($view, $controllers, \Dvups_contentlangController $dvups_contentlangCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					echo json_encode($dvups_contentlangCtrl->listAction());
					break;
					
				case 'new':
					echo json_encode($dvups_contentlangCtrl->createAction());
					break;
					
				case 'edit':
					echo json_encode($dvups_contentlangCtrl->editAction($_GET['id']));
					break;
					
				case 'show':
					echo json_encode($dvups_contentlangCtrl->showAction($_GET['id']));
					break;
					
				case 'delete':
					echo json_encode($dvups_contentlangCtrl->deleteAction($_GET['id']));
					break;
		
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}  
		}
	}
		
