<?php 
class RootGenerator{
	
	public function entityRooting($entity){
		
		$name = strtolower($entity->name);
		$contenu = "<?php 
				
	class ".ucfirst($name)."Genesis{
		
		static function genesis($"."view, $"."controllers, \\".ucfirst($name)."Controller $".$name."Ctrl = null ){
			extract($"."controllers);
			
			switch($"."view){
				case 'index':
					Genesis::renderView('".$name.".index',  $".$name."Ctrl->listAction(), 'list');
					break;
					
				case '_new':
                                                                                                            Genesis::renderView( '".$name.".form',  $".$name."Ctrl->__newAction(), 'new');
					break;
					
				case 'create':
                                                                                                            Genesis::renderView( '".$name.".form', $".$name."Ctrl->createAction(), 'error creation', true);
					break;
					
				case '_edit':
                                                                                                            Genesis::renderView( '".$name.".form',  $".$name."Ctrl->__editAction($"."_GET['id']), 'edite');
					break;
					
				case 'update':
					Genesis::renderView( '".$name.".form',  $".$name."Ctrl->updateAction($"."_GET['id']),'error updating', true);
					break;
					
				case 'show':
                                                                                                                Genesis::renderView( '".$name.".show', $".$name."Ctrl->showAction($"."_GET['id']), 'Show');
					break;
					
				case 'delete':
                                                                                                                Genesis::renderView( '".$name.".show', $".$name."Ctrl->deleteAction($"."_GET['id']), 'delete', true);
					break;
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}
		}			
			
		static function restGenesis($"."view, $"."controllers, \\".ucfirst($name)."Controller $".$name."Ctrl = null ){
			extract($"."controllers);
			
			switch($"."view){
				case 'index':
					echo json_encode($".$name."Ctrl->listAction());
					break;
					
				case 'new':
					echo json_encode($".$name."Ctrl->createAction());
					break;
					
				case 'edit':
					echo json_encode($".$name."Ctrl->editAction($"."_GET['id']));
					break;
					
				case 'show':
					echo json_encode($".$name."Ctrl->showAction($"."_GET['id']));
					break;
					
				case 'delete':
					echo json_encode($".$name."Ctrl->deleteAction($"."_GET['id']));
					break;\n\t\t
                                        
				default:
					echo 'la route n\'existe pas!';
					break;
			}  
		}
	}
		\n";
		
		$entityrooting = fopen("Genesis/" . ucfirst($name).'Genesis.php', 'w');
			
		fputs($entityrooting, $contenu);
		
		fclose($entityrooting);
	}
}