<?php 


class RegionFrontController extends RegionController{

    public function ll($next = 1, $per_page = 10){

            return $this->lazyloading(new Region(), $next, $per_page);

    }

    public function createAction($region_form = null){
        $rawdata = \Request::raw();
        $region = $this->hydrateWithJson(new Region(), $rawdata["region"]);
 

        
        $id = $region->__insert();
        return 	array(	'success' => true,
                        'region' => $region,
                        'detail' => '');

    }

    public function updateAction($id, $region_form = null){
        $rawdata = \Request::raw();
            
        $region = $this->hydrateWithJson(new Region($id), $rawdata["region"]);

                  
        
        $region->__update();
        return 	array(	'success' => true,
                        'region' => $region,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $region = Region::find($id);

        return 	array(	'success' => true,
                        'region' => $region,
                        'detail' => '');
          
}       


}
