<?php 


class MenuFrontController extends MenuController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Menu());
            return $ll;

    }

    public function createAction($menu_form = null ){
        $rawdata = \Request::raw();
        $menu = $this->hydrateWithJson(new Menu(), $rawdata["menu"]);
 

        
        $id = $menu->__insert();
        return 	array(	'success' => true,
                        'menu' => $menu,
                        'detail' => '');

    }

    public function updateAction($id, $menu_form = null){
        $rawdata = \Request::raw();
            
        $menu = $this->hydrateWithJson(new Menu($id), $rawdata["menu"]);

                  
        
        $menu->__update();
        return 	array(	'success' => true,
                        'menu' => $menu,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $menu = Menu::find($id);

        return 	array(	'success' => true,
                        'menu' => $menu,
                        'detail' => '');
          
}       


}
