<?php 


use DClass\devups\Datatable as Datatable;

class StorageController extends Controller{


    public static function renderFormWidget($id = null) {
        if($id)
            StorageForm::__renderFormWidget(Storage::find($id), 'update');
        else
            StorageForm::__renderFormWidget(new Storage(), 'create');
    }

    public static function renderDetail($id) {
        StorageForm::__renderDetailWidget(Storage::find($id));
    }

    public static function renderForm($id = null, $action = "create") {
        $storage = new Storage();
        if($id){
            $action = "update&id=".$id;
            $storage = Storage::find($id);
            //$storage->collectStorage();
        }

        return ['success' => true,
            'form' => StorageForm::__renderForm($storage, $action, true),
        ];
    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Storage(), $next, $per_page);
        return ['success' => true,
            'datatable' => Datatable::getTableRest($lazyloading),
        ];
    }

    public function listAction($next = 1, $per_page = 10){

        $lazyloading = $this->lazyloading(new Storage(), $next, $per_page);

        return array('success' => true, // pour le restservice
            'lazyloading' => $lazyloading, // pour le web service
            'detail' => '');

    }
    
    public  function showAction($id){

            $storage = Storage::find($id);

            return array( 'success' => true, 
                            'storage' => $storage,
                            'detail' => 'detail de l\'action.');

    }

    public function createAction($storage_form = null){
        extract($_POST);

        $storage = $this->form_fillingentity(new Storage(), $storage_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'storage' => $storage,
                            'action_form' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $storage->__insert();
        return 	array(	'success' => true,
                        'storage' => $storage,
                        'tablerow' => Datatable::getSingleRowRest($storage),
                        'detail' => '');

    }

    public function updateAction($id, $storage_form = null){
        extract($_POST);
            
        $storage = $this->form_fillingentity(new Storage($id), $storage_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'storage' => $storage,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $storage->__update();
        return 	array(	'success' => true,
                        'storage' => $storage,
                        'tablerow' => Datatable::getSingleRowRest($storage),
                        'detail' => '');
                        
    }
    
    public function deleteAction($id){
      
            Storage::delete($id);
        return 	array(	'success' => true, // pour le restservice
                        'redirect' => 'index', // pour le web service
                        'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }
    

    public function deletegroupAction($ids)
    {

        Storage::delete()->where("id")->in($ids)->exec();

        return array('success' => true, // pour le restservice
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    public function __newAction(){

        return 	array(	'success' => true, // pour le restservice
                        'storage' => new Storage(),
                        'action_form' => 'create', // pour le web service
                        'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    public function __editAction($id){

       $storage = Storage::find($id);

        return array('success' => true, // pour le restservice
                        'storage' => $storage,
                        'action_form' => 'update&id='.$id, // pour le web service
                        'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

}
