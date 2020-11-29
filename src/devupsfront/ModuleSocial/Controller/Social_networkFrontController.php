<?php 


class Social_networkFrontController extends Social_networkController{

    public function ll($next = 1, $per_page = 10){

            return $this->lazyloading(new Social_network(), $next, $per_page);

    }

    public function createAction($social_network_form = null){
        $rawdata = \Request::raw();
        $social_network = $this->hydrateWithJson(new Social_network(), $rawdata["social_network"]);
 

        $social_network->uploadLogo();

        
        $id = $social_network->__insert();
        return 	array(	'success' => true,
                        'social_network' => $social_network,
                        'detail' => '');

    }

    public function updateAction($id, $social_network_form = null){
        $rawdata = \Request::raw();
            
        $social_network = $this->hydrateWithJson(new Social_network($id), $rawdata["social_network"]);

            
                        $social_network->uploadLogo();
      
        
        $social_network->__update();
        return 	array(	'success' => true,
                        'social_network' => $social_network,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $social_network = Social_network::find($id);

        return 	array(	'success' => true,
                        'social_network' => $social_network,
                        'detail' => '');
          
}       


}
