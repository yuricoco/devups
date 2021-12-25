<?php 


class TownFrontController extends TownController{

    public function ll($next = 1, $per_page = 10){

            return $this->lazyloading(new Town(), $next, $per_page);

    }

    public function createAction($town_form = null){
        $rawdata = \Request::raw();
        $town = $this->hydrateWithJson(new Town(), $rawdata["town"]);
 

        
        $id = $town->__insert();
        return 	array(	'success' => true,
                        'town' => $town,
                        'detail' => '');

    }

    public function updateAction($id, $town_form = null){
        $rawdata = \Request::raw();
            
        $town = $this->hydrateWithJson(new Town($id), $rawdata["town"]);

                  
        
        $town->__update();
        return 	array(	'success' => true,
                        'town' => $town,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $town = Town::find($id);

        return 	array(	'success' => true,
                        'town' => $town,
                        'detail' => '');
          
}       


}
