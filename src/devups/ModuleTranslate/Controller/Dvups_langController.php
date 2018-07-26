<?php 

    class Dvups_langController extends Controller{


            public function listAction($next = 1, $per_page = 10){

                $lazyloading = $this->lazyloading(new Dvups_lang(), $next, $per_page);

                return array('success' => true, // pour le restservice
                    'lazyloading' => $lazyloading, // pour le web service
                    'detail' => '');

            }
            
            public  function showAction($id){

                    $dvups_lang = Dvups_lang::find($id);

                    return array( 'success' => true, 
                                    'dvups_lang' => $dvups_lang,
                                    'detail' => 'detail de l\'action.');

            }

            public function __newAction(){

                    return 	array(	'success' => true, // pour le restservice
                                    'dvups_lang' => new Dvups_lang(),
                                    'action_form' => 'create', // pour le web service
                                    'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

            }

            public function createAction(){
                    extract($_POST);
                    $this->err = array();

                    $dvups_lang = $this->form_generat(new Dvups_lang(), $dvups_lang_form);
 

                    if ( $id = $dvups_lang->__insert()) {
                            return 	array(	'success' => true, // pour le restservice
                                            'dvups_lang' => $dvups_lang,
                                            'redirect' => 'index', // pour le web service
                                            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
                    } else {
                            return 	array(	'success' => false, // pour le restservice
                                            'dvups_lang' => $dvups_lang,
                                            'action_form' => 'create', // pour le web service
                                            'detail' => 'error data not persisted'); //Detail de l'action ou message d'erreur ou de succes
                    }

            }

            public function __editAction($id){

                   $dvups_lang = Dvups_lang::find($id);

                    return array('success' => true, // pour le restservice
                                    'dvups_lang' => $dvups_lang,
                                    'action_form' => 'update&id='.$id, // pour le web service
                                    'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

            }

            public function updateAction($id){
                    extract($_POST);
                        
                    $dvups_lang = $this->form_generat(new Dvups_lang($id), $dvups_lang_form);

                    
                    if ($dvups_lang->__update()) {
                            return 	array('success' => true, // pour le restservice
                                            'dvups_lang' => $dvups_lang,
                                            'redirect' => 'index', // pour le web service
                                            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
                    } else {
                            return 	array('success' => false, // pour le restservice
                                            'dvups_lang' => $dvups_lang,
                                            'action_form' => 'update&id='.$id, // pour le web service
                                            'detail' => 'error data not updated'); //Detail de l'action ou message d'erreur ou de succes
                    }
            }

            public function deleteAction($id){

                    $dvups_lang = Dvups_lang::find($id);

			
                    if( $dvups_lang->__delete() )
                            return 	array(	'success' => true, // pour le restservice
                                            'redirect' => 'index', // pour le web service
                                            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
                    else
                            return 	array(	'success' => false, // pour le restservice
                                                                                                                        'dvups_lang' => $dvups_lang,
                                            'detail' => 'Des problèmes sont survenus lors de la suppression de l\'élément.'); //Detail de l'action ou message d'erreur ou de succes
            }

	}
