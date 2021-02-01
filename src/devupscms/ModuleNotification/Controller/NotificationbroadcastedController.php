<?php 

            
use dclass\devups\Controller\Controller;

class NotificationbroadcastedController extends Controller{

    public function listView($next = 1, $per_page = 10){

            $lazyloading = $this->lazyloading(new Notificationbroadcasted(), $next, $per_page);

        self::$jsfiles[] = Notificationbroadcasted::classpath('Ressource/js/notificationbroadcastedCtrl.js');

        $this->entitytarget = 'Notificationbroadcasted';
        $this->title = "Manage Notificationbroadcasted";
        
        $this->renderListView(NotificationbroadcastedTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Notificationbroadcasted(), $next, $per_page);
        return ['success' => true,
            'datatable' => NotificationbroadcastedTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($notificationbroadcasted_form = null){
        extract($_POST);

        $notificationbroadcasted = $this->form_fillingentity(new Notificationbroadcasted(), $notificationbroadcasted_form);
 

        $notificationbroadcasted->setViewedat(new DateTime());

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'notificationbroadcasted' => $notificationbroadcasted,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $notificationbroadcasted->__insert();
        return 	array(	'success' => true,
                        'notificationbroadcasted' => $notificationbroadcasted,
                        'tablerow' => NotificationbroadcastedTable::init()->buildindextable()->getSingleRowRest($notificationbroadcasted),
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
                        'tablerow' => NotificationbroadcastedTable::init()->buildindextable()->getSingleRowRest($notificationbroadcasted),
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

        Notificationbroadcasted::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
