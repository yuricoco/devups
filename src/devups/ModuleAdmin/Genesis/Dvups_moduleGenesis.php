<?php 
				
	class Dvups_moduleGenesis{
		
		static function genesis($view, $controllers, \Dvups_moduleController $dvups_moduleCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					Genesis::renderView( $dvups_moduleCtrl->listAction(), 'index', 'liste');
					break;
					
				case '_new':
                                        Genesis::renderView( ['dvups_module' => new Dvups_module() ], 'form', 'nouveau', false, 'create');
					break;
					
				case '_edit':
                                        Genesis::renderView( $dvups_moduleCtrl->showAction($_GET['id']), 'form', 'editer', false, 'edit&id='.$_GET['id']);
					break;
					
				case 'create':
                                        Genesis::renderView( $dvups_moduleCtrl->createAction(), 'index', 'modifier', true);
					break;
					
				case 'edit':
					Genesis::renderView( $dvups_moduleCtrl->editAction($_GET['id']), 'index', 'modifier', true);
					break;
					
				case 'show':
                                        Genesis::renderView( $dvups_moduleCtrl->showAction($_GET['id']), 'show', '');
					break;
					
				case 'delete':
                                        Genesis::renderView( $dvups_moduleCtrl->deleteAction($_GET['id']), 'index', 'modifier', true);
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
		
