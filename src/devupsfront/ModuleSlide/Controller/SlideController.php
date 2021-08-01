<?php 

            
use dclass\devups\Controller\Controller;

class SlideController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = SlideTable::init(new Slide())->buildindextable();

        self::$cssfiles[] = __admin."plugins/jquery-ui-1.12.1/jquery-ui.min.css";
        self::$cssfiles[] = __admin.('plugins/cropperjs/cropper.min.css');
        self::$cssfiles[] = Status::classpath('Ressource/css/status.css');
        self::$jsfiles[] = __admin."plugins/jquery-ui-1.12.1/jquery-ui.min.js";
        self::$jsfiles[] = __admin.('plugins/cropperjs/cropper.min.js');
        self::$jsfiles[] = Slide::classpath('Resource/js/slideCtrl.js');

        $this->entitytarget = 'Slide';
        $this->title = "Manage Slide";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => SlideTable::init(new Slide())->router()->getTableRest(),
        ];
        
    }

    public function createAction($slide_form = null , $dv_image_form = null){
        extract($_POST);

        $slide = $this->form_fillingentity(new Slide(), $slide_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'slide' => $slide,
                            'action' => 'create', 
                            'error' => $this->error);
        } 

        $id = $slide->__insert();

        $slide->uploadImage("image");
        $slide->__update();
        return 	array(	'success' => true,
                        'slide' => $slide,
                        'tablerow' => SlideTable::init()->router()->getSingleRowRest($slide),
                        'detail' => '');

    }

    public function updateAction($id, $slide_form = null){
        extract($_POST);
            
        $slide = $this->form_fillingentity(new Slide($id), $slide_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'slide' => $slide,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }

        $slide->uploadImage("image");
        $slide->__update();
        return 	array(	'success' => true,
                        'slide' => $slide,
                        'tablerow' => SlideTable::init()->router()->getSingleRowRest($slide),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Slide';
        $this->title = "Detail Slide";

        $slide = Slide::find($id);

        $this->renderDetailView(
            SlideTable::init()
                ->builddetailtable()
                ->renderentitydata($slide)
        );

    }
    
    public function deleteAction($id){
    
        Slide::delete($id);
        
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Slide::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

    public function sortlistAction()
    {
        foreach ($_POST["positions"] as $i => $id){
            Slide::where("this.id", $id)->update(["position"=>$i+1]);
        }
        return Response::$data;
    }
    public function changeStatusAction($id)
    {
        $result = Slide::where("this.id", $id)->update(["activated"=>Request::post("activate")]);
        return $result;
    }

}
