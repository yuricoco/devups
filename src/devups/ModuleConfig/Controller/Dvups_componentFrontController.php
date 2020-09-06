<?php 


class Dvups_componentFrontController extends Dvups_componentController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Dvups_component());
            return $ll;

    }

    public function createAction($dvups_component_form = null ){
        $rawdata = \Request::raw();
        $dvups_component = $this->hydrateWithJson(new Dvups_component(), $rawdata["dvups_component"]);
 

        
        $id = $dvups_component->__insert();
        return 	array(	'success' => true,
                        'dvups_component' => $dvups_component,
                        'detail' => '');

    }

    public function updateAction($id, $dvups_component_form = null){
        $rawdata = \Request::raw();
            
        $dvups_component = $this->hydrateWithJson(new Dvups_component($id), $rawdata["dvups_component"]);

                  
        
        $dvups_component->__update();
        return 	array(	'success' => true,
                        'dvups_component' => $dvups_component,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $dvups_component = Dvups_component::find($id);

        return 	array(	'success' => true,
                        'dvups_component' => $dvups_component,
                        'detail' => '');
          
}       


}
