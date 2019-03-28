<?php 


use DClass\devups\Datatable as Datatable;

class Dvups_langController extends Controller{


    public static function renderFormWidget($id = null) {
        if($id)
            Dvups_langForm::__renderFormWidget(Dvups_lang::find($id), 'update');
        else
            Dvups_langForm::__renderFormWidget(new Dvups_lang(), 'create');
    }

    public static function renderDetail($id) {
        Dvups_langForm::__renderDetailWidget(Dvups_lang::find($id));
    }

    public static function renderForm($id = null, $action = "create") {
        $dvups_lang = new Dvups_lang();
        if($id){
            $action = "update&id=".$id;
            $dvups_lang = Dvups_lang::find($id);
            //$dvups_lang->collectStorage();
        }

        return ['success' => true,
            'form' => Dvups_langForm::__renderForm($dvups_lang, $action, true),
        ];
    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Dvups_lang(), $next, $per_page);
        return ['success' => true,
            'tablebody' => Datatable::getTableRest($lazyloading),
            'tablepagination' => Datatable::pagination($lazyloading)
        ];
    }

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
			  
            Dvups_lang::delete($id);
                return 	array(	'success' => true, // pour le restservice
                                'redirect' => 'index', // pour le web service
                                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
            }
            

            public function deletegroupAction($ids)
            {
        
                Dvups_lang::delete()->where("id")->in($ids)->exec();
        
                return array('success' => true, // pour le restservice
                        'redirect' => 'index', // pour le web service
                        'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        
            }

            public function __newAction(){

                    return 	array(	'success' => true, // pour le restservice
                                    'dvups_lang' => new Dvups_lang(),
                                    'action_form' => 'create', // pour le web service
                                    'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

            }

            public function __editAction($id){

                   $dvups_lang = Dvups_lang::find($id);

                    return array('success' => true, // pour le restservice
                                    'dvups_lang' => $dvups_lang,
                                    'action_form' => 'update&id='.$id, // pour le web service
                                    'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

            }

	}
