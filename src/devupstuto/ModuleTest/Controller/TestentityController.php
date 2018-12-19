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
            'datatable' => Datatable::getTableRest($lazyloading),
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

    public function createAction($testentity_form = null){
        extract($_POST);

        $testentity = $this->form_fillingentity(new Testentity(), $testentity_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'testentity' => $testentity,
                            'action_form' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $testentity->__insert();
        return 	array(	'success' => true,
                        'testentity' => $testentity,
                        'tablerow' => Datatable::getSingleRowRest($testentity),
                        'redirect' => 'index',
                        'detail' => '');

    }

    public function updateAction($id, $testentity_form = null){
        extract($_POST);
            
        $testentity = $this->form_fillingentity(new Testentity($id), $testentity_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'testentity' => $testentity,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $testentity->__update();
        return 	array(	'success' => true,
                        'testentity' => $testentity,
                        'tablerow' => Datatable::getSingleRowRest($testentity),
                        'redirect' => 'index',
                        'detail' => '');
                        
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
