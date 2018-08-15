<?php 

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
            'tablebody' => Genesis::getTableRest($lazyloading)
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

            public function updateAction($id){
                    extract($_POST);
                        
                    $storage = $this->form_generat(new Storage($id), $storage_form);

                    
                    if ($storage->__update()) {
                            return 	array('success' => true, // pour le restservice
                                            'storage' => $storage,
                                            'redirect' => 'index', // pour le web service
                                            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
                    } else {
                            return 	array('success' => false, // pour le restservice
                                            'storage' => $storage,
                                            'action_form' => 'update&id='.$id, // pour le web service
                                            'detail' => 'error data not updated'); //Detail de l'action ou message d'erreur ou de succes
                    }
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
