<?php 

            
use dclass\devups\Controller\Controller;

class ImagecmsController extends Controller{

    public function listView($next = 1, $per_page = 10){

            $lazyloading = $this->lazyloading(new Imagecms(), $next, $per_page);

        self::$jsfiles[] = Imagecms::classpath('Ressource/js/imagecmsCtrl.js');

        $this->entitytarget = 'Imagecms';
        $this->title = "Manage Imagecms";
        
        $this->renderListView(ImagecmsTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Imagecms(), $next, $per_page);
        return ['success' => true,
            'datatable' => ImagecmsTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($imagecms_form = null){
        extract($_POST);

        $imagecms = $this->form_fillingentity(new Imagecms(), $imagecms_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'imagecms' => $imagecms,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
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
                        'tablerow' => ImagecmsTable::init()->buildindextable()->getSingleRowRest($imagecms),
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
