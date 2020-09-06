<?php 


class ConfigurationFrontController extends ConfigurationController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Configuration());
            return $ll;

    }

    public function createAction($configuration_form = null ){
        $rawdata = \Request::raw();
        $configuration = $this->hydrateWithJson(new Configuration(), $rawdata["configuration"]);
 

        
        $id = $configuration->__insert();
        return 	array(	'success' => true,
                        'configuration' => $configuration,
                        'detail' => '');

    }

    public function updateAction($id, $configuration_form = null){
        $rawdata = \Request::raw();
            
        $configuration = $this->hydrateWithJson(new Configuration($id), $rawdata["configuration"]);

                  
        
        $configuration->__update();
        return 	array(	'success' => true,
                        'configuration' => $configuration,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $configuration = Configuration::find($id);

        return 	array(	'success' => true,
                        'configuration' => $configuration,
                        'detail' => '');
          
}       


}
