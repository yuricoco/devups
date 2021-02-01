<?php 

            
use dclass\devups\Controller\Controller;

class Page_local_contentController extends Controller{

    public function listView($next = 1, $per_page = 10){

            $lazyloading = $this->lazyloading(new Page_local_content(), $next, $per_page);

        self::$jsfiles[] = Page_local_content::classpath('Ressource/js/page_local_contentCtrl.js');

        $this->entitytarget = 'Page_local_content';
        $this->title = "Manage Page_local_content";
        
        $this->renderListView(Page_local_contentTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Page_local_content(), $next, $per_page);
        return ['success' => true,
            'datatable' => Page_local_contentTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($page_local_content_form = null){
        extract($_POST);

        $page_local_content = $this->form_fillingentity(new Page_local_content(), $page_local_content_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'page_local_content' => $page_local_content,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $page_local_content->__insert();
        return 	array(	'success' => true,
                        'page_local_content' => $page_local_content,
                        'tablerow' => Page_local_contentTable::init()->buildindextable()->getSingleRowRest($page_local_content),
                        'detail' => '');

    }

    public function updateAction($id, $page_local_content_form = null){
        extract($_POST);
            
        $page_local_content = $this->form_fillingentity(new Page_local_content($id), $page_local_content_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'page_local_content' => $page_local_content,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $page_local_content->__update();
        return 	array(	'success' => true,
                        'page_local_content' => $page_local_content,
                        'tablerow' => Page_local_contentTable::init()->buildindextable()->getSingleRowRest($page_local_content),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Page_local_content';
        $this->title = "Detail Page_local_content";

        $page_local_content = Page_local_content::find($id);

        $this->renderDetailView(
            Page_local_contentTable::init()
                ->builddetailtable()
                ->renderentitydata($page_local_content)
        );

    }
    
    public function deleteAction($id){
      
            Page_local_content::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Page_local_content::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
