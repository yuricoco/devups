<?php 


class Cd_colorFrontController extends Cd_colorController{

    public function ll($next = 1, $per_page = 10){

            return $this->lazyloading(new Cd_color(), $next, $per_page);

    }

    public function createAction($cd_color_form = null){
        $rawdata = \Request::raw();
        $cd_color = $this->hydrateWithJson(new Cd_color(), $rawdata["cd_color"]);
 

        
        $id = $cd_color->__insert();
        return 	array(	'success' => true,
                        'cd_color' => $cd_color,
                        'detail' => '');

    }

    public function updateAction($id, $cd_color_form = null){
        $rawdata = \Request::raw();
            
        $cd_color = $this->hydrateWithJson(new Cd_color($id), $rawdata["cd_color"]);

                  
        
        $cd_color->__update();
        return 	array(	'success' => true,
                        'cd_color' => $cd_color,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $cd_color = Cd_color::find($id);

        return 	array(	'success' => true,
                        'cd_color' => $cd_color,
                        'detail' => '');
          
}       


}
