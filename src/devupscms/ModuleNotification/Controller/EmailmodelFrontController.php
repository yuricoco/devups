<?php 


class EmailmodelFrontController extends EmailmodelController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Emailmodel());
            return $ll;

    }

    public function createAction($emailmodel_form = null ){
        $rawdata = \Request::raw();
        $emailmodel = $this->hydrateWithJson(new Emailmodel(), $rawdata["emailmodel"]);
 

        
        $id = $emailmodel->__insert();
        return 	array(	'success' => true,
                        'emailmodel' => $emailmodel,
                        'detail' => '');

    }

    public function updateAction($id, $emailmodel_form = null){
        $rawdata = \Request::raw();
            
        $emailmodel = $this->hydrateWithJson(new Emailmodel($id), $rawdata["emailmodel"]);

                  
        
        $emailmodel->__update();
        return 	array(	'success' => true,
                        'emailmodel' => $emailmodel,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $emailmodel = Emailmodel::find($id);

        return 	array(	'success' => true,
                        'emailmodel' => $emailmodel,
                        'detail' => '');
          
}       


}
