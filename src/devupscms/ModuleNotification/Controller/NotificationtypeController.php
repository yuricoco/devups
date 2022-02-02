<?php 

            
use dclass\devups\Controller\Controller;

class NotificationtypeController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = NotificationtypeTable::init(new Notificationtype())->buildindextable();

        self::$jsfiles[] = Notificationtype::classpath('Resource/js/notificationtypeCtrl.js');

        $this->entitytarget = 'Notificationtype';
        $this->title = "Manage Notificationtype";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => NotificationtypeTable::init(new Notificationtype())->router()->getTableRest(),
        ];
        
    }

    public function formView($id = null)
    {
        $notificationtype = new Notificationtype();
        $action = Notificationtype::classpath("services.php?path=notificationtype.create");
        if ($id) {
            $action = Notificationtype::classpath("services.php?path=notificationtype.update&id=" . $id);
            $notificationtype = Notificationtype::find($id);
        }

        return ['success' => true,
            'form' => NotificationtypeForm::init($notificationtype, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function createAction($notificationtype_form = null ){
        extract($_POST);

        $notificationtype = $this->form_fillingentity(new Notificationtype(), $notificationtype_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'notificationtype' => $notificationtype,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $notificationtype->__insert();
        return 	array(	'success' => true,
                        'notificationtype' => $notificationtype,
                        'tablerow' => NotificationtypeTable::init()->router()->getSingleRowRest($notificationtype),
                        'detail' => '');

    }

    public function updateAction($id, $notificationtype_form = null){
        extract($_POST);
            
        $notificationtype = $this->form_fillingentity(new Notificationtype($id), $notificationtype_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'notificationtype' => $notificationtype,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $notificationtype->__update();
        return 	array(	'success' => true,
                        'notificationtype' => $notificationtype,
                        'tablerow' => NotificationtypeTable::init()->router()->getSingleRowRest($notificationtype),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Notificationtype';
        $this->title = "Detail Notificationtype";

        $notificationtype = Notificationtype::find($id);

        $this->renderDetailView(
            NotificationtypeTable::init()
                ->builddetailtable()
                ->renderentitydata($notificationtype)
        );

    }
    
    public function deleteAction($id){
    
        Notificationtype::delete($id);
        
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Notificationtype::where("id")->in($ids)->delete();
        return array('success' => true,
                'detail' => ''); 

    }

    public function testnotificationAction($id, $number)
    {
        $nt = Notificationtype::find($id);
        $notification = Notification::on(new Package(), $nt->get_key(), []);
            //->send([$customer])
            //->sendSMS([$number]);
        Notification::execSMS([$number], $nt->getContent(), $nt->get_key());
        return $notification;

    }

}
