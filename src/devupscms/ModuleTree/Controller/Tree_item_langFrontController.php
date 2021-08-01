<?php 


class Tree_item_langFrontController extends Tree_item_langController{

    public function ll($next = 1, $per_page = 10){
        
            $ll = new Lazyloading();
            $ll->lazyloading(new Tree_item_lang());
            return $ll;

    }

    public function createAction($tree_item_lang_form = null ){
        $rawdata = \Request::raw();
        $tree_item_lang = $this->hydrateWithJson(new Tree_item_lang(), $rawdata["tree_item_lang"]);
 

        
        $id = $tree_item_lang->__insert();
        return 	array(	'success' => true,
                        'tree_item_lang' => $tree_item_lang,
                        'detail' => '');

    }

    public function updateAction($id, $tree_item_lang_form = null){
        $rawdata = \Request::raw();
            
        $tree_item_lang = $this->hydrateWithJson(new Tree_item_lang($id), $rawdata["tree_item_lang"]);

                  
        
        $tree_item_lang->__update();
        return 	array(	'success' => true,
                        'tree_item_lang' => $tree_item_lang,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $tree_item_lang = Tree_item_lang::find($id);

        return 	array(	'success' => true,
                        'tree_item_lang' => $tree_item_lang,
                        'detail' => '');
          
}       


}
