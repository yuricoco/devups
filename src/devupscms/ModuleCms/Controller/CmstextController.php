<?php 

            
use dclass\devups\Controller\Controller;

class CmstextController extends Controller{

    public function listView(){

        $this->datatable = CmstextTable::init(new Cmstext())->buildindextable();

        self::$jsfiles[] = Cmstext::classpath('Resource/js/cmstextCtrl.js');

        $this->entitytarget = 'Cmstext';
        $this->title = "Manage Cmstext";
        
        $this->renderListView();

    }

    public function datatable() {
    
        return ['success' => true,
            'datatable' => CmstextTable::init(new Cmstext())->router()->getTableRest(),
        ];
        
    }

    public function formView($id = null)
    {
        $cmstext = new Cmstext();
        $action = Cmstext::classpath("services.php?path=cmstext.create");
        if ($id) {
            $action = Cmstext::classpath("services.php?path=cmstext.update&id=" . $id);
            $cmstext = Cmstext::find($id);
        }

        return ['success' => true,
            'form' => CmstextForm::init($cmstext, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }
    public function editView($id = null)
    {
        $cmstext = new Cmstext();
        $action = Cmstext::classpath("services.php?path=cmstext.create");
        if ($id) {
            $action = Cmstext::classpath("services.php?path=cmstext.update&id=" . $id);
            $cmstext = Cmstext::find($id);
        }
        $langs = Dvups_lang::all();
        Genesis::renderView("cmstext.form", compact("langs","cmstext", "action"));
    }

    public function createAction($cmstext_form = null ){
        extract($_POST);

        $cmstext = $this->form_fillingentity(new Cmstext(), $cmstext_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'cmstext' => $cmstext,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $cmstext->__insert();
        return 	array(	'success' => true,
                        'cmstext' => $cmstext,
                        'tablerow' => CmstextTable::init()->router()->getSingleRowRest(Cmstext::find($id, 1)),
                        'detail' => '');

    }

    public function newContent(){

        $ti = Tree_item::find(Request::get("tree_item"));

        $cmstext = new Cmstext();
        $cmstext->tree_item = $ti;
        $cmstext->title = $ti->name;
        $cmstext->reference = $ti->slug;

        $id = $cmstext->__insert();

        redirect(Cmstext::classpath("cmstext/edit?id=".$id));

    }

    public function updateAction($id, $cmstext_form = null){
        extract($_POST);
            
        $cmstext = $this->form_fillingentity(new Cmstext($id), $cmstext_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'cmstext' => $cmstext,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $cmstext->__update();
        return 	array(	'success' => true,
                        'cmstext' => $cmstext,
                        'tablerow' => CmstextTable::init()->router()->getSingleRowRest(Cmstext::find($id, 1)),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Cmstext';
        $this->title = "Detail Cmstext";

        $cmstext = Cmstext::find($id);

        $this->renderDetailView(
            CmstextTable::init()
                ->builddetailtable()
                ->renderentitydata($cmstext)
        );

    }
    
    public function deleteAction($id){
    
        Cmstext::delete($id);
        
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Cmstext::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

}
