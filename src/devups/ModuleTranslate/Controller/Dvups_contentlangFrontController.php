<?php 


class Dvups_contentlangFrontController extends Dvups_contentlangController{

    public function ll($next = 1, $per_page = 10){

            return $this->lazyloading(new Dvups_contentlang(), $next, $per_page);

    }

    public function createAction($dvups_contentlang_form = null){
        $rawdata = \Request::raw();
        $dvups_contentlang = $this->hydrateWithJson(new Dvups_contentlang(), $rawdata["dvups_contentlang"]);
 

        
        $id = $dvups_contentlang->__insert();
        return 	array(	'success' => true,
                        'dvups_contentlang' => $dvups_contentlang,
                        'detail' => '');

    }

    public function updateAction($id, $dvups_contentlang_form = null){
        $rawdata = \Request::raw();
            
        $dvups_contentlang = $this->hydrateWithJson(new Dvups_contentlang($id), $rawdata["dvups_contentlang"]);

                  
        
        $dvups_contentlang->__update();
        return 	array(	'success' => true,
                        'dvups_contentlang' => $dvups_contentlang,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $dvups_contentlang = Dvups_contentlang::find($id);

        return 	array(	'success' => true,
                        'dvups_contentlang' => $dvups_contentlang,
                        'detail' => '');
          
}       


}
