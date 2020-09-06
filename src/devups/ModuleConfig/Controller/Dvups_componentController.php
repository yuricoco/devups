<?php 

            
use dclass\devups\Controller\Controller;

class Dvups_componentController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = Dvups_componentTable::init(new Dvups_component())->buildindextable();

        self::$jsfiles[] = Dvups_component::classpath('Ressource/js/dvups_componentCtrl.js');

        $this->entitytarget = 'Dvups_component';
        $this->title = "Manage Dvups_component";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => Dvups_componentTable::init(new Dvups_component())->buildindextable()->getTableRest(),
        ];
        
    }

    public function createAction($dvups_component_form = null ){
        extract($_POST);

        $dvups_component = $this->form_fillingentity(new Dvups_component(), $dvups_component_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'dvups_component' => $dvups_component,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $dvups_component->__insert();
        return 	array(	'success' => true,
                        'dvups_component' => $dvups_component,
                        'tablerow' => Dvups_componentTable::init()->buildindextable()->getSingleRowRest($dvups_component),
                        'detail' => '');

    }

    public function updateAction($id, $dvups_component_form = null){
        extract($_POST);
            
        $dvups_component = $this->form_fillingentity(new Dvups_component($id), $dvups_component_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'dvups_component' => $dvups_component,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $dvups_component->__update();
        return 	array(	'success' => true,
                        'dvups_component' => $dvups_component,
                        'tablerow' => Dvups_componentTable::init()->buildindextable()->getSingleRowRest($dvups_component),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Dvups_component';
        $this->title = "Detail Dvups_component";

        $dvups_component = Dvups_component::find($id);

        $this->renderDetailView(
            Dvups_componentTable::init()
                ->builddetailtable()
                ->renderentitydata($dvups_component)
        );

    }
    
    public function deleteAction($id){
      
            Dvups_component::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Dvups_component::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
