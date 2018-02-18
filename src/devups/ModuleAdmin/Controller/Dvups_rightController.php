<?php 

	class Dvups_rightController extends Controller{
		
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
			//$dvups_rightDao = new Dvups_rightDAO();
			$dvups_right = (new DBAL())->findByIdDbal(new Dvups_right($id));
			
			return 	array(	'success' => true, 
                                        //'url' => 'index.php?path=dvups_right/show&id='.$id,
                                        'dvups_right' => $dvups_right,
                                        'detail' => 'detail de l\'action.');
                
		}
			
		public function createAction(){
			extract($_POST);
			$this->err = array();
			//$dvups_rightDao = new Dvups_rightDAO();

			$dvups_right = $this->form_generat(new Dvups_right(), $dvups_right_form);
 

			if (!array_key_exists('err', $this->err) and $id = (new DBAL())->createDbal($dvups_right)) {
				return 	array(	'success' => true, // pour le restservice
						'dvups_right' => $dvups_right,
						'url' => 'index', // pour le web service
						'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			} else {
				return 	array(	'success' => false, // pour le restservice
						'dvups_right' => $dvups_right,
						'view' => 'form', // pour le web service
						'detail' => $this->err['err']); //Detail de l'action ou message d'erreur ou de succes
			}
			
		}

		public function editAction($id){
			extract($_POST);
			$this->err = array();
			//$dvups_rightDao = new Dvups_rightDAO();
                            
			$dvups_right = $this->form_generat(new Dvups_right($id), $dvups_right_form);
			
			
			if (!array_key_exists('err', $this->err) and (new DBAL())->updateDbal($dvups_right)) {
				return 	array(	'success' => true, // pour le restservice
						'dvups_right' => $dvups_right,
						'url' => 'index', // pour le web service
						'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			} else {
				return 	array(	'success' => false, // pour le restservice
						'dvups_right' => $dvups_right,
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

			$dvups_rightDao = new Dvups_rightDAO();
			$listDvups_right = $dvups_rightDao->findAll();
			
			return 	array(	'success' => true, // pour le restservice
					'listDvups_right' => $listDvups_right,
					'url' => '#', // pour le web service
					'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			
		}
			 
		public function searchOneAction($x, $value = null){
			$dvups_rightDao = new Dvups_rightDAO();
			$dvups_right = $dvups_rightDao->findOneElementWhereXisY($x, $value);
			
			return 	array(	'success' => true, // pour le restservice
					'dvups_right' => $dvups_right,
					'url' => '#', // pour le web service
					'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			
		}
			 
		public function searchAction($x, $value = null){
			$dvups_rightDao = new Dvups_rightDAO();
			$listDvups_right = $dvups_rightDao->findElementWhereXisY($x, $value);
			
			return 	array(	'success' => true, // pour le restservice
					'listDvups_right' => $listDvups_right,
					'url' => '#', // pour le web service
					'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			
		}
		
		public function deleteAction($id){
                    
			
			if( (new DBAL())->deleteDbal(new Dvups_right($id)) )
				return 	array(	'success' => true, // pour le restservice
						'url' => 'index', // pour le web service
						'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
			else
				return 	array(	'success' => false, // pour le restservice
						'url' => '#', // pour le web service
						'detail' => 'Des problèmes sont survenus lors de la suppression de l\'élément.'); //Detail de l'action ou message d'erreur ou de succes
		}
	
	}
