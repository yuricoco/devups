<?php 


class Dvups_langavailableFrontController extends Dvups_langavailableController{

    public function ll($next = 1, $per_page = 10){

            return $this->lazyloading(new Dvups_langavailable(), $next, $per_page);

    }

    public function createAction($dvups_langavailable_form = null){
        $rawdata = \Request::raw();
        $dvups_langavailable = $this->hydrateWithJson(new Dvups_langavailable(), $rawdata["dvups_langavailable"]);
 

        
        $id = $dvups_langavailable->__insert();
        return 	array(	'success' => true,
                        'dvups_langavailable' => $dvups_langavailable,
                        'detail' => '');

    }

    public function updateAction($id, $dvups_langavailable_form = null){
        $rawdata = \Request::raw();
            
        $dvups_langavailable = $this->hydrateWithJson(new Dvups_langavailable($id), $rawdata["dvups_langavailable"]);

                  
        
        $dvups_langavailable->__update();
        return 	array(	'success' => true,
                        'dvups_langavailable' => $dvups_langavailable,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $dvups_langavailable = Dvups_langavailable::find($id);

        return 	array(	'success' => true,
                        'dvups_langavailable' => $dvups_langavailable,
                        'detail' => '');
          
}       


}
