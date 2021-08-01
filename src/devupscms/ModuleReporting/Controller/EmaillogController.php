<?php 

            
use dclass\devups\Controller\Controller;

class EmaillogController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = EmaillogTable::init(new Emaillog())->buildindextable();

        self::$jsfiles[] = Emaillog::classpath('Resource/js/emaillogCtrl.js');

        $this->entitytarget = 'Emaillog';
        $this->title = "Manage Emaillog";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => EmaillogTable::init(new Emaillog())->router()->getTableRest(),
        ];
        
    }

    public function formView($id = null)
    {
        $emaillog = new Emaillog();
        $action = Emaillog::classpath("services.php?path=emaillog.create");
        if ($id) {
            $action = Emaillog::classpath("services.php?path=emaillog.update&id=" . $id);
            $emaillog = Emaillog::find($id);
        }

        return ['success' => true,
            'form' => EmaillogForm::init($emaillog, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function createAction($emaillog_form = null ){
        extract($_POST);

        $emaillog = $this->form_fillingentity(new Emaillog(), $emaillog_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'emaillog' => $emaillog,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $emaillog->__insert();
        return 	array(	'success' => true,
                        'emaillog' => $emaillog,
                        'tablerow' => EmaillogTable::init()->router()->getSingleRowRest($emaillog),
                        'detail' => '');

    }

    public function updateAction($id, $emaillog_form = null){
        extract($_POST);
            
        $emaillog = $this->form_fillingentity(new Emaillog($id), $emaillog_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'emaillog' => $emaillog,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $emaillog->__update();
        return 	array(	'success' => true,
                        'emaillog' => $emaillog,
                        'tablerow' => EmaillogTable::init()->router()->getSingleRowRest($emaillog),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Emaillog';
        $this->title = "Detail Emaillog";

        $emaillog = Emaillog::find($id);

        $this->renderDetailView(
            EmaillogTable::init()
                ->builddetailtable()
                ->renderentitydata($emaillog)
        );

    }
    
    public function deleteAction($id){
    
        Emaillog::delete($id);
        
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Emaillog::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

}
