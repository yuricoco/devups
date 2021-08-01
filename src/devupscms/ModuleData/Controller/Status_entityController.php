<?php 

            
use dclass\devups\Controller\Controller;

class Status_entityController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = Status_entityTable::init(new Status_entity())->buildindextable();

        self::$jsfiles[] = Status_entity::classpath('Resource/js/status_entityCtrl.js');

        $this->entitytarget = 'Status_entity';
        $this->title = "Manage Status_entity";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => Status_entityTable::init(new Status_entity())->router()->getTableRest(),
        ];
        
    }

    public function formView($id = null)
    {
        $status_entity = new Status_entity();
        $action = Status_entity::classpath("services.php?path=status_entity.create");
        if ($id) {
            $action = Status_entity::classpath("services.php?path=status_entity.update&id=" . $id);
            $status_entity = Status_entity::find($id);
        }

        return ['success' => true,
            'form' => Status_entityForm::init($status_entity, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function createAction($status_entity_form = null ){
        extract($_POST);

        $status_entity = $this->form_fillingentity(new Status_entity(), $status_entity_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'status_entity' => $status_entity,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $status_entity->__insert();
        return 	array(	'success' => true,
                        'status_entity' => $status_entity,
                        'tablerow' => Status_entityTable::init()->router()->getSingleRowRest($status_entity),
                        'detail' => '');

    }

    public function updateAction($id, $status_entity_form = null){
        extract($_POST);
            
        $status_entity = $this->form_fillingentity(new Status_entity($id), $status_entity_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'status_entity' => $status_entity,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $status_entity->__update();
        return 	array(	'success' => true,
                        'status_entity' => $status_entity,
                        'tablerow' => Status_entityTable::init()->router()->getSingleRowRest($status_entity),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Status_entity';
        $this->title = "Detail Status_entity";

        $status_entity = Status_entity::find($id);

        $this->renderDetailView(
            Status_entityTable::init()
                ->builddetailtable()
                ->renderentitydata($status_entity)
        );

    }
    
    public function deleteAction($id){
    
        Status_entity::delete($id);
        
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Status_entity::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

}
