<?php 


class Dv_imageFrontController extends Dv_imageController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Dv_image());
            return $ll;

    }

    public function createAction($dv_image_form = null ){
        $rawdata = \Request::raw();
        $dv_image = $this->hydrateWithJson(new Dv_image(), $rawdata["dv_image"]);
 

        $dv_image->uploadImage();

        
        $id = $dv_image->__insert();
        return 	array(	'success' => true,
                        'dv_image' => $dv_image,
                        'detail' => '');

    }

    public function updateAction($id, $dv_image_form = null){
        $rawdata = \Request::raw();
            
        $dv_image = $this->hydrateWithJson(new Dv_image($id), $rawdata["dv_image"]);

            
                        $dv_image->uploadImage();
      
        
        $dv_image->__update();
        return 	array(	'success' => true,
                        'dv_image' => $dv_image,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $dv_image = Dv_image::find($id);

        return 	array(	'success' => true,
                        'dv_image' => $dv_image,
                        'detail' => '');
          
}       


}
