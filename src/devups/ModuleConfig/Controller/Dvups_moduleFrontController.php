<?php 


class Dvups_moduleFrontController extends Dvups_moduleController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Dvups_module());
            return $ll;

    }

    public function createAction($dvups_module_form = null ){
        $rawdata = \Request::raw();
        $dvups_module = $this->hydrateWithJson(new Dvups_module(), $rawdata["dvups_module"]);
 

        
        $id = $dvups_module->__insert();
        return 	array(	'success' => true,
                        'dvups_module' => $dvups_module,
                        'detail' => '');

    }

    public function updateAction($id, $dvups_module_form = null){
        $rawdata = \Request::raw();
            
        $dvups_module = $this->hydrateWithJson(new Dvups_module($id), $rawdata["dvups_module"]);

                  
        
        $dvups_module->__update();
        return 	array(	'success' => true,
                        'dvups_module' => $dvups_module,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $dvups_module = Dvups_module::find($id);

        return 	array(	'success' => true,
                        'dvups_module' => $dvups_module,
                        'detail' => '');
          
}       


}
