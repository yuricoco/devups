<?php 


class SlideFrontController extends SlideController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Slide());
            return $ll;

    }

    public function createAction($slide_form = null ){
        $rawdata = \Request::raw();
        $slide = $this->hydrateWithJson(new Slide(), $rawdata["slide"]);
 

        $slide->uploadImage();

        
        $id = $slide->__insert();
        return 	array(	'success' => true,
                        'slide' => $slide,
                        'detail' => '');

    }

    public function updateAction($id, $slide_form = null){
        $rawdata = \Request::raw();
            
        $slide = $this->hydrateWithJson(new Slide($id), $rawdata["slide"]);

            
                        $slide->uploadImage();
      
        
        $slide->__update();
        return 	array(	'success' => true,
                        'slide' => $slide,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $slide = Slide::find($id);

        return 	array(	'success' => true,
                        'slide' => $slide,
                        'detail' => '');
          
}       


}
