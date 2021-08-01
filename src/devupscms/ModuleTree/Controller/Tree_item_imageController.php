<?php 

            
use dclass\devups\Controller\Controller;

class Tree_item_imageController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = Tree_item_imageTable::init(new Tree_item_image())->buildindextable();

        self::$jsfiles[] = Tree_item_image::classpath('Resource/js/tree_item_imageCtrl.js');

        $this->entitytarget = 'Tree_item_image';
        $this->title = "Manage Tree_item_image";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => Tree_item_imageTable::init(new Tree_item_image())->router()->getTableRest(),
        ];
        
    }

    public function formView($id = null)
    {
        $tree_item_image = new Tree_item_image();
        $action = Tree_item_image::classpath("services.php?path=tree_item_image.create");
        if ($id) {
            $action = Tree_item_image::classpath("services.php?path=tree_item_image.update&id=" . $id);
            $tree_item_image = Tree_item_image::find($id);
        }

        return ['success' => true,
            'form' => Tree_item_imageForm::init($tree_item_image, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function createAction($tree_item_image_form = null ){
        extract($_POST);

        $tree_item_image = $this->form_fillingentity(new Tree_item_image(), $tree_item_image_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'tree_item_image' => $tree_item_image,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $tree_item_image->__insert();
        return 	array(	'success' => true,
                        'tree_item_image' => $tree_item_image,
                        'tablerow' => Tree_item_imageTable::init()->router()->getSingleRowRest($tree_item_image),
                        'detail' => '');

    }

    public function updateAction($id, $tree_item_image_form = null){
        extract($_POST);
            
        $tree_item_image = $this->form_fillingentity(new Tree_item_image($id), $tree_item_image_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'tree_item_image' => $tree_item_image,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $tree_item_image->__update();
        return 	array(	'success' => true,
                        'tree_item_image' => $tree_item_image,
                        'tablerow' => Tree_item_imageTable::init()->router()->getSingleRowRest($tree_item_image),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Tree_item_image';
        $this->title = "Detail Tree_item_image";

        $tree_item_image = Tree_item_image::find($id);

        $this->renderDetailView(
            Tree_item_imageTable::init()
                ->builddetailtable()
                ->renderentitydata($tree_item_image)
        );

    }
    
    public function deleteAction($id){
    
        $tii = Tree_item_image::find($id);
        $tii->__delete();
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Tree_item_image::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

    public function uploadAction($id)
    {

        $id = Tree_item_image::create([
            "tree_item_id" => $id
        ]);
        $image = Tree_item_image::find($id);
        $image->uploadImage("image");
        $image->__update();

        //$image = Tree_item_image::find($id);
        $success = true;

        return compact("image", "success");
    }

}
