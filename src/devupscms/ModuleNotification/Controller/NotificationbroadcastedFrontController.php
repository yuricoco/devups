<?php 


class NotificationbroadcastedFrontController extends NotificationbroadcastedController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Notificationbroadcasted());
            return $ll;

    }

    public function createAction($notificationbroadcasted_form = null ){
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
