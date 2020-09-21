<?php 


class EncreFrontController extends EncreController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Encre());
            return $ll;

    }

    public function createAction($encre_form = null , $menu_form = null){
        $rawdata = \Request::raw();
        $encre = $this->hydrateWithJson(new Encre(), $rawdata["encre"]);
 
                    
        $menu = $this->hydrateWithJson(new Menu(), $rawdata["menu"]);
        $menu->__insert();
        $encre->setMenu($menu); 

        
        $id = $encre->__insert();
        return 	array(	'success' => true,
                        'encre' => $encre,
                        'detail' => '');

    }

    public function updateAction($id, $encre_form = null){
        $rawdata = \Request::raw();
            
        $encre = $this->hydrateWithJson(new Encre($id), $rawdata["encre"]);

                  
        
        $encre->__update();
        return 	array(	'success' => true,
                        'encre' => $encre,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $encre = Encre::find($id);

        return 	array(	'success' => true,
                        'encre' => $encre,
                        'detail' => '');
          
}       


}
