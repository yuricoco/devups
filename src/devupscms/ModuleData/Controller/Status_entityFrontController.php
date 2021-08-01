<?php 


class Status_entityFrontController extends Status_entityController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Status_entity());
            return $ll;

    }

    public function createAction($status_entity_form = null ){
        $rawdata = \Request::raw();
        $status_entity = $this->hydrateWithJson(new Status_entity(), $rawdata["status_entity"]);
 

        
        $id = $status_entity->__insert();
        return 	array(	'success' => true,
                        'status_entity' => $status_entity,
                        'detail' => '');

    }

    public function updateAction($id, $status_entity_form = null){
        $rawdata = \Request::raw();
            
        $status_entity = $this->hydrateWithJson(new Status_entity($id), $rawdata["status_entity"]);

                  
        
        $status_entity->__update();
        return 	array(	'success' => true,
                        'status_entity' => $status_entity,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $status_entity = Status_entity::find($id);

        return 	array(	'success' => true,
                        'status_entity' => $status_entity,
                        'detail' => '');
          
}       


}
