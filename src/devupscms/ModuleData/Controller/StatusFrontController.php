<?php 


class StatusFrontController extends StatusController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Status());
            return $ll;

    }

    public function createAction($status_form = null ){
        $rawdata = \Request::raw();
        $status = $this->hydrateWithJson(new Status(), $rawdata["status"]);
 

        
        $id = $status->__insert();
        return 	array(	'success' => true,
                        'status' => $status,
                        'detail' => '');

    }

    public function updateAction($id, $status_form = null){
        $rawdata = \Request::raw();
            
        $status = $this->hydrateWithJson(new Status($id), $rawdata["status"]);

                  
        
        $status->__update();
        return 	array(	'success' => true,
                        'status' => $status,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $status = Status::find($id);

        return 	array(	'success' => true,
                        'status' => $status,
                        'detail' => '');
          
}       


}
