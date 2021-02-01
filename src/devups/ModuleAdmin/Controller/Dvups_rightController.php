<?php


use dclass\devups\Controller\Controller;
use dclass\devups\Datatable\Datatable;

class Dvups_rightController extends Controller{


    public static function renderFormWidget($id = null) {
        if($id)
            Dvups_rightForm::__renderFormWidget(Dvups_right::find($id), 'update');
        else
            Dvups_rightForm::__renderFormWidget(new Dvups_right(), 'create');
    }

    public static function renderDetail($id) {
        Dvups_rightForm::__renderDetailWidget(Dvups_right::find($id));
    }

    public static function renderForm($id = null, $action = "create") {
        $dvups_right = new Dvups_right();
        if($id){
            $action = "update&id=".$id;
            $dvups_right = Dvups_right::find($id);
            //$dvups_right->collectStorage();
        }

        return ['success' => true,
            'form' => Dvups_rightForm::__renderForm($dvups_right, $action, true),
        ];
    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Dvups_right(), $next, $per_page);
        return ['success' => true,
            'tablebody' => Datatable::getTableRest($lazyloading),
            'tablepagination' => Datatable::pagination($lazyloading)
        ];
    }

            public function listAction($next = 1, $per_page = 10){

                $lazyloading = $this->lazyloading(new Dvups_right(), $next, $per_page);

                return array('success' => true, // pour le restservice
                    'lazyloading' => $lazyloading, // pour le web service
                    'detail' => '');

            }
            
            public  function showAction($id){

                    $dvups_right = Dvups_right::find($id);

                    return array( 'success' => true, 
                                    'dvups_right' => $dvups_right,
                                    'detail' => 'detail de l\'action.');

            }

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
            
            public function deleteAction($id){
			  
            Dvups_right::delete($id);
                return 	array(	'success' => true, // pour le restservice
                                'redirect' => 'index', // pour le web service
                                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
            }
            

            public function deletegroupAction($ids)
            {
        
                Dvups_right::delete()->where("id")->in($ids)->exec();
        
                return array('success' => true, // pour le restservice
                        'redirect' => 'index', // pour le web service
                        'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        
            }

            public function __newAction(){

                    return 	array(	'success' => true, // pour le restservice
                                    'dvups_right' => new Dvups_right(),
                                    'action_form' => 'create', // pour le web service
                                    'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

            }

            public function __editAction($id){

                   $dvups_right = Dvups_right::find($id);

                    return array('success' => true, // pour le restservice
                                    'dvups_right' => $dvups_right,
                                    'action_form' => 'update&id='.$id, // pour le web service
                                    'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

            }

    public function listView($next = 1, $per_page = 10)
    {
        // TODO: Implement listView() method.
    }
}
