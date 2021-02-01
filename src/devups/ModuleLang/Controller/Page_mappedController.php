<?php 

            
use dclass\devups\Controller\Controller;

class Page_mappedController extends Controller{

    public function listView($next = 1, $per_page = 10){

            $lazyloading = $this->lazyloading(new Page_mapped(), $next, $per_page);

        self::$jsfiles[] = Page_mapped::classpath('Ressource/js/page_mappedCtrl.js');

        $this->entitytarget = 'Page_mapped';
        $this->title = "Manage Page_mapped";
        
        $this->renderListView(Page_mappedTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Page_mapped(), $next, $per_page);
        return ['success' => true,
            'datatable' => Page_mappedTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($page_mapped_form = null){
        extract($_POST);

        $page_mapped = $this->form_fillingentity(new Page_mapped(), $page_mapped_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'page_mapped' => $page_mapped,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $page_mapped->__insert();
        return 	array(	'success' => true,
                        'page_mapped' => $page_mapped,
                        'tablerow' => Page_mappedTable::init()->buildindextable()->getSingleRowRest($page_mapped),
                        'detail' => '');

    }

    public function updateAction($id, $page_mapped_form = null){
        extract($_POST);
            
        $page_mapped = $this->form_fillingentity(new Page_mapped($id), $page_mapped_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'page_mapped' => $page_mapped,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $page_mapped->__update();
        return 	array(	'success' => true,
                        'page_mapped' => $page_mapped,
                        'tablerow' => Page_mappedTable::init()->buildindextable()->getSingleRowRest($page_mapped),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Page_mapped';
        $this->title = "Detail Page_mapped";

        $page_mapped = Page_mapped::find($id);

        $this->renderDetailView(
            Page_mappedTable::init()
                ->builddetailtable()
                ->renderentitydata($page_mapped)
        );

    }
    
    public function deleteAction($id){
      
            Page_mapped::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Page_mapped::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
