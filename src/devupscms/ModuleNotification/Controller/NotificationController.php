<?php 

            
use dclass\devups\Controller\Controller;

class NotificationController extends Controller{

    public function listView($next = 1, $per_page = 10){

            $lazyloading = $this->lazyloading(new Notification(), $next, $per_page);

        self::$jsfiles[] = Notification::classpath('Ressource/js/notificationCtrl.js');

        $this->entitytarget = 'Notification';
        $this->title = "Manage Notification";
        
        $this->renderListView(NotificationTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Notification(), $next, $per_page);
        return ['success' => true,
            'datatable' => NotificationTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($notification_form = null){
        extract($_POST);

        $notification = $this->form_fillingentity(new Notification(), $notification_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'notification' => $notification,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $notification->__insert();
        return 	array(	'success' => true,
                        'notification' => $notification,
                        'tablerow' => NotificationTable::init()->buildindextable()->getSingleRowRest($notification),
                        'detail' => '');

    }

    public function updateAction($id, $notification_form = null){
        extract($_POST);
            
        $notification = $this->form_fillingentity(new Notification($id), $notification_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'notification' => $notification,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $notification->__update();
        return 	array(	'success' => true,
                        'notification' => $notification,
                        'tablerow' => NotificationTable::init()->buildindextable()->getSingleRowRest($notification),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Notification';
        $this->title = "Detail Notification";

        $notification = Notification::find($id);

        $this->renderDetailView(
            NotificationTable::init()
                ->builddetailtable()
                ->renderentitydata($notification)
        );

    }
    
    public function deleteAction($id){
      
            Notification::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Notification::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
