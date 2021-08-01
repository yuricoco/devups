<?php 

            
use dclass\devups\Controller\Controller;

class NotificationbroadcastedController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = NotificationbroadcastedTable::init(new Notificationbroadcasted())->buildindextable();

        self::$jsfiles[] = Notificationbroadcasted::classpath('Resource/js/notificationbroadcastedCtrl.js');

        $this->entitytarget = 'Notificationbroadcasted';
        $this->title = "Manage Notificationbroadcasted";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => NotificationbroadcastedTable::init(new Notificationbroadcasted())->router()->getTableRest(),
        ];
        
    }

    public function formView($id = null)
    {
        $notificationbroadcasted = new Notificationbroadcasted();
        $action = Notificationbroadcasted::classpath("services.php?path=notificationbroadcasted.create");
        if ($id) {
            $action = Notificationbroadcasted::classpath("services.php?path=notificationbroadcasted.update&id=" . $id);
            $notificationbroadcasted = Notificationbroadcasted::find($id);
        }

        return ['success' => true,
            'form' => NotificationbroadcastedForm::init($notificationbroadcasted, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function createAction($notificationbroadcasted_form = null ){
        extract($_POST);

        $notificationbroadcasted = $this->form_fillingentity(new Notificationbroadcasted(), $notificationbroadcasted_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'notificationbroadcasted' => $notificationbroadcasted,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $notificationbroadcasted->__insert();
        return 	array(	'success' => true,
                        'notificationbroadcasted' => $notificationbroadcasted,
                        'tablerow' => NotificationbroadcastedTable::init()->router()->getSingleRowRest($notificationbroadcasted),
                        'detail' => '');

    }

    public function updateAction($id, $notificationbroadcasted_form = null){
        extract($_POST);
            
        $notificationbroadcasted = $this->form_fillingentity(new Notificationbroadcasted($id), $notificationbroadcasted_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'notificationbroadcasted' => $notificationbroadcasted,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $notificationbroadcasted->__update();
        return 	array(	'success' => true,
                        'notificationbroadcasted' => $notificationbroadcasted,
                        'tablerow' => NotificationbroadcastedTable::init()->router()->getSingleRowRest($notificationbroadcasted),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Notificationbroadcasted';
        $this->title = "Detail Notificationbroadcasted";

        $notificationbroadcasted = Notificationbroadcasted::find($id);

        $this->renderDetailView(
            NotificationbroadcastedTable::init()
                ->builddetailtable()
                ->renderentitydata($notificationbroadcasted)
        );

    }
    
    public function deleteAction($id){
    
        Notificationbroadcasted::delete($id);
        
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Notificationbroadcasted::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

}
