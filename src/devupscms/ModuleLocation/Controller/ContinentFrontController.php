<?php 


class ContinentFrontController extends ContinentController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Continent());
            return $ll;

    }

    public function createAction($continent_form = null ){
        $rawdata = \Request::raw();
        $continent = $this->hydrateWithJson(new Continent(), $rawdata["continent"]);
 

        
        $id = $continent->__insert();
        return 	array(	'success' => true,
                        'continent' => $continent,
                        'detail' => '');

    }

    public function updateAction($id, $continent_form = null){
        $rawdata = \Request::raw();
            
        $continent = $this->hydrateWithJson(new Continent($id), $rawdata["continent"]);

                  
        
        $continent->__update();
        return 	array(	'success' => true,
                        'continent' => $continent,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $continent = Continent::find($id);

        return 	array(	'success' => true,
                        'continent' => $continent,
                        'detail' => '');
          
}       


}
