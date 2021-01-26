<?php


use dclass\devups\Controller\Controller;

class MessageController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $lazyloading = $this->lazyloading(new Message(), $next, $per_page);

        self::$jsfiles[] = Message::classpath('Ressource/js/messageCtrl.js');

        $this->entitytarget = 'Message';
        $this->title = "Manage Message";
        
        $this->renderListView(MessageTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Message(), $next, $per_page);
        return ['success' => true,
            'datatable' => MessageTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($message_form = null){
        extract($_POST);

        $message = $this->form_fillingentity(new Message(), $message_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'message' => $message,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $message->__insert();
        return 	array(	'success' => true,
                        'message' => $message,
                        'tablerow' => MessageTable::init()->buildindextable()->getSingleRowRest($message),
                        'detail' => '');

    }

    public function updateAction($id, $message_form = null){
        extract($_POST);
            
        $message = $this->form_fillingentity(new Message($id), $message_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'message' => $message,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $message->__update();
        return 	array(	'success' => true,
                        'message' => $message,
                        'tablerow' => MessageTable::init()->buildindextable()->getSingleRowRest($message),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Message';
        $this->title = "Detail Message";

        $message = Message::find($id);

        $this->renderDetailView(
            MessageTable::init()
                ->builddetailtable()
                ->renderentitydata($message)
        );

    }
    
    public function deleteAction($id){
      
            Message::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Message::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

}
