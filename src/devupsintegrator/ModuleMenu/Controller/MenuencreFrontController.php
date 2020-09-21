<?php 


class MenuencreFrontController extends MenuencreController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Menuencre());
            return $ll;

    }

    public function createAction($menuencre_form = null ){
        $rawdata = \Request::raw();
        $menuencre = $this->hydrateWithJson(new Menuencre(), $rawdata["menuencre"]);
 

        
        $id = $menuencre->__insert();
        return 	array(	'success' => true,
                        'menuencre' => $menuencre,
                        'detail' => '');

    }

    public function updateAction($id, $menuencre_form = null){
        $rawdata = \Request::raw();
            
        $menuencre = $this->hydrateWithJson(new Menuencre($id), $rawdata["menuencre"]);

                  
        
        $menuencre->__update();
        return 	array(	'success' => true,
                        'menuencre' => $menuencre,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $menuencre = Menuencre::find($id);

        return 	array(	'success' => true,
                        'menuencre' => $menuencre,
                        'detail' => '');
          
}       


}
