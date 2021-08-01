<?php 

            
use dclass\devups\Controller\Controller;

class Tree_item_langController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = Tree_item_langTable::init(new Tree_item_lang())->buildindextable();

        self::$jsfiles[] = Tree_item_lang::classpath('Resource/js/tree_item_langCtrl.js');

        $this->entitytarget = 'Tree_item_lang';
        $this->title = "Manage Tree_item_lang";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => Tree_item_langTable::init(new Tree_item_lang())->router()->getTableRest(),
        ];
        
    }

    public function formView($id = null)
    {
        $tree_item_lang = new Tree_item_lang();
        $action = Tree_item_lang::classpath("services.php?path=tree_item_lang.create");
        if ($id) {
            $action = Tree_item_lang::classpath("services.php?path=tree_item_lang.update&id=" . $id);
            $tree_item_lang = Tree_item_lang::find($id);
        }

        return ['success' => true,
            'form' => Tree_item_langForm::init($tree_item_lang, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function createAction($tree_item_lang_form = null ){
        extract($_POST);

        $tree_item_lang = $this->form_fillingentity(new Tree_item_lang(), $tree_item_lang_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'tree_item_lang' => $tree_item_lang,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $tree_item_lang->__insert();
        return 	array(	'success' => true,
                        'tree_item_lang' => $tree_item_lang,
                        'tablerow' => Tree_item_langTable::init()->router()->getSingleRowRest($tree_item_lang),
                        'detail' => '');

    }

    public function updateAction($id, $tree_item_lang_form = null){
        extract($_POST);
            
        $tree_item_lang = $this->form_fillingentity(new Tree_item_lang($id), $tree_item_lang_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'tree_item_lang' => $tree_item_lang,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $tree_item_lang->__update();
        return 	array(	'success' => true,
                        'tree_item_lang' => $tree_item_lang,
                        'tablerow' => Tree_item_langTable::init()->router()->getSingleRowRest($tree_item_lang),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Tree_item_lang';
        $this->title = "Detail Tree_item_lang";

        $tree_item_lang = Tree_item_lang::find($id);

        $this->renderDetailView(
            Tree_item_langTable::init()
                ->builddetailtable()
                ->renderentitydata($tree_item_lang)
        );

    }
    
    public function deleteAction($id){
    
        Tree_item_lang::delete($id);
        
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Tree_item_lang::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

}
