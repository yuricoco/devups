<?php


use dclass\devups\Controller\Controller;

class Dvups_langavailableController extends Controller{

    public function listView($next = 1, $per_page = 10){

            $lazyloading = $this->lazyloading(new Dvups_langavailable(), $next, $per_page);

        self::$jsfiles[] = Dvups_langavailable::classpath('Ressource/js/dvups_langavailableCtrl.js');

        $this->entitytarget = 'Dvups_langavailable';
        $this->title = "Manage Dvups_langavailable";
        
        $this->renderListView(Dvups_langavailableTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Dvups_langavailable(), $next, $per_page);
        return ['success' => true,
            'datatable' => Dvups_langavailableTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($dvups_langavailable_form = null){
        extract($_POST);

        $dvups_langavailable = $this->form_fillingentity(new Dvups_langavailable(), $dvups_langavailable_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'dvups_langavailable' => $dvups_langavailable,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $dvups_langavailable->__insert();
        return 	array(	'success' => true,
                        'dvups_langavailable' => $dvups_langavailable,
                        'tablerow' => Dvups_langavailableTable::init()->buildindextable()->getSingleRowRest($dvups_langavailable),
                        'detail' => '');

    }

    public function updateAction($id, $dvups_langavailable_form = null){
        extract($_POST);
            
        $dvups_langavailable = $this->form_fillingentity(new Dvups_langavailable($id), $dvups_langavailable_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'dvups_langavailable' => $dvups_langavailable,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $dvups_langavailable->__update();
        return 	array(	'success' => true,
                        'dvups_langavailable' => $dvups_langavailable,
                        'tablerow' => Dvups_langavailableTable::init()->buildindextable()->getSingleRowRest($dvups_langavailable),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Dvups_langavailable';
        $this->title = "Detail Dvups_langavailable";

        $dvups_langavailable = Dvups_langavailable::find($id);

        $this->renderDetailView(
            Dvups_langavailableTable::init()
                ->builddetailtable()
                ->renderentitydata($dvups_langavailable)
        );

    }
    
    public function deleteAction($id){
      
            Dvups_langavailable::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Dvups_langavailable::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
