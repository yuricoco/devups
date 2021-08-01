<?php 


class MessageFrontController extends MessageController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Message());
            return $ll;

    }

    public function createAction($message_form = null ){
        $rawdata = \Request::raw();
        $message = $this->hydrateWithJson(new Message(), $rawdata["message"]);
 

        
        $id = $message->__insert();
        return 	array(	'success' => true,
                        'message' => $message,
                        'detail' => '');

    }

    public function updateAction($id, $message_form = null){
        $rawdata = \Request::raw();
            
        $message = $this->hydrateWithJson(new Message($id), $rawdata["message"]);

                  
        
        $message->__update();
        return 	array(	'success' => true,
                        'message' => $message,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $message = Message::find($id);

        return 	array(	'success' => true,
                        'message' => $message,
                        'detail' => '');
          
}       


}
