<?php 


class Local_contentFrontController extends Local_contentController{

    public function ll($next = 1, $per_page = 10){

            return $this->lazyloading(new Local_content(), $next, $per_page);

    }

    public function createAction($local_content_form = null){
        $rawdata = \Request::raw();
        $local_content = $this->hydrateWithJson(new Local_content(), $rawdata["local_content"]);
 

        
        $id = $local_content->__insert();
        return 	array(	'success' => true,
                        'local_content' => $local_content,
                        'detail' => '');

    }

    public function updateAction($id, $local_content_form = null){
        $rawdata = \Request::raw();
            
        $local_content = $this->hydrateWithJson(new Local_content($id), $rawdata["local_content"]);

                  
        
        $local_content->__update();
        return 	array(	'success' => true,
                        'local_content' => $local_content,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $local_content = Local_content::find($id);

        return 	array(	'success' => true,
                        'local_content' => $local_content,
                        'detail' => '');
          
}       


}
