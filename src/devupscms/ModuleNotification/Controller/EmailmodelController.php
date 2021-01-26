<?php 

            
use dclass\devups\Controller\Controller;

class EmailmodelController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = EmailmodelTable::init(new Emailmodel())->buildindextable();

        self::$jsfiles[] = Emailmodel::classpath('Ressource/js/emailmodelCtrl.js');

        $this->entitytarget = 'Emailmodel';
        $this->title = "Manage Emailmodel";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => EmailmodelTable::init(new Emailmodel())->buildindextable()->getTableRest(),
        ];
        
    }

    public function createAction($emailmodel_form = null ){
        extract($_POST);

        $emailmodel = $this->form_fillingentity(new Emailmodel(), $emailmodel_form);
        if ( $this->error ) {
            return Genesis::renderView("emailmodel.form",	array(	'success' => false,
                            'emailmodel' => $emailmodel,
                            'action' => 'create', 
                            'error' => $this->error));
        } 
        

        $id = $emailmodel->__insert();
        return redirect(Emailmodel::classpath("emailmodel/index"));

        return 	array(	'success' => true,
                        'emailmodel' => $emailmodel,
                        'tablerow' => EmailmodelTable::init()->buildindextable()->getSingleRowRest($emailmodel),
                        'detail' => '');

    }

    public function updateAction($id, $emailmodel_form = null){
        extract($_POST);
            
        $emailmodel = $this->form_fillingentity(new Emailmodel($id), $emailmodel_form);
     
        if ( $this->error ) {
            return 	Genesis::renderView("emailmodel.form",	array(	'success' => false,
                            'emailmodel' => $emailmodel,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error));
        }
        
        $emailmodel->__update();
        return redirect(Emailmodel::classpath("emailmodel/index"));
        return 	array(	'success' => true,
                        'emailmodel' => $emailmodel,
                        'tablerow' => EmailmodelTable::init()->buildindextable()->getSingleRowRest($emailmodel),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Emailmodel';
        $this->title = "Detail Emailmodel";

        $emailmodel = Emailmodel::find($id);

        $this->renderDetailView(
            EmailmodelTable::init()
                ->builddetailtable()
                ->renderentitydata($emailmodel)
        );

    }
    
    public function deleteAction($id){
      
            Emailmodel::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Emailmodel::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

    public function testmailAction($id, $email)
    {

        $emailmodel = Emailmodel::find($id);
        Emailmodel::addReceiver($email, "devups developer");
        $data = [
            "activationcode" => "ddddd",
            "username" => "devups developer",
        ];

        return $emailmodel->sendMail($data);
    }

}
