<?php 
				
	class Dvups_rightGenesis{
		
		static function genesis($view, $controllers, \Dvups_rightController $dvups_rightCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					Genesis::renderView( $dvups_rightCtrl->listAction(), 'index', 'liste');
					break;
					
				case '_new':
                                        Genesis::renderView( ['dvups_right' => new Dvups_right() ], 'form', 'nouveau', false, 'create');
					break;
					
				case '_edit':
                                        Genesis::renderView( $dvups_rightCtrl->showAction($_GET['id']), 'form', 'editer', false, 'edit&id='.$_GET['id']);
					break;
					
				case 'create':
                                        Genesis::renderView( $dvups_rightCtrl->createAction(), 'index', 'modifier', true);
					break;
					
				case 'edit':
					Genesis::renderView( $dvups_rightCtrl->editAction($_GET['id']), 'index', 'modifier', true);
					break;
					
				case 'show':
                                        Genesis::renderView( $dvups_rightCtrl->showAction($_GET['id']), 'show', '');
					break;
					
				case 'delete':
                                        Genesis::renderView( $dvups_rightCtrl->deleteAction($_GET['id']), 'index', 'modifier', true);
					break;
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}
		}			
			
		static function restGenesis($view, $controllers, \Dvups_rightController $dvups_rightCtrl = null ){
			extract($controllers);
			
			switch($view){
				
				case 'index':
					echo json_encode($dvups_rightCtrl->listAction());
					break;
					
				case 'new':
					echo json_encode($dvups_rightCtrl->createAction());
					break;
					
				case 'edit':
					echo json_encode($dvups_rightCtrl->editAction($_GET['id']));
					break;
					
				case 'show':
					echo json_encode($dvups_rightCtrl->showAction($_GET['id']));
					break;
					
				case 'delete':
					echo json_encode($dvups_rightCtrl->deleteAction($_GET['id']));
					break;
		
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}  
		}
	}
		
