<?php 


class Page_mappedFrontController extends Page_mappedController{

    public function ll($next = 1, $per_page = 10){

            return $this->lazyloading(new Page_mapped(), $next, $per_page);

    }

    public function createAction($page_mapped_form = null){
        $rawdata = \Request::raw();
        $page_mapped = $this->hydrateWithJson(new Page_mapped(), $rawdata["page_mapped"]);
 

        
        $id = $page_mapped->__insert();
        return 	array(	'success' => true,
                        'page_mapped' => $page_mapped,
                        'detail' => '');

    }

    public function updateAction($id, $page_mapped_form = null){
        $rawdata = \Request::raw();
            
        $page_mapped = $this->hydrateWithJson(new Page_mapped($id), $rawdata["page_mapped"]);

                  
        
        $page_mapped->__update();
        return 	array(	'success' => true,
                        'page_mapped' => $page_mapped,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $page_mapped = Page_mapped::find($id);

        return 	array(	'success' => true,
                        'page_mapped' => $page_mapped,
                        'detail' => '');
          
}       


}
