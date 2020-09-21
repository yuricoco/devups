<?php 

            
use dclass\devups\Controller\Controller;

class MenuencreController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = MenuencreTable::init(new Menuencre())->buildindextable();

        self::$jsfiles[] = Menuencre::classpath('Ressource/js/menuencreCtrl.js');

        $this->entitytarget = 'Menuencre';
        $this->title = "Manage Menuencre";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => MenuencreTable::init(new Menuencre())->buildindextable()->getTableRest(),
        ];
        
    }

    public function createAction($menuencre_form = null ){
        extract($_POST);

        $menuencre = $this->form_fillingentity(new Menuencre(), $menuencre_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'menuencre' => $menuencre,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $menuencre->__insert();
        return 	array(	'success' => true,
                        'menuencre' => $menuencre,
                        'tablerow' => MenuencreTable::init()->buildindextable()->getSingleRowRest($menuencre),
                        'detail' => '');

    }

    public function updateAction($id, $menuencre_form = null){
        extract($_POST);
            
        $menuencre = $this->form_fillingentity(new Menuencre($id), $menuencre_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'menuencre' => $menuencre,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $menuencre->__update();
        return 	array(	'success' => true,
                        'menuencre' => $menuencre,
                        'tablerow' => MenuencreTable::init()->buildindextable()->getSingleRowRest($menuencre),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Menuencre';
        $this->title = "Detail Menuencre";

        $menuencre = Menuencre::find($id);

        $this->renderDetailView(
            MenuencreTable::init()
                ->builddetailtable()
                ->renderentitydata($menuencre)
        );

    }
    
    public function deleteAction($id){
      
            Menuencre::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Menuencre::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
