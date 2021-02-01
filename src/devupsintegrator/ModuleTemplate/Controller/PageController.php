<?php 

            
use dclass\devups\Controller\Controller;

class PageController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = PageTable::init(new Page())->buildindextable();

        self::$jsfiles[] = Page::classpath('Ressource/js/pageCtrl.js');

        $this->entitytarget = 'Page';
        $this->title = "Manage Page";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => PageTable::init(new Page())->buildindextable()->getTableRest(),
        ];
        
    }

    public function createAction($page_form = null ){
        extract($_POST);

        $page = $this->form_fillingentity(new Page(), $page_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'page' => $page,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $page->__insert();
        return 	array(	'success' => true,
                        'page' => $page,
                        'tablerow' => PageTable::init()->buildindextable()->getSingleRowRest($page),
                        'detail' => '');

    }

    public function updateAction($id, $page_form = null){
        extract($_POST);
            
        $page = $this->form_fillingentity(new Page($id), $page_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'page' => $page,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $page->__update();
        return 	array(	'success' => true,
                        'page' => $page,
                        'tablerow' => PageTable::init()->buildindextable()->getSingleRowRest($page),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Page';
        $this->title = "Detail Page";

        $page = Page::find($id);

        $this->renderDetailView(
            PageTable::init()
                ->builddetailtable()
                ->renderentitydata($page)
        );

    }
    
    public function deleteAction($id){
      
            Page::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Page::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
