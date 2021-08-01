<?php 


class NotificationFrontController extends NotificationController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Notification());
            return $ll;

    }

    public function createAction($notification_form = null ){
        $rawdata = \Request::raw();
        $notification = $this->hydrateWithJson(new Notification(), $rawdata["notification"]);
 

        
        $id = $notification->__insert();
        return 	array(	'success' => true,
                        'notification' => $notification,
                        'detail' => '');

    }

    public function updateAction($id, $notification_form = null){
        $rawdata = \Request::raw();
            
        $notification = $this->hydrateWithJson(new Notification($id), $rawdata["notification"]);

                  
        
        $notification->__update();
        return 	array(	'success' => true,
                        'notification' => $notification,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $notification = Notification::find($id);

        return 	array(	'success' => true,
                        'notification' => $notification,
                        'detail' => '');
          
}       


}
