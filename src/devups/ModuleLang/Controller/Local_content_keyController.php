<?php 

            
use dclass\devups\Controller\Controller;

class Local_content_keyController extends Controller{

    public function listView($next = 1, $per_page = 10){

            $lazyloading = $this->lazyloading(new Local_content_key(), $next, $per_page);

        self::$jsfiles[] = Local_content_key::classpath('Ressource/js/local_content_keyCtrl.js');

        $this->entitytarget = 'Local_content_key';
        $this->title = "Manage Local_content_key";
        
        $this->renderListView(Local_content_keyTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Local_content_key(), $next, $per_page);
        return ['success' => true,
            'datatable' => Local_content_keyTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($local_content_key_form = null){
        extract($_POST);

        $local_content_key = $this->form_fillingentity(new Local_content_key(), $local_content_key_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'local_content_key' => $local_content_key,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $local_content_key->__insert();
        return 	array(	'success' => true,
                        'local_content_key' => $local_content_key,
                        'tablerow' => Local_content_keyTable::init()->buildindextable()->getSingleRowRest($local_content_key),
                        'detail' => '');

    }

    public function updateAction($id, $local_content_key_form = null){
        extract($_POST);
            
        $local_content_key = $this->form_fillingentity(new Local_content_key($id), $local_content_key_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'local_content_key' => $local_content_key,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $local_content_key->__update();
        return 	array(	'success' => true,
                        'local_content_key' => $local_content_key,
                        'tablerow' => Local_content_keyTable::init()->buildindextable()->getSingleRowRest($local_content_key),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Local_content_key';
        $this->title = "Detail Local_content_key";

        $local_content_key = Local_content_key::find($id);

        $this->renderDetailView(
            Local_content_keyTable::init()
                ->builddetailtable()
                ->renderentitydata($local_content_key)
        );

    }
    
    public function deleteAction($id){
      
            Local_content_key::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Local_content_key::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
