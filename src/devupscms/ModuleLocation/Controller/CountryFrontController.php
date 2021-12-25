<?php 


class CountryFrontController extends CountryController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Country());
            return $ll;

    }

    public function createAction($country_form = null ){
        $rawdata = \Request::raw();
        $country = $this->hydrateWithJson(new Country(), $rawdata["country"]);
 

        
        $id = $country->__insert();
        return 	array(	'success' => true,
                        'country' => $country,
                        'detail' => '');

    }

    public function updateAction($id, $country_form = null){
        $rawdata = \Request::raw();
            
        $country = $this->hydrateWithJson(new Country($id), $rawdata["country"]);

                  
        
        $country->__update();
        return 	array(	'success' => true,
                        'country' => $country,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $country = Country::find($id);

        return 	array(	'success' => true,
                        'country' => $country,
                        'detail' => '');
          
}       


}
