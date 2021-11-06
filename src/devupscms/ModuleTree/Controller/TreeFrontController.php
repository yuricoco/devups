<?php


use dclass\devups\Datatable\Lazyloading;

class TreeFrontController extends TreeController{

    public function ll($next = 1, $per_page = 10){

            $ll = new Lazyloading();
            $ll->lazyloading(new Tree());
            return $ll;

    }

    public function createAction($tree_form = null ){
        $rawdata = \Request::raw();
        $tree = $this->hydrateWithJson(new Tree(), $rawdata["tree"]);
 

        
        $id = $tree->__insert();
        return 	array(	'success' => true,
                        'tree' => $tree,
                        'detail' => '');

    }

    public function updateAction($id, $tree_form = null){
        $rawdata = \Request::raw();
            
        $tree = $this->hydrateWithJson(new Tree($id), $rawdata["tree"]);

        $tree->__update();
        return 	array(	'success' => true,
                        'tree' => $tree,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $tree = Tree::find($id);

        return 	array(	'success' => true,
                        'tree' => $tree,
                        'detail' => '');
          
}       


}
