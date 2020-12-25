<?php 

            
use dclass\devups\Controller\Controller;

class CmstextController extends Controller{

    public function uploadAction(){

        $url = Dfile::init("image")
            ->addresize([800], "", "", false)
            ->addresize([230], "230_", "cmsimages/thumbs/", false)
//            ->addresize([100, 100], "admin_", $uploaddir . "mini/", false)
//            ->addresize([50], "50_", $uploaddir . "mini/", false)
            ->sanitize()
            //->setfile_name($_GET["imagename"].".jpg")
            ->moveto("cmsimages");

        return ["link" => SRC_FILE . "cmsimages/" . $url["file"]["hashname"]];
    }

    public function loadAction(){

        $pages = [];
        $uploaddir = "cmsimages/";
        $dirs = UPLOAD_DIR . $uploaddir;
        if(!file_exists($dirs)){
            return [];
        }
        $src_pages = scanDir::scan($dirs, ["jpg", "jpeg", "png"]);
        for($i = 0; $i < count($src_pages); $i++){

            $pagearray = explode($uploaddir, $src_pages[$i]);
            $pagearray[1] = str_replace("\\", "", $pagearray[1]);
            $pagearray[1] = str_replace("/", "", $pagearray[1]);

            $pages[] = ["name" => $pagearray[1],"url" => SRC_FILE . $uploaddir . $pagearray[1], "thumb" => SRC_FILE . $uploaddir . "thumbs/230_" . $pagearray[1]];

        }

        return $pages;
    }

    public function deleteimageAction(){
        Dfile::deleteFile(Request::get("image"), "cmsimages/");
        Dfile::deleteFile("thumbs/230_" . Request::get("image"), "cmsimages/");
        return Request::get("image");
    }

    public function listView($next = 1, $per_page = 10){

        $this->datatable = CmstextTable::init(new Cmstext())->buildindextable();

        self::$jsfiles[] = Cmstext::classpath('Ressource/js/cmstextCtrl.js');

        $this->entitytarget = 'Cmstext';
        $this->title = "Manage Cmstext";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => CmstextTable::init(new Cmstext())->buildindextable()->getTableRest(),
        ];
        
    }

    public function createAction($cmstext_form = null ){
        extract($_POST);

        $cmstext = $this->form_fillingentity(new Cmstext(), $cmstext_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'cmstext' => $cmstext,
                            'action' => 'create', 
                            'error' => $this->error);
        } 

        $id = $cmstext->__insert();
        return 	array(	'success' => true,
                        'cmstext' => $cmstext,
                        'tablerow' => CmstextTable::init()->buildindextable()->getSingleRowRest($cmstext),
                        'detail' => '');

    }

    public function updateAction($id, $cmstext_form = null){
        extract($_POST);
            
        $cmstext = $this->form_fillingentity(new Cmstext($id), $cmstext_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'cmstext' => $cmstext,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $cmstext->__update();
        return 	array(	'success' => true,
                        'cmstext' => $cmstext,
                        'tablerow' => CmstextTable::init()->buildindextable()->getSingleRowRest($cmstext),
                        'detail' => '');
                        
    }

    public function createWidgetAction($cmstext_form = null){
        extract($_POST);

        $cmstext = $this->form_fillingentity(new Cmstext(), $cmstext_form);
        if ( $this->error ) {
            return Genesis::renderView("cmstext.form", array(	'success' => false,
                'cmstext' => $cmstext,
                'action' => Cmstext::classpath('cmstext/create'),
                'error' => $this->error));
        }

        $id = $cmstext->__insert();
        redirect(Cmstext::classpath("cmstext/index"), true);


    }

    public function updateWidgetAction($id, $cmstext_form = null){
        extract($_POST);

        $cmstext = $this->form_fillingentity(new Cmstext($id), $cmstext_form);

        if ( $this->error ) {
            return Genesis::renderView("cmstext.form", array(	'success' => false,
                'cmstext' => $cmstext,
                'action_form' => Cmstext::classpath('cmstext/update?id=').$id,
                'error' => $this->error));
        }

        $cmstext->__update();
        redirect(Cmstext::classpath("cmstext/index"), true);

    }


    public function detailView($id)
    {

        $this->entitytarget = 'Cmstext';
        $this->title = "Detail Cmstext";

        $cmstext = Cmstext::find($id);

        $this->renderDetailView(
            CmstextTable::init()
                ->builddetailtable()
                ->renderentitydata($cmstext)
        );

    }
    
    public function deleteAction($id){
      
            Cmstext::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Cmstext::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
