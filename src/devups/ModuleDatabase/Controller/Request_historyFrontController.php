<?php 


class Request_historyFrontController extends Request_historyController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Request_history());
            return $ll;

    }

    public function createAction($request_history_form = null ){
        $rawdata = \Request::raw();
        $request_history = $this->hydrateWithJson(new Request_history(), $rawdata["request_history"]);
 

        
        $id = $request_history->__insert();
        return 	array(	'success' => true,
                        'request_history' => $request_history,
                        'detail' => '');

    }

    public function updateAction($id, $request_history_form = null){
        $rawdata = \Request::raw();
            
        $request_history = $this->hydrateWithJson(new Request_history($id), $rawdata["request_history"]);

                  
        
        $request_history->__update();
        return 	array(	'success' => true,
                        'request_history' => $request_history,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $request_history = Request_history::find($id);

        return 	array(	'success' => true,
                        'request_history' => $request_history,
                        'detail' => '');
          
}       


}
