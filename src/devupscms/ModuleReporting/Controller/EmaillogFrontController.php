<?php 


class EmaillogFrontController extends EmaillogController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Emaillog());
            return $ll;

    }

    public function createAction($emaillog_form = null ){
        $rawdata = \Request::raw();
        $emaillog = $this->hydrateWithJson(new Emaillog(), $rawdata["emaillog"]);
 

        
        $id = $emaillog->__insert();
        return 	array(	'success' => true,
                        'emaillog' => $emaillog,
                        'detail' => '');

    }

    public function updateAction($id, $emaillog_form = null){
        $rawdata = \Request::raw();
            
        $emaillog = $this->hydrateWithJson(new Emaillog($id), $rawdata["emaillog"]);

                  
        
        $emaillog->__update();
        return 	array(	'success' => true,
                        'emaillog' => $emaillog,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $emaillog = Emaillog::find($id);

        return 	array(	'success' => true,
                        'emaillog' => $emaillog,
                        'detail' => '');
          
}       


}
