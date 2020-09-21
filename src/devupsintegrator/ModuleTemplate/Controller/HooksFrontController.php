<?php 


class HooksFrontController extends HooksController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Hooks());
            return $ll;

    }

    public function createAction($hooks_form = null ){
        $rawdata = \Request::raw();
        $hooks = $this->hydrateWithJson(new Hooks(), $rawdata["hooks"]);
 

        
        $id = $hooks->__insert();
        return 	array(	'success' => true,
                        'hooks' => $hooks,
                        'detail' => '');

    }

    public function updateAction($id, $hooks_form = null){
        $rawdata = \Request::raw();
            
        $hooks = $this->hydrateWithJson(new Hooks($id), $rawdata["hooks"]);

                  
        
        $hooks->__update();
        return 	array(	'success' => true,
                        'hooks' => $hooks,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $hooks = Hooks::find($id);

        return 	array(	'success' => true,
                        'hooks' => $hooks,
                        'detail' => '');
          
}       


}
