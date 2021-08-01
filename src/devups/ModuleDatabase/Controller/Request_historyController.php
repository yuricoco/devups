<?php 

            
use dclass\devups\Controller\Controller;

class Request_historyController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = Request_historyTable::init(new Request_history())->buildindextable();

        self::$jsfiles[] = Request_history::classpath('Resource/js/request_historyCtrl.js');

        $this->entitytarget = 'Request_history';
        $this->title = "Manage Request_history";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => Request_historyTable::init(new Request_history())->router()->getTableRest(),
        ];
        
    }

    public function formView($id = null)
    {
        $request_history = new Request_history();
        $action = Request_history::classpath("services.php?path=request_history.create");
        if ($id) {
            $action = Request_history::classpath("services.php?path=request_history.update&id=" . $id);
            $request_history = Request_history::find($id);
        }

        return ['success' => true,
            'form' => Request_historyForm::init($request_history, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function createAction($request_history_form = null ){
        extract($_POST);

        $request_history = $this->form_fillingentity(new Request_history(), $request_history_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'request_history' => $request_history,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $request_history->__insert();
        return 	array(	'success' => true,
                        'request_history' => $request_history,
                        'tablerow' => Request_historyTable::init()->router()->getSingleRowRest($request_history),
                        'detail' => '');

    }

    public function updateAction($id, $request_history_form = null){
        extract($_POST);
            
        $request_history = $this->form_fillingentity(new Request_history($id), $request_history_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'request_history' => $request_history,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $request_history->__update();
        return 	array(	'success' => true,
                        'request_history' => $request_history,
                        'tablerow' => Request_historyTable::init()->router()->getSingleRowRest($request_history),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Request_history';
        $this->title = "Detail Request_history";

        $request_history = Request_history::find($id);

        $this->renderDetailView(
            Request_historyTable::init()
                ->builddetailtable()
                ->renderentitydata($request_history)
        );

    }
    
    public function deleteAction($id){
    
        Request_history::delete($id);
        
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Request_history::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

}
