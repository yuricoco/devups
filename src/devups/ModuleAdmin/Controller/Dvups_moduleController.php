<?php 

	class Dvups_moduleController extends Controller{
		
		private $err;
		
		function __construct() {
			$this->err = array();
		}
		
		/**
		 * retourne l'instance de l'entité ou un json pour les requete asynchrone (ajax)
		 *
		 * @param type $id
		 * @return \Array
		 */
		public  function showAction($id){
			//$dvups_moduleDao = new Dvups_moduleDAO();
			$dvups_module = (new DBAL())->findByIdDbal(new Dvups_module($id));
			
			return 	array(	'success' => true, 
                                        //'url' => 'index.php?path=dvups_module/show&id='.$id,
                                        'dvups_module' => $dvups_module,
                                        'detail' => 'detail de l\'action.');
                
		}
			
		public function createAction(){
			extract($_POST);
			$this->err = array();
			//$dvups_moduleDao = new Dvups_moduleDAO();

			$dvups_module = $this->form_generat(new Dvups_module(), $dvups_module_form);
 

			if (!array_key_exists('err', $this->err) and $id = (new DBAL())->createDbal($dvups_module)) {
				return 	array(	'success' => true, // pour le restservice
						'dvups_module' => $dvups_module,
						'url' => 'index', // pour le web service
						'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			} else {
				return 	array(	'success' => false, // pour le restservice
						'dvups_module' => $dvups_module,
						'view' => 'form', // pour le web service
						'detail' => $this->err['err']); //Detail de l'action ou message d'erreur ou de succes
			}
			
		}

		public function editAction($id){
			extract($_POST);
			$this->err = array();
			//$dvups_moduleDao = new Dvups_moduleDAO();
                            
			$dvups_module = $this->form_generat(new Dvups_module($id), $dvups_module_form);
			
			
			if (!array_key_exists('err', $this->err) and (new DBAL())->updateDbal($dvups_module)) {
				return 	array(	'success' => true, // pour le restservice
						'dvups_module' => $dvups_module,
						'url' => 'index', // pour le web service
						'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			} else {
				return 	array(	'success' => false, // pour le restservice
						'dvups_module' => $dvups_module,
						'view' => 'form', // pour le web service
						'detail' => $this->err['err']); //Detail de l'action ou message d'erreur ou de succes
			}
		}
		
		/**
		 * retourne un tableau d'instance de l'entité ou un json pour les requetes asynchrone (ajax)
		 *
		 * @param type $id
		 * @return \Array
		 */
		public function listAction(){

			$dvups_moduleDao = new Dvups_moduleDAO();
			$listDvups_module = $dvups_moduleDao->findAll();
			
			return 	array(	'success' => true, // pour le restservice
					'listDvups_module' => $listDvups_module,
					'url' => '#', // pour le web service
					'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			
		}
			 
		public function searchOneAction($x, $value = null){
			$dvups_moduleDao = new Dvups_moduleDAO();
			$dvups_module = $dvups_moduleDao->findOneElementWhereXisY($x, $value);
			
			return 	array(	'success' => true, // pour le restservice
					'dvups_module' => $dvups_module,
					'url' => '#', // pour le web service
					'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			
		}
			 
		public function searchAction($x, $value = null){
			$dvups_moduleDao = new Dvups_moduleDAO();
			$listDvups_module = $dvups_moduleDao->findElementWhereXisY($x, $value);
			
			return 	array(	'success' => true, // pour le restservice
					'listDvups_module' => $listDvups_module,
					'url' => '#', // pour le web service
					'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			
		}
		
		public function deleteAction($id){
                    
			
			if( (new DBAL())->deleteDbal(new Dvups_module($id)) )
				return 	array(	'success' => true, // pour le restservice
						'url' => 'index', // pour le web service
						'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			else
				return 	array(	'success' => false, // pour le restservice
						'url' => '#', // pour le web service
						'detail' => 'Des problèmes sont survenus lors de la suppression de l\'élément.'); //Detail de l'action ou message d'erreur ou de succes
		}
	
	}
