<?php 


class NotificationbroadcastedFrontController extends NotificationbroadcastedController{

    public function ll($next = 1, $per_page = 10){

            return $this->lazyloading(new Notificationbroadcasted(), $next, $per_page);

    }

    public function listView($next = 1, $per_page = 10){

        $lazyloading = $this->lazyloading(new Notificationbroadcasted(), $next, $per_page, null, " this.id desc ");

        self::$jsfiles[] = Notificationbroadcasted::classpath('Ressource/js/notificationbroadcastedCtrl.js');

        $this->entitytarget = 'Notificationbroadcasted';
        $this->title = "Manage Notificationbroadcasted";

        return $this->renderListView(NotificationbroadcastedTable::init($lazyloading)->buildindexfronttable(), true);

    }

    public function createAction($notificationbroadcasted_form = null){
        $rawdata = \Request::raw();
        $notificationbroadcasted = $this->hydrateWithJson(new Notificationbroadcasted(), $rawdata["notificationbroadcasted"]);
 

        $notificationbroadcasted->setViewedat(new DateTime());

        
        $id = $notificationbroadcasted->__insert();
        return 	array(	'success' => true,
                        'notificationbroadcasted' => $notificationbroadcasted,
                        'detail' => '');

    }

    public function updateAction($id, $notificationbroadcasted_form = null){
        $rawdata = \Request::raw();
            
        $notificationbroadcasted = $this->hydrateWithJson(new Notificationbroadcasted($id), $rawdata["notificationbroadcasted"]);

                  
        
        $notificationbroadcasted->__update();
        return 	array(	'success' => true,
                        'notificationbroadcasted' => $notificationbroadcasted,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $notificationbroadcasted = Notificationbroadcasted::find($id);

        return 	array(	'success' => true,
                        'notificationbroadcasted' => $notificationbroadcasted,
                        'detail' => '');
          
}       


}
