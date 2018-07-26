<?php 

    class Dvups_rightController extends Controller{

            /**
             * retourne l'instance de l'entité ou un json pour les requete asynchrone (ajax)
             *
             * @param type $id
             * @return \Array
             */
            public  function showAction($id){

                    $dvups_right = Dvups_right::find($id);

                    return array( 'success' => true, 
                                    'dvups_right' => $dvups_right,
                                    'detail' => 'detail de l\'action.');

            }

            /**
             * Data for creation form
             * @Sequences: controller - genesis - ressource/view/form
             * @return \Array
            */
            public function __newAction(){

                    return 	array(	'success' => true, // pour le restservice
                                    'dvups_right' => new Dvups_right(),
                                    'action_form' => 'create', // pour le web service
                                    'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

            }

            /**
             * Action on creation form
             * @Sequences: controller - genesis - ressource/view/form
             * @return \Array
            */
            public function createAction(){
                    extract($_POST);
                    $this->err = array();

                    $dvups_right = $this->form_generat(new Dvups_right(), $dvups_right_form);
 

                    if ( $id = $dvups_right->__insert()) {
                            return 	array(	'success' => true, // pour le restservice
                                            'dvups_right' => $dvups_right,
                                            'redirect' => 'index', // pour le web service
                                            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
                    } else {
                            return 	array(	'success' => false, // pour le restservice
                                            'dvups_right' => $dvups_right,
                                            'action_form' => 'create', // pour le web service
                                            'detail' => 'error data not persisted'); //Detail de l'action ou message d'erreur ou de succes
                    }

            }

            /**
             * Data for edit form
             * @Sequences: controller - genesis - ressource/view/form
             * @param type $id
             * @return \Array
                                         */ 
            public function __editAction($id){

                   $dvups_right = Dvups_right::find($id);

                    return array('success' => true, // pour le restservice
                                    'dvups_right' => $dvups_right,
                                    'action_form' => 'update&id='.$id, // pour le web service
                                    'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

            }

            /**
             * Action on edit form
             * @Sequences: controller - genesis - ressource/view/index
             * @param type $id
             * @return \Array
            */
            public function updateAction($id){
                    extract($_POST);
                        
                    $dvups_right = $this->form_generat(new Dvups_right($id), $dvups_right_form);

                    
                    if ($dvups_right->__update()) {
                            return 	array('success' => true, // pour le restservice
                                            'dvups_right' => $dvups_right,
                                            'redirect' => 'index', // pour le web service
                                            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
                    } else {
                            return 	array('success' => false, // pour le restservice
                                            'dvups_right' => $dvups_right,
                                            'action_form' => 'update&id='.$id, // pour le web service
                                            'detail' => 'error data not updated'); //Detail de l'action ou message d'erreur ou de succes
                    }
            }

            /**
             * 
             *
             * @param type $id
             * @return \Array
             */
            public function listAction($next = 1, $per_page = 10){

                $lazyloading = $this->lazyloading(new Dvups_right(), $next, $per_page);

                return array('success' => true, // pour le restservice
                    'lazyloading' => $lazyloading, // pour le web service
                    'detail' => '');

            }

            public function deleteAction($id){

                    $dvups_right = Dvups_right::find($id);

			
                    if( $dvups_right->__delete() )
                            return 	array(	'success' => true, // pour le restservice
                                            'redirect' => 'index', // pour le web service
                                            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
                    else
                            return 	array(	'success' => false, // pour le restservice
                                                                                                                        'dvups_right' => $dvups_right,
                                            'detail' => 'Des problèmes sont survenus lors de la suppression de l\'élément.'); //Detail de l'action ou message d'erreur ou de succes
            }

	}
