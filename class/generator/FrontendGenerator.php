<?php 
	class FrontendGenerator{
		
		private $traitement;
		
		function __construct(){
			$this->traitement = new Traitement();
		}
                		
		public function modulelinkGenerator($projet, $template = 'adminv1'){
			switch($template){
				case 'egestion':
					Egestion::modulelinkGenerator($projet);
				break;
				case 'adminv1':
					Adminv1::modulelinkGenerator($projet);
				break;
				case 'adminv2':
					Adminv2::modulelinkGenerator($projet);
				break;
                case 'adminv3':
                    Adminv3::modulelinkGenerator($projet);
                    break;
                default:
                    Adminv2::modulelinkGenerator($projet);
				break;
			}
		}
		
		public function layoutGenerator($module, $template = 'adminv2', $view){
			switch($template){
				case 'egestion':
					Egestion::layoutGenerator($listentity);
				    break;
				case 'adminv1':
					Adminv1::layoutGenerator($listentity);
				    break;
				case 'adminv2':
					Adminv2::layoutGenerator($module, $view);
				    break;
                case 'adminv3':
                    Adminv3::layoutGenerator($module, $view);
                    break;
                default:
                    Adminv2::layoutGenerator($module, $view);
				    break;
			}
		}
			
		public function viewsGenerator($listemodule, $entity, $template = 'adminv2', $view = ""){
			switch($template){
				case 'egestion':
					Egestion::viewsGenerator($listemodule, $entity);
				break;
				case 'adminv1':
					Adminv1::viewsGenerator($listemodule, $entity);
				break;
				case 'adminv2':
					Adminv2::viewsGenerator($listemodule, $entity, $view."/");
				break;
				case 'adminv3':
					Adminv3::viewsGenerator($listemodule, $entity, $view."/");
				break;
				default:
                    Adminv2::viewsGenerator($listemodule, $entity, $view."/");
				break;
			}
		}
	}
	