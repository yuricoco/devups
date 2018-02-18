<?php 

    class ImageController extends Controller{

            /**
             * retourne l'instance de l'entité ou un json pour les requete asynchrone (ajax)
             *
             * @param type $id
             * @return \Array
             */
            public  function showAction($id){
                
                     $image = Image::find($id);

                    return array( 'success' => true, 
                                    'image' => $image,
                                    'detail' => 'detail de l\'action.');

            }

                                        /**
                                         * Data for creation form
                                         * @Sequences: controller - genesis - ressource/view/form
             * @return \Array
                                         */
            public function __newAction(){

                    return 	array(	'success' => true, // pour le restservice
                                    'image' => new Image(),
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

                    $image = $this->form_generat(new Image(), $image_form);
 
 
                        UploadFile::__FILE_SANITIZE($image, 'image');
                        
                    if ( $id = $image->__insert()) {
                            return 	array(	'success' => true, // pour le restservice
                                            'image' => $image,
                                            'redirect' => 'index', // pour le web service
                                            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
                    } else {
                            return 	array(	'success' => false, // pour le restservice
                                            'image' => $image,
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
                
                     $image = Image::find($id);

                    return array('success' => true, // pour le restservice
                                    'image' => $image,
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

                    $image = $this->form_generat(new Image($id), $image_form);

                     
                        UploadFile::__FILE_SANITIZE($image, 'image');

                    if ($image->__update()) {
                            return 	array(	'success' => true,
                                            'image' => $image,
                                            'redirect' => 'index', 
                                            'detail' => ''); 
                    } else {
                            return 	array(	'success' => false,
                                            'image' => $image,
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
                
                    $lazyloading = $this->lazyloading(new Image(), $next, $per_page);
        
                    return array('success' => true, // pour le restservice
                        'lazyloading' => $lazyloading, // pour le web service
                        'detail' => '');

            }

            public function deleteAction($id){

                     $image = Image::find($id);                                       
                     
                        $image->deleteFile($image->getImage(), 'image');
                    if( $image->__delete() )
                            return 	array(	'success' => true, // pour le restservice
                                            'redirect' => 'index', // pour le web service
                                            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
                    else
                            return 	array(	'success' => false, // pour le restservice
                                                                                                                        'image' => $image,
                                            'detail' => 'Des problèmes sont survenus lors de la suppression de l\'élément.'); //Detail de l'action ou message d'erreur ou de succes
            }

    }
