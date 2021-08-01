<?php 

            
use dclass\devups\Controller\Controller;

class ImagecmsController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = ImagecmsTable::init(new Imagecms())->buildindextable();

        self::$jsfiles[] = Imagecms::classpath('Resource/js/imagecmsCtrl.js');

        $this->entitytarget = 'Imagecms';
        $this->title = "Manage Imagecms";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => ImagecmsTable::init(new Imagecms())->router()->getTableRest(),
        ];
        
    }

    public function formView($id = null)
    {
        $imagecms = new Imagecms();
        $action = Imagecms::classpath("services.php?path=imagecms.create");
        if ($id) {
            $action = Imagecms::classpath("services.php?path=imagecms.update&id=" . $id);
            $imagecms = Imagecms::find($id);
        }

        return ['success' => true,
            'form' => ImagecmsForm::init($imagecms, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function createAction($imagecms_form = null ){
        extract($_POST);

        $imagecms = $this->form_fillingentity(new Imagecms(), $imagecms_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'error' => $this->error);
        }

        $dv_image = $this->form_fillingentity(new Dv_image(), $dv_image_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                'dv_image' => $dv_image,
                'error' => $this->error);
        }
        $dv_image->uploadImagecontent();
        $dv_image->__insert();

        $imagecms->setImage($dv_image);
        $id = $imagecms->__insert();
        return 	array(	'success' => true,
                        'imagecms' => $imagecms,
                        'tablerow' => ImagecmsTable::init()->buildindextable()->getSingleRowRest($imagecms),
                        'detail' => '');

    }

    public function updateAction($id, $imagecms_form = null){
        extract($_POST);
            
        $imagecms = $this->form_fillingentity(new Imagecms($id), $imagecms_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'imagecms' => $imagecms,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $imagecms->__update();
        return 	array(	'success' => true,
                        'imagecms' => $imagecms,
                        'tablerow' => ImagecmsTable::init()->router()->getSingleRowRest($imagecms),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Imagecms';
        $this->title = "Detail Imagecms";

        $imagecms = Imagecms::find($id);

        $this->renderDetailView(
            ImagecmsTable::init()
                ->builddetailtable()
                ->renderentitydata($imagecms)
        );

    }
    
    public function deleteAction($id){
    
        Imagecms::delete($id);
        
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Imagecms::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

}
