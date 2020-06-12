<?php 


class Page_local_contentFrontController extends Page_local_contentController{

    public function ll($next = 1, $per_page = 10){

            return $this->lazyloading(new Page_local_content(), $next, $per_page);

    }

    public function createAction($page_local_content_form = null){
        $rawdata = \Request::raw();
        $page_local_content = $this->hydrateWithJson(new Page_local_content(), $rawdata["page_local_content"]);
 

        
        $id = $page_local_content->__insert();
        return 	array(	'success' => true,
                        'page_local_content' => $page_local_content,
                        'detail' => '');

    }

    public function updateAction($id, $page_local_content_form = null){
        $rawdata = \Request::raw();
            
        $page_local_content = $this->hydrateWithJson(new Page_local_content($id), $rawdata["page_local_content"]);

                  
        
        $page_local_content->__update();
        return 	array(	'success' => true,
                        'page_local_content' => $page_local_content,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $page_local_content = Page_local_content::find($id);

        return 	array(	'success' => true,
                        'page_local_content' => $page_local_content,
                        'detail' => '');
          
}       


}
