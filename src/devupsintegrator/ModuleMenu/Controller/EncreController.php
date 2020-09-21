<?php 

            
use dclass\devups\Controller\Controller;

class EncreController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = EncreTable::init(new Encre())->buildindextable();

        self::$jsfiles[] = Encre::classpath('Ressource/js/encreCtrl.js');

        $this->entitytarget = 'Encre';
        $this->title = "Manage Encre";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => EncreTable::init(new Encre())->buildindextable()->getTableRest(),
        ];
        
    }

    public function createAction($encre_form = null , $menu_form = null){
        extract($_POST);

        $encre = $this->form_fillingentity(new Encre(), $encre_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'encre' => $encre,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
                    
        $menu = $this->form_fillingentity(new Menu(), $menu_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'menu' => $menu,
                            'error' => $this->error);
        }
        

        $menu->__insert();
        $encre->setMenu($menu);
        $id = $encre->__insert();
        return 	array(	'success' => true,
                        'encre' => $encre,
                        'tablerow' => EncreTable::init()->buildindextable()->getSingleRowRest($encre),
                        'detail' => '');

    }

    public function updateAction($id, $encre_form = null){
        extract($_POST);
            
        $encre = $this->form_fillingentity(new Encre($id), $encre_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'encre' => $encre,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $encre->__update();
        return 	array(	'success' => true,
                        'encre' => $encre,
                        'tablerow' => EncreTable::init()->buildindextable()->getSingleRowRest($encre),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Encre';
        $this->title = "Detail Encre";

        $encre = Encre::find($id);

        $this->renderDetailView(
            EncreTable::init()
                ->builddetailtable()
                ->renderentitydata($encre)
        );

    }
    
    public function deleteAction($id){
      
            Encre::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Encre::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
