<?php 

            
use dclass\devups\Controller\Controller;

class Local_content_keyController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = Local_content_keyTable::init(new Local_content_key())->buildindextable();

        self::$jsfiles[] = Local_content_key::classpath('Resource/js/local_content_keyCtrl.js');

        $this->entitytarget = 'Local_content_key';
        $this->title = "Manage Local_content_key";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => Local_content_keyTable::init(new Local_content_key())->router()->getTableRest(),
        ];
        
    }

    public function formView($id = null)
    {
        $local_content_key = new Local_content_key();
        $action = Local_content_key::classpath("services.php?path=local_content_key.create");
        if ($id) {
            $action = Local_content_key::classpath("services.php?path=local_content_key.update&id=" . $id);
            $local_content_key = Local_content_key::find($id);
        }

        return ['success' => true,
            'form' => Local_content_keyForm::init($local_content_key, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function createAction($local_content_key_form = null ){
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
                        'tablerow' => Local_content_keyTable::init()->router()->getSingleRowRest($local_content_key),
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
                        'tablerow' => Local_content_keyTable::init()->router()->getSingleRowRest($local_content_key),
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

        Local_content_key::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

}
