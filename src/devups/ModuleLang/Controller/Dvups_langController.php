<?php 

            
use dclass\devups\Controller\Controller;
use dclass\devups\Controller\CrudTrait;

class Dvups_langController extends Controller{

    use CrudTrait;

    public function __construct()
    {
        self::$entityname = "dvups_lang";
        parent::__construct();
    }

    /*public function listView($next = 1, $per_page = 10){

        $this->datatable = Dvups_langTable::init(new Dvups_lang())->buildindextable();

        self::$jsfiles[] = Dvups_lang::classpath('Resource/js/dvups_langCtrl.js');

        $this->entitytarget = 'Dvups_lang';
        $this->title = "Manage Dvups_lang";
        
        $this->renderListView();

    }*/

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => Dvups_langTable::init(new Dvups_lang())->router()->getTableRest(),
        ];
        
    }

    /*public function formView($id = null)
    {
        $dvups_lang = new Dvups_lang();
        $action = Dvups_lang::classpath("services.php?path=dvups_lang.create");
        if ($id) {
            $action = Dvups_lang::classpath("services.php?path=dvups_lang.update&id=" . $id);
            $dvups_lang = Dvups_lang::find($id);
        }

        return ['success' => true,
            'form' => Dvups_langForm::init($dvups_lang, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }*/

    /*public function _editAction($id, $dvups_lang_form = null){
        return $this->formView($id);
    }
    */
    public function _newAction(){
        return $this->formView();
    }

    public function createAction($dvups_lang_form = null ){
        extract($_POST);

        $dvups_lang = $this->form_fillingentity(new Dvups_lang(), $dvups_lang_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'dvups_lang' => $dvups_lang,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $dvups_lang->__insert();
        return 	array(	'success' => true,
                        'dvups_lang' => $dvups_lang,
                        'tablerow' => Dvups_langTable::init()->router()->getSingleRowRest($dvups_lang),
                        'detail' => '');

    }

    public function updateAction($id, $dvups_lang_form = null){
        extract($_POST);
            
        $dvups_lang = $this->form_fillingentity(new Dvups_lang($id), $dvups_lang_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'dvups_lang' => $dvups_lang,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $dvups_lang->__update();
        return 	array(	'success' => true,
                        'dvups_lang' => $dvups_lang,
                        'tablerow' => Dvups_langTable::init()->router()->getSingleRowRest($dvups_lang),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Dvups_lang';
        $this->title = "Detail Dvups_lang";

        $dvups_lang = Dvups_lang::find($id);

        $this->renderDetailView(
            Dvups_langTable::init()
                ->builddetailtable()
                ->renderentitydata($dvups_lang)
        );

    }
    
    public function deleteAction($id){
    
        Dvups_lang::find($id)->__delete();
        
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Dvups_lang::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

}
