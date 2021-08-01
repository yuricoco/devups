<?php 


class Tree_item_imageFrontController extends Tree_item_imageController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Tree_item_image());
            return $ll;

    }

    public function createAction($tree_item_image_form = null ){
        $rawdata = \Request::raw();
        $tree_item_image = $this->hydrateWithJson(new Tree_item_image(), $rawdata["tree_item_image"]);
 

        
        $id = $tree_item_image->__insert();
        return 	array(	'success' => true,
                        'tree_item_image' => $tree_item_image,
                        'detail' => '');

    }

    public function updateAction($id, $tree_item_image_form = null){
        $rawdata = \Request::raw();
            
        $tree_item_image = $this->hydrateWithJson(new Tree_item_image($id), $rawdata["tree_item_image"]);

                  
        
        $tree_item_image->__update();
        return 	array(	'success' => true,
                        'tree_item_image' => $tree_item_image,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $tree_item_image = Tree_item_image::find($id);

        return 	array(	'success' => true,
                        'tree_item_image' => $tree_item_image,
                        'detail' => '');
          
}       


}
