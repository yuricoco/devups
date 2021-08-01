<?php 


class NotificationtypeFrontController extends NotificationtypeController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Notificationtype());
            return $ll;

    }

    public function createAction($notificationtype_form = null ){
        $rawdata = \Request::raw();
        $notificationtype = $this->hydrateWithJson(new Notificationtype(), $rawdata["notificationtype"]);
 

        
        $id = $notificationtype->__insert();
        return 	array(	'success' => true,
                        'notificationtype' => $notificationtype,
                        'detail' => '');

    }

    public function updateAction($id, $notificationtype_form = null){
        $rawdata = \Request::raw();
            
        $notificationtype = $this->hydrateWithJson(new Notificationtype($id), $rawdata["notificationtype"]);

                  
        
        $notificationtype->__update();
        return 	array(	'success' => true,
                        'notificationtype' => $notificationtype,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $notificationtype = Notificationtype::find($id);

        return 	array(	'success' => true,
                        'notificationtype' => $notificationtype,
                        'detail' => '');
          
}       


}
