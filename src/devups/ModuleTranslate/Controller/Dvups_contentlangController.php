<?php 


use DClass\devups\Datatable as Datatable;

class Dvups_contentlangController extends Controller{


    public static function renderFormWidget($id = null) {
        if($id)
            Dvups_contentlangForm::__renderFormWidget(Dvups_contentlang::find($id), 'update');
        else
            Dvups_contentlangForm::__renderFormWidget(new Dvups_contentlang(), 'create');
    }

    public static function renderDetail($id) {
        Dvups_contentlangForm::__renderDetailWidget(Dvups_contentlang::find($id));
    }

    public static function renderForm($id = null, $action = "create") {
        $dvups_contentlang = new Dvups_contentlang();
        if($id){
            $action = "update&id=".$id;
            $dvups_contentlang = Dvups_contentlang::find($id);
            //$dvups_contentlang->collectStorage();
        }

        return ['success' => true,
            'form' => Dvups_contentlangForm::__renderForm($dvups_contentlang, $action, true),
        ];
    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Dvups_contentlang(), $next, $per_page);
        return ['success' => true,
            'tablebody' => Datatable::getTableRest($lazyloading),
            'tablepagination' => Datatable::pagination($lazyloading)
        ];
    }

            public function listAction($next = 1, $per_page = 10){

                $lazyloading = $this->lazyloading(new Dvups_contentlang(), $next, $per_page);

                return array('success' => true, // pour le restservice
                    'lazyloading' => $lazyloading, // pour le web service
                    'detail' => '');

            }
            
            public  function showAction($id){

                    $dvups_contentlang = Dvups_contentlang::find($id);

                    return array( 'success' => true, 
                                    'dvups_contentlang' => $dvups_contentlang,
                                    'detail' => 'detail de l\'action.');

            }

            public function createAction(){
                    extract($_POST);
                    $this->err = array();

                    $dvups_contentlang = $this->form_generat(new Dvups_contentlang(), $dvups_contentlang_form);
 

                    if ( $id = $dvups_contentlang->__insert()) {
                            return 	array(	'success' => true, // pour le restservice
                                            'dvups_contentlang' => $dvups_contentlang,
                                            'redirect' => 'index', // pour le web service
                                            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
                    } else {
                            return 	array(	'success' => false, // pour le restservice
                                            'dvups_contentlang' => $dvups_contentlang,
                                            'action_form' => 'create', // pour le web service
                                            'detail' => 'error data not persisted'); //Detail de l'action ou message d'erreur ou de succes
                    }

            }

            public function updateAction($id){
                    extract($_POST);
                        
                    $dvups_contentlang = $this->form_generat(new Dvups_contentlang($id), $dvups_contentlang_form);

                    
                    if ($dvups_contentlang->__update()) {
                            return 	array('success' => true, // pour le restservice
                                            'dvups_contentlang' => $dvups_contentlang,
                                            'redirect' => 'index', // pour le web service
                                            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
                    } else {
                            return 	array('success' => false, // pour le restservice
                                            'dvups_contentlang' => $dvups_contentlang,
                                            'action_form' => 'update&id='.$id, // pour le web service
                                            'detail' => 'error data not updated'); //Detail de l'action ou message d'erreur ou de succes
                    }
            }
            
            public function deleteAction($id){
			
                return 	array(	'success' => true, // pour le restservice
                                'redirect' => 'index', // pour le web service
                                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
            }
            

            public function deletegroupAction($ids)
            {
        
                Dvups_contentlang::delete()->where("id")->in($ids)->exec();
        
                return array('success' => true, // pour le restservice
                        'redirect' => 'index', // pour le web service
                        'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        
            }

            public function __newAction(){

                    return 	array(	'success' => true, // pour le restservice
                                    'dvups_contentlang' => new Dvups_contentlang(),
                                    'action_form' => 'create', // pour le web service
                                    'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

            }

            public function __editAction($id){

                   $dvups_contentlang = Dvups_contentlang::find($id);

                    return array('success' => true, // pour le restservice
                                    'dvups_contentlang' => $dvups_contentlang,
                                    'action_form' => 'update&id='.$id, // pour le web service
                                    'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

            }

	}
