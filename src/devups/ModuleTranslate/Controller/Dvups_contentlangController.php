<?php


use dclass\devups\Controller\Controller;

class Dvups_contentlangController extends Controller{

    public function listView($next = 1, $per_page = 10){

            $lazyloading = $this->lazyloading(new Dvups_contentlang(), $next, $per_page);

        self::$jsfiles[] = Dvups_contentlang::classpath('Ressource/js/dvups_contentlangCtrl.js');

        $this->entitytarget = 'Dvups_contentlang';
        $this->title = "Manage Dvups_contentlang";
        
        $this->renderListView(Dvups_contentlangTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Dvups_contentlang(), $next, $per_page);
        return ['success' => true,
            'datatable' => Dvups_contentlangTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($dvups_contentlang_form = null){
        extract($_POST);

        $dvups_contentlang = $this->form_fillingentity(new Dvups_contentlang(), $dvups_contentlang_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'dvups_contentlang' => $dvups_contentlang,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $dvups_contentlang->__insert();
        return 	array(	'success' => true,
                        'dvups_contentlang' => $dvups_contentlang,
                        'tablerow' => Dvups_contentlangTable::init()->buildindextable()->getSingleRowRest($dvups_contentlang),
                        'detail' => '');

    }

    public function updateAction($id, $dvups_contentlang_form = null){
        extract($_POST);
            
        $dvups_contentlang = $this->form_fillingentity(new Dvups_contentlang($id), $dvups_contentlang_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'dvups_contentlang' => $dvups_contentlang,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $dvups_contentlang->__update();
        return 	array(	'success' => true,
                        'dvups_contentlang' => $dvups_contentlang,
                        'tablerow' => Dvups_contentlangTable::init()->buildindextable()->getSingleRowRest($dvups_contentlang),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Dvups_contentlang';
        $this->title = "Detail Dvups_contentlang";

        $dvups_contentlang = Dvups_contentlang::find($id);

        $this->renderDetailView(
            Dvups_contentlangTable::init()
                ->builddetailtable()
                ->renderentitydata($dvups_contentlang)
        );

    }
    
    public function deleteAction($id){
      
            Dvups_contentlang::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Dvups_contentlang::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
