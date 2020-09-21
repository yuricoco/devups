<?php 

            
use dclass\devups\Controller\Controller;

class MenuController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = MenuTable::init(new Menu())->buildindextable();

        self::$jsfiles[] = Menu::classpath('Ressource/js/menuCtrl.js');

        $this->entitytarget = 'Menu';
        $this->title = "Manage Menu";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => MenuTable::init(new Menu())->buildindextable()->getTableRest(),
        ];
        
    }

    public function createAction($menu_form = null ){
        extract($_POST);

        $menu = $this->form_fillingentity(new Menu(), $menu_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'menu' => $menu,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $menu->__insert();
        return 	array(	'success' => true,
                        'menu' => $menu,
                        'tablerow' => MenuTable::init()->buildindextable()->getSingleRowRest($menu),
                        'detail' => '');

    }

    public function updateAction($id, $menu_form = null){
        extract($_POST);
            
        $menu = $this->form_fillingentity(new Menu($id), $menu_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'menu' => $menu,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $menu->__update();
        return 	array(	'success' => true,
                        'menu' => $menu,
                        'tablerow' => MenuTable::init()->buildindextable()->getSingleRowRest($menu),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Menu';
        $this->title = "Detail Menu";

        $menu = Menu::find($id);

        $this->renderDetailView(
            MenuTable::init()
                ->builddetailtable()
                ->renderentitydata($menu)
        );

    }
    
    public function deleteAction($id){
      
            Menu::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Menu::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
