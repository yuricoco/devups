<?php 

            
use dclass\devups\Controller\Controller;

class StatusController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = StatusTable::init(new Status())->buildindextable();

        self::$cssfiles[] = __admin."plugins/jquery-ui-1.12.1/jquery-ui.min.css";
        self::$cssfiles[] = Status::classpath('Resource/css/status.css');
        self::$jsfiles[] = __admin."plugins/jquery-ui-1.12.1/jquery-ui.min.js";
        self::$jsfiles[] = Status::classpath('Resource/js/statusCtrl.js');

        $this->entitytarget = 'Status';
        $this->title = "Manage Status";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => StatusTable::init(new Status())->buildindextable()->getTableRest(),
        ];
        
    }

    public function createAction($status_form = null ){
        extract($_POST);

        $status = $this->form_fillingentity(new Status(), $status_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'status' => $status,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $status->__insert();
        return 	array(	'success' => true,
                        'status' => $status,
                        'tablerow' => StatusTable::init()->buildindextable()->getSingleRowRest($status),
                        'detail' => '');

    }

    public function updateAction($id, $status_form = null){
        extract($_POST);
            
        $status = $this->form_fillingentity(new Status($id), $status_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'status' => $status,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $status->__update();
        return 	array(	'success' => true,
                        'status' => $status,
                        'tablerow' => StatusTable::init()->buildindextable()->getSingleRowRest($status),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Status';
        $this->title = "Detail Status";

        $status = Status::find($id);

        $this->renderDetailView(
            StatusTable::init()
                ->builddetailtable()
                ->renderentitydata($status)
        );

    }
    
    public function deleteAction($id){
      
            Status::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Status::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

    public function sortlistAction()
    {
        foreach ($_POST["positions"] as $i => $id){
            Status::where("this.id", $id)->update(["position"=>$i+1]);
        }
        return Response::$data;
    }

    public function cloneAction($id){

        $status = Status::find($id);
        $status->setId(null);
        $status->__insert();
        return 	array(	'success' => true,
            'status' => $status,
            'tablerow' => StatusTable::init()->buildindextable()->getSingleRowRest($status),
            'detail' => '');

    }

}
