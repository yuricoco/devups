<?php


use dclass\devups\Controller\Controller;

class TownController extends Controller{

    public function listView($next = 1, $per_page = 10){

            $lazyloading = $this->lazyloading(new Town(), $next, $per_page);

        self::$jsfiles[] = Town::classpath('Ressource/js/townCtrl.js');

        $this->entitytarget = 'Town';
        $this->title = "Manage Town";
        
        $this->renderListView(TownTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Town(), $next, $per_page);
        return ['success' => true,
            'datatable' => TownTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($town_form = null){
        extract($_POST);

        $town = $this->form_fillingentity(new Town(), $town_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'town' => $town,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $town->__insert();
        return 	array(	'success' => true,
                        'town' => $town,
                        'tablerow' => TownTable::init()->buildindextable()->getSingleRowRest($town),
                        'detail' => '');

    }

    public function updateAction($id, $town_form = null){
        extract($_POST);
            
        $town = $this->form_fillingentity(new Town($id), $town_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'town' => $town,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $town->__update();
        return 	array(	'success' => true,
                        'town' => $town,
                        'tablerow' => TownTable::init()->buildindextable()->getSingleRowRest($town),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Town';
        $this->title = "Detail Town";

        $town = Town::find($id);

        $this->renderDetailView(
            TownTable::init()
                ->builddetailtable()
                ->renderentitydata($town)
        );

    }
    
    public function deleteAction($id){
      
            Town::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Town::delete()->where("id")->in($ids);

        return array('success' => true,
                'detail' => ''); 

    }

}
