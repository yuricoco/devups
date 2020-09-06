<?php 

            
use dclass\devups\Controller\Controller;

class Dvups_moduleController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = Dvups_moduleTable::init(new Dvups_module())->buildindextable();

        self::$jsfiles[] = Dvups_module::classpath('Ressource/js/dvups_moduleCtrl.js');

        $this->entitytarget = 'Dvups_module';
        $this->title = "Manage Dvups_module";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => Dvups_moduleTable::init(new Dvups_module())->buildindextable()->getTableRest(),
        ];
        
    }

    public function createAction($dvups_module_form = null ){
        extract($_POST);

        $dvups_module = $this->form_fillingentity(new Dvups_module(), $dvups_module_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'dvups_module' => $dvups_module,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $dvups_module->__insert();
        return 	array(	'success' => true,
                        'dvups_module' => $dvups_module,
                        'tablerow' => Dvups_moduleTable::init()->buildindextable()->getSingleRowRest($dvups_module),
                        'detail' => '');

    }

    public function updateAction($id, $dvups_module_form = null){
        extract($_POST);
            
        $dvups_module = $this->form_fillingentity(new Dvups_module($id), $dvups_module_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'dvups_module' => $dvups_module,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $dvups_module->__update();
        return 	array(	'success' => true,
                        'dvups_module' => $dvups_module,
                        'tablerow' => Dvups_moduleTable::init()->buildindextable()->getSingleRowRest($dvups_module),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Dvups_module';
        $this->title = "Detail Dvups_module";

        $dvups_module = Dvups_module::find($id);

        $this->renderDetailView(
            Dvups_moduleTable::init()
                ->builddetailtable()
                ->renderentitydata($dvups_module)
        );

    }
    
    public function deleteAction($id){
      
            Dvups_module::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Dvups_module::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
