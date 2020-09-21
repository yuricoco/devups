<?php 

            
use dclass\devups\Controller\Controller;

class BlockController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = BlockTable::init(new Block())->buildindextable();

        self::$jsfiles[] = Block::classpath('Ressource/js/blockCtrl.js');

        $this->entitytarget = 'Block';
        $this->title = "Manage Block";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => BlockTable::init(new Block())->buildindextable()->getTableRest(),
        ];
        
    }

    public function createAction($block_form = null ){
        extract($_POST);

        $block = $this->form_fillingentity(new Block(), $block_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'block' => $block,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $block->__insert();
        return 	array(	'success' => true,
                        'block' => $block,
                        'tablerow' => BlockTable::init()->buildindextable()->getSingleRowRest($block),
                        'detail' => '');

    }

    public function updateAction($id, $block_form = null){
        extract($_POST);
            
        $block = $this->form_fillingentity(new Block($id), $block_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'block' => $block,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $block->__update();
        return 	array(	'success' => true,
                        'block' => $block,
                        'tablerow' => BlockTable::init()->buildindextable()->getSingleRowRest($block),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Block';
        $this->title = "Detail Block";

        $block = Block::find($id);

        $this->renderDetailView(
            BlockTable::init()
                ->builddetailtable()
                ->renderentitydata($block)
        );

    }
    
    public function deleteAction($id){
      
            Block::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Block::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
