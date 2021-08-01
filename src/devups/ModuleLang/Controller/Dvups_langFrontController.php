<?php


use dclass\devups\Datatable\Lazyloading;

class Dvups_langFrontController extends Dvups_langController{

    public function ll($next = 1, $per_page = 10){

        $ll = new Lazyloading();
        $ll->lazyloading(new Dvups_lang());
        return $ll;

    }

    public function createAction($dvups_lang_form = null ){
        $rawdata = \Request::raw();
        $dvups_lang = $this->hydrateWithJson(new Dvups_lang(), $rawdata["dvups_lang"]);
 

        
        $id = $dvups_lang->__insert();
        return 	array(	'success' => true,
                        'dvups_lang' => $dvups_lang,
                        'detail' => '');

    }

    public function updateAction($id, $dvups_lang_form = null){
        $rawdata = \Request::raw();
            
        $dvups_lang = $this->hydrateWithJson(new Dvups_lang($id), $rawdata["dvups_lang"]);

                  
        
        $dvups_lang->__update();
        return 	array(	'success' => true,
                        'dvups_lang' => $dvups_lang,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $dvups_lang = Dvups_lang::find($id);

        return 	array(	'success' => true,
                        'dvups_lang' => $dvups_lang,
                        'detail' => '');
          
}       


}
