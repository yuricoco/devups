<?php 

            
use dclass\devups\Controller\Controller;

class Dv_imageController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = Dv_imageTable::init(new Dv_image())->buildindextable();

        self::$jsfiles[] = Dv_image::classpath('Resource/js/dv_imageCtrl.js');

        $this->entitytarget = 'Dv_image';
        $this->title = "Manage Dv_image";
        $this->indexView = "admin.dv_image.index";
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => Dv_imageTable::init(new Dv_image())->router()->getTableRest(),
        ];
        
    }

    public function createAction($dv_image_form = null ){
        extract($_POST);

        $dv_image = $this->form_fillingentity(new Dv_image(), $dv_image_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'dv_image' => $dv_image,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $dv_image->__insert();
        return 	array(	'success' => true,
                        'dv_image' => $dv_image,
                        'tablerow' => Dv_imageTable::init()->router()->getSingleRowRest($dv_image),
                        'detail' => '');

    }

    public function updateAction($id, $dv_image_form = null){
        extract($_POST);
            
        $dv_image = $this->form_fillingentity(new Dv_image($id), $dv_image_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'dv_image' => $dv_image,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $dv_image->__update();
        return 	array(	'success' => true,
                        'dv_image' => $dv_image,
                        'tablerow' => Dv_imageTable::init()->buildindextable()->getSingleRowRest($dv_image),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Dv_image';
        $this->title = "Detail Dv_image";

        $dv_image = Dv_image::find($id);

        $this->renderDetailView(
            Dv_imageTable::init()
                ->builddetailtable()
                ->renderentitydata($dv_image)
        );

    }
    
    public function deleteAction($id){
      
            Dv_image::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Dv_image::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
