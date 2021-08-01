<?php


use dclass\devups\Datatable\Lazyloading;

class Local_content_keyFrontController extends Local_content_keyController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Local_content_key());
            return $ll;

    }

    public function createAction($local_content_key_form = null ){
        $rawdata = \Request::raw();
        $local_content_key = $this->hydrateWithJson(new Local_content_key(), $rawdata["local_content_key"]);
 

        
        $id = $local_content_key->__insert();
        return 	array(	'success' => true,
                        'local_content_key' => $local_content_key,
                        'detail' => '');

    }

    public function updateAction($id, $local_content_key_form = null){
        $rawdata = \Request::raw();
            
        $local_content_key = $this->hydrateWithJson(new Local_content_key($id), $rawdata["local_content_key"]);

                  
        
        $local_content_key->__update();
        return 	array(	'success' => true,
                        'local_content_key' => $local_content_key,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $local_content_key = Local_content_key::find($id);

        return 	array(	'success' => true,
                        'local_content_key' => $local_content_key,
                        'detail' => '');
          
}       


}
