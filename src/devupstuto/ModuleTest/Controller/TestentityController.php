<?php 


use DClass\devups\Datatable as Datatable;

class TestentityController extends Controller{


    public static function renderFormWidget($id = null) {
        if($id)
            TestentityForm::__renderFormWidget(Testentity::find($id), 'update');
        else
            TestentityForm::__renderFormWidget(new Testentity(), 'create');
    }

    public static function renderDetail($id) {
        TestentityForm::__renderDetailWidget(Testentity::find($id));
    }

    public static function renderForm($id = null, $action = "create") {
        $testentity = new Testentity();
        if($id){
            $action = "update&id=".$id;
            $testentity = Testentity::find($id);
            //$testentity->collectStorage();
        }

        return ['success' => true,
            'form' => TestentityForm::__renderForm($testentity, $action, true),
        ];
    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Testentity(), $next, $per_page);
        return ['success' => true,
            'tablebody' => Datatable::getTableRest($lazyloading),
            'tablepagination' => Datatable::pagination($lazyloading)
        ];
    }

    public function listAction($next = 1, $per_page = 10){

        $lazyloading = $this->lazyloading(new Testentity(), $next, $per_page);

        return array('success' => true, // pour le restservice
            'lazyloading' => $lazyloading, // pour le web service
            'detail' => '');

    }
    
    public  function showAction($id){

            $testentity = Testentity::find($id);

            return array( 'success' => true, 
                            'testentity' => $testentity,
                            'detail' => 'detail de l\'action.');

    }

    public function createAction(){
        extract($_POST);
        $this->err = array();

        $testentity = $this->form_generat(new Testentity(), $testentity_form);
 

        if ( $id = $testentity->__insert()) {
            return 	array(	'success' => true, // pour le restservice
                            'testentity' => $testentity,
                            'tablerow' => Datatable::getSingleRowRest($testentity),
                            'redirect' => 'index', // pour le web service
                            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return 	array(	'success' => false, // pour le restservice
                            'testentity' => $testentity,
                            'action_form' => 'create', // pour le web service
                            'detail' => 'error data not persisted'); //Detail de l'action ou message d'erreur ou de succes
        }

    }

    public function updateAction($id){
        extract($_POST);
            
        $testentity = $this->form_generat(new Testentity($id), $testentity_form);

            
        if ($testentity->__update()) {
            return 	array('success' => true, // pour le restservice
                            'testentity' => $testentity,
                            'id' => $id,
                            'tablerow' => Datatable::getSingleRowRest($testentity),
                            'redirect' => 'index', // pour le web service
                            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return 	array('success' => false, // pour le restservice
                            'testentity' => $testentity,
                            'action_form' => 'update&id='.$id, // pour le web service
                            'detail' => 'error data not updated'); //Detail de l'action ou message d'erreur ou de succes
        }
    }
    
    public function deleteAction($id){
      
            Testentity::delete($id);
        return 	array(	'success' => true, // pour le restservice
                        'redirect' => 'index', // pour le web service
                        'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }
    

    public function deletegroupAction($ids)
    {

        Testentity::delete()->where("id")->in($ids)->exec();

        return array('success' => true, // pour le restservice
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    public function __newAction(){

        return 	array(	'success' => true, // pour le restservice
                        'testentity' => new Testentity(),
                        'action_form' => 'create', // pour le web service
                        'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    public function __editAction($id){

       $testentity = Testentity::find($id);

        return array('success' => true, // pour le restservice
                        'testentity' => $testentity,
                        'action_form' => 'update&id='.$id, // pour le web service
                        'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

}
