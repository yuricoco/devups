<?php 
				
	class Dvups_entityGenesis{
		
		static function genesis($view, $controllers, \Dvups_entityController $dvups_entityCtrl = null ){
			extract($controllers);
			
			switch($view){
				case 'index':
					Genesis::renderView( $dvups_entityCtrl->listAction(), 'index', 'liste');
					break;
					
				case '_new':
                                        Genesis::renderView( ['dvups_entity' => new Dvups_entity() ], 'form', 'nouveau', false, 'create');
					break;
					
				case '_edit':
                                        Genesis::renderView( $dvups_entityCtrl->showAction($_GET['id']), 'form', 'editer', false, 'edit&id='.$_GET['id']);
					break;
					
				case 'create':
                                        Genesis::renderView( $dvups_entityCtrl->createAction(), 'index', 'modifier', true);
					break;
					
				case 'edit':
					Genesis::renderView( $dvups_entityCtrl->editAction($_GET['id']), 'index', 'modifier', true);
					break;
					
				case 'show':
                                        Genesis::renderView( $dvups_entityCtrl->showAction($_GET['id']), 'show', '');
					break;
					
				case 'delete':
                                        Genesis::renderView( $dvups_entityCtrl->deleteAction($_GET['id']), 'index', 'modifier', true);
					break;
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}
		}			
			
		static function restGenesis($view, $controllers, \Dvups_entityController $dvups_entityCtrl = null ){
			extract($controllers);
			
			switch($view){
				
				case 'index':
					echo json_encode($dvups_entityCtrl->listAction());
					break;
					
				case 'new':
					echo json_encode($dvups_entityCtrl->createAction());
					break;
					
				case 'edit':
					echo json_encode($dvups_entityCtrl->editAction($_GET['id']));
					break;
					
				case 'show':
					echo json_encode($dvups_entityCtrl->showAction($_GET['id']));
					break;
					
				case 'delete':
					echo json_encode($dvups_entityCtrl->deleteAction($_GET['id']));
					break;
		
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}  
		}
	}
		
