<?php 


class DistrictFrontController extends DistrictController{

    public function ll($next = 1, $per_page = 10){

            return $this->lazyloading(new District(), $next, $per_page);

    }

    public function createAction($district_form = null){
        $rawdata = \Request::raw();
        $district = $this->hydrateWithJson(new District(), $rawdata["district"]);
 

        
        $id = $district->__insert();
        return 	array(	'success' => true,
                        'district' => $district,
                        'detail' => '');

    }

    public function updateAction($id, $district_form = null){
        $rawdata = \Request::raw();
            
        $district = $this->hydrateWithJson(new District($id), $rawdata["district"]);

                  
        
        $district->__update();
        return 	array(	'success' => true,
                        'district' => $district,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $district = District::find($id);

        return 	array(	'success' => true,
                        'district' => $district,
                        'detail' => '');
          
}       


}
