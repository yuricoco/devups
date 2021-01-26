<?php 

            
use dclass\devups\Controller\Controller;

class SlideController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = SlideTable::init(new Slide())->buildindextable();

        self::$jsfiles[] = Slide::classpath('Ressource/js/slideCtrl.js');

        $this->entitytarget = 'Slide';
        $this->title = "Manage Slide";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => SlideTable::init(new Slide())->buildindextable()->getTableRest(),
        ];
        
    }

    public function createAction($slide_form = null ){
        extract($_POST);

        $slide = $this->form_fillingentity(new Slide(), $slide_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'slide' => $slide,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $slide->__insert();
        return 	array(	'success' => true,
                        'slide' => $slide,
                        'tablerow' => SlideTable::init()->buildindextable()->getSingleRowRest($slide),
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
        
        $slide->__update();
        return 	array(	'success' => true,
                        'slide' => $slide,
                        'tablerow' => SlideTable::init()->buildindextable()->getSingleRowRest($slide),
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

}
