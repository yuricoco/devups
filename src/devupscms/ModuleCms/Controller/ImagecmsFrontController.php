<?php 


class ImagecmsFrontController extends ImagecmsController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Imagecms());
            return $ll;

    }

    public function createAction($imagecms_form = null ){
        $rawdata = \Request::raw();
        $imagecms = $this->hydrateWithJson(new Imagecms(), $rawdata["imagecms"]);
 

        
        $id = $imagecms->__insert();
        return 	array(	'success' => true,
                        'imagecms' => $imagecms,
                        'detail' => '');

    }

    public function updateAction($id, $imagecms_form = null){
        $rawdata = \Request::raw();
            
        $imagecms = $this->hydrateWithJson(new Imagecms($id), $rawdata["imagecms"]);

                  
        
        $imagecms->__update();
        return 	array(	'success' => true,
                        'imagecms' => $imagecms,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $imagecms = Imagecms::find($id);

        return 	array(	'success' => true,
                        'imagecms' => $imagecms,
                        'detail' => '');
          
}       


}
