<?php 


class BlockFrontController extends BlockController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Block());
            return $ll;

    }

    public function createAction($block_form = null ){
        $rawdata = \Request::raw();
        $block = $this->hydrateWithJson(new Block(), $rawdata["block"]);
 

        
        $id = $block->__insert();
        return 	array(	'success' => true,
                        'block' => $block,
                        'detail' => '');

    }

    public function updateAction($id, $block_form = null){
        $rawdata = \Request::raw();
            
        $block = $this->hydrateWithJson(new Block($id), $rawdata["block"]);

                  
        
        $block->__update();
        return 	array(	'success' => true,
                        'block' => $block,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $block = Block::find($id);

        return 	array(	'success' => true,
                        'block' => $block,
                        'detail' => '');
          
}       


}
