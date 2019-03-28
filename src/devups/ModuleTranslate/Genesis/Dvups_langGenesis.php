<?php 
				
	class Dvups_langGenesis{
		
		static function genesis($view, $controllers, \Dvups_langController $dvups_langCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					Genesis::renderView('dvups_lang.index',  $dvups_langCtrl->listAction(), 'list');
					break;
					
				case '_new':
                    Genesis::renderView( 'dvups_lang.form',  $dvups_langCtrl->__newAction(), 'new');
					break;
					
				case 'create':
                    Genesis::renderView( 'dvups_lang.form', $dvups_langCtrl->createAction(), 'error creation', true);
					break;
					
				case '_edit':
                    Genesis::renderView( 'dvups_lang.form',  $dvups_langCtrl->__editAction($_GET['id']), 'edite');
					break;
					
				case 'update':
					Genesis::renderView( 'dvups_lang.form',  $dvups_langCtrl->updateAction($_GET['id']),'error updating', true);
					break;
					
				case 'show':
                    Genesis::renderView( 'dvups_lang.show', $dvups_langCtrl->showAction($_GET['id']), 'Show');
					break;
					
				case 'delete':
                    Genesis::renderView( 'dvups_lang.show', $dvups_langCtrl->deleteAction($_GET['id']), 'delete', true);
					break;
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}
		}			
			
		static function restGenesis($view, $controllers, \Dvups_langController $dvups_langCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					echo json_encode($dvups_langCtrl->listAction());
					break;
					
				case 'new':
					echo json_encode($dvups_langCtrl->createAction());
					break;
					
				case 'edit':
					echo json_encode($dvups_langCtrl->editAction($_GET['id']));
					break;
					
				case 'show':
					echo json_encode($dvups_langCtrl->showAction($_GET['id']));
					break;
					
				case 'delete':
					echo json_encode($dvups_langCtrl->deleteAction($_GET['id']));
					break;
		
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}  
		}
	}
		
