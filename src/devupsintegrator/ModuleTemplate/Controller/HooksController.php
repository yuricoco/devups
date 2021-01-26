<?php 

            
use dclass\devups\Controller\Controller;

class HooksController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = HooksTable::init(new Hooks())->buildindextable();

        self::$jsfiles[] = Hooks::classpath('Ressource/js/hooksCtrl.js');

        $this->entitytarget = 'Hooks';
        $this->title = "Manage Hooks";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => HooksTable::init(new Hooks())->buildindextable()->getTableRest(),
        ];
        
    }

    public function createAction($hooks_form = null ){
        extract($_POST);

        $hooks = $this->form_fillingentity(new Hooks(), $hooks_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'hooks' => $hooks,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $hooks->__insert();
        return 	array(	'success' => true,
                        'hooks' => $hooks,
                        'tablerow' => HooksTable::init()->buildindextable()->getSingleRowRest($hooks),
                        'detail' => '');

    }

    public function updateAction($id, $hooks_form = null){
        extract($_POST);
            
        $hooks = $this->form_fillingentity(new Hooks($id), $hooks_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'hooks' => $hooks,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $hooks->__update();
        return 	array(	'success' => true,
                        'hooks' => $hooks,
                        'tablerow' => HooksTable::init()->buildindextable()->getSingleRowRest($hooks),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Hooks';
        $this->title = "Detail Hooks";

        $hooks = Hooks::find($id);

        $this->renderDetailView(
            HooksTable::init()
                ->builddetailtable()
                ->renderentitydata($hooks)
        );

    }
    
    public function deleteAction($id){
      
            Hooks::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Hooks::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

}
