<?php 

            
use dclass\devups\Controller\Controller;

class Dv_imageController extends Controller{

    public function listView($next = 1, $per_page = 10){

        //$this->datatable = Dv_imageTable::init(new Dv_image())->buildindextable();
        $this->datatable = Dv_imageTable::init(new Dv_image())
            ->buildfrontcustom()
            ->setModel("frontcustom");

        self::$cssfiles[] = Dv_image::classpath('Resource/css/image.css');
        self::$jsfiles[] = Dv_image::classpath('Resource/js/dv_imageCtrl.js');

        $this->entitytarget = 'dv_image';
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
                            'action' => 'create', 
                            'error' => $this->error);
        } 

        $id = $dv_image->__insert();
        return 	array(	'success' => true,
                        'dv_image' => $dv_image,
                        'tablerow' => Dv_imageTable::init()->router()->getSingleRowRest($dv_image),
                        'detail' => '');

    }

    public function storeImage(){

        $scanpage = new Dv_image();
        $scanpage->setUploaddir("gallery/");
        $result = $scanpage->uploadImage("image");
        if(!is_null($result)) {
            //$scanpage->__delete();
            return $result;
        }

        $id = $scanpage->__insert();

        //$id = $scanpage->__update();
        return 	array(	'success' => true,
            'dv_image' => $scanpage,
            'tablerow' => Dv_imageTable::init()->router()->getSingleRowRest($scanpage),
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
      
           $di = Dv_image::find($id);
           $di->__delete();
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Dv_image::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

}
