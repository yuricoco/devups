<?php 

            
use dclass\devups\Controller\Controller;

class MessageController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = MessageTable::init(new Message())->buildindextable();

        self::$jsfiles[] = Message::classpath('Resource/js/messageCtrl.js');

        $this->entitytarget = 'Message';
        $this->title = "Manage Message";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => MessageTable::init(new Message())->router()->getTableRest(),
        ];
        
    }

    public function formView($id = null)
    {
        $message = new Message();
        $action = Message::classpath("services.php?path=message.create");
        if ($id) {
            $action = Message::classpath("services.php?path=message.update&id=" . $id);
            $message = Message::find($id);
        }

        return ['success' => true,
            'form' => MessageForm::init($message, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function createAction($message_form = null ){
        extract($_POST);

        $message = $this->form_fillingentity(new Message(), $message_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'detail' => t('Oups!! Une erreur est survenue. vérifiez que les champs sont bien rempli svp!'),
                            'error' => $this->error);
        } 
        

        $id = $message->__insert();
        return 	array(	'success' => true,
                        'message' => $message,
                        //'tablerow' => MessageTable::init()->router()->getSingleRowRest($message),
                        'detail' => t("Message enregistré avec succès. Merci! Nous prendrons contact avec vous au plus tôt."));

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
                        'tablerow' => MessageTable::init()->router()->getSingleRowRest($message),
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
