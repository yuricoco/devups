<?php 


class PageFrontController extends PageController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Page());
            return $ll;

    }

    public function createAction($page_form = null ){
        $rawdata = \Request::raw();
        $page = $this->hydrateWithJson(new Page(), $rawdata["page"]);
 

        
        $id = $page->__insert();
        return 	array(	'success' => true,
                        'page' => $page,
                        'detail' => '');

    }

    public function updateAction($id, $page_form = null){
        $rawdata = \Request::raw();
            
        $page = $this->hydrateWithJson(new Page($id), $rawdata["page"]);

                  
        
        $page->__update();
        return 	array(	'success' => true,
                        'page' => $page,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $page = Page::find($id);

        return 	array(	'success' => true,
                        'page' => $page,
                        'detail' => '');
          
}       


}
