<?php 

    class StorageController extends Controller{

            /**
             * retourne l'instance de l'entité ou un json pour les requete asynchrone (ajax)
             *
             * @param type $id
             * @return \Array
             */
            public  function showAction($id){
                
                     $storage = Storage::find($id);

                    return array( 'success' => true, 
                                    'storage' => $storage,
                                    'detail' => 'detail de l\'action.');

            }

                                        /**
                                         * Data for creation form
                                         * @Sequences: controller - genesis - ressource/view/form
             * @return \Array
                                         */
            public function __newAction(){

                    return 	array(	'success' => true, // pour le restservice
                                    'storage' => new Storage(),
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

                    $storage = $this->form_generat(new Storage(), $storage_form);
 

                    if ( $id = $storage->__insert()) {
                            return 	array(	'success' => true, // pour le restservice
                                            'storage' => $storage,
                                            'redirect' => 'index', // pour le web service
                                            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
                    } else {
                            return 	array(	'success' => false, // pour le restservice
                                            'storage' => $storage,
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
                
                     $storage = Storage::find($id);

                    return array('success' => true, // pour le restservice
                                    'storage' => $storage,
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
                    $this->err = array();

                    $storage = $this->form_generat(new Storage($id), $storage_form);

                    
                    if ($storage->__update()) {
                            return 	array(	'success' => true,
                                            'storage' => $storage,
                                            'redirect' => 'index', 
                                            'detail' => ''); 
                    } else {
                            return 	array(	'success' => false,
                                            'storage' => $storage,
                                            'action_form' => 'update&id='.$id, 
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
                
                    $lazyloading = $this->lazyloading(new Storage(), $next, $per_page);
        
                    return array('success' => true, // pour le restservice
                        'lazyloading' => $lazyloading, // pour le web service
                        'detail' => '');

            }

            public function deleteAction($id){

                     $storage = Storage::find($id);                                       
                    
                    if( $storage->__delete() )
                            return 	array(	'success' => true, // pour le restservice
                                            'redirect' => 'index', // pour le web service
                                            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
                    else
                            return 	array(	'success' => false, // pour le restservice
                                                                                                                        'storage' => $storage,
                                            'detail' => 'Des problèmes sont survenus lors de la suppression de l\'élément.'); //Detail de l'action ou message d'erreur ou de succes
            }

    }
