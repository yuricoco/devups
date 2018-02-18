<?php 

	class Dvups_entityController extends Controller{
		
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
			//$dvups_entityDao = new Dvups_entityDAO();
			$dvups_entity = (new DBAL())->findByIdDbal(new Dvups_entity($id));
			
			return 	array(	'success' => true, 
                                        //'url' => 'index.php?path=dvups_entity/show&id='.$id,
                                        'dvups_entity' => $dvups_entity,
                                        'detail' => 'detail de l\'action.');
                
		}
			
		public function createAction(){
			extract($_POST);
			$this->err = array();
			//$dvups_entityDao = new Dvups_entityDAO();

			$dvups_entity = $this->form_generat(new Dvups_entity(), $dvups_entity_form);
 

			if (!array_key_exists('err', $this->err) and $id = (new DBAL())->createDbal($dvups_entity)) {
				return 	array(	'success' => true, // pour le restservice
						'dvups_entity' => $dvups_entity,
						'url' => 'index', // pour le web service
						'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			} else {
				return 	array(	'success' => false, // pour le restservice
						'dvups_entity' => $dvups_entity,
						'view' => 'form', // pour le web service
						'detail' => $this->err['err']); //Detail de l'action ou message d'erreur ou de succes
			}
			
		}

		public function editAction($id){
			extract($_POST);
			$this->err = array();
			//$dvups_entityDao = new Dvups_entityDAO();
                            
			$dvups_entity = $this->form_generat(new Dvups_entity($id), $dvups_entity_form);
			
			
			if (!array_key_exists('err', $this->err) and (new DBAL())->updateDbal($dvups_entity)) {
				return 	array(	'success' => true, // pour le restservice
						'dvups_entity' => $dvups_entity,
						'url' => 'index', // pour le web service
						'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			} else {
				return 	array(	'success' => false, // pour le restservice
						'dvups_entity' => $dvups_entity,
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

			$dvups_entityDao = new Dvups_entityDAO();
			$listDvups_entity = $dvups_entityDao->findAll();
			
			return 	array(	'success' => true, // pour le restservice
					'listDvups_entity' => $listDvups_entity,
					'url' => '#', // pour le web service
					'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			
		}
			 
		public function searchOneAction($x, $value = null){
			$dvups_entityDao = new Dvups_entityDAO();
			$dvups_entity = $dvups_entityDao->findOneElementWhereXisY($x, $value);
			
			return 	array(	'success' => true, // pour le restservice
					'dvups_entity' => $dvups_entity,
					'url' => '#', // pour le web service
					'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			
		}
			 
		public function searchAction($x, $value = null){
			$dvups_entityDao = new Dvups_entityDAO();
			$listDvups_entity = $dvups_entityDao->findElementWhereXisY($x, $value);
			
			return 	array(	'success' => true, // pour le restservice
					'listDvups_entity' => $listDvups_entity,
					'url' => '#', // pour le web service
					'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			
		}
		
		public function deleteAction($id){
                    
			
			if( (new DBAL())->deleteDbal(new Dvups_entity($id)) )
				return 	array(	'success' => true, // pour le restservice
						'url' => 'index', // pour le web service
						'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			else
				return 	array(	'success' => false, // pour le restservice
						'url' => '#', // pour le web service
						'detail' => 'Des problèmes sont survenus lors de la suppression de l\'élément.'); //Detail de l'action ou message d'erreur ou de succes
		}
	
	}
