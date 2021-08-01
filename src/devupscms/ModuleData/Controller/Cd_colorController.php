<?php 

            
use dclass\devups\Controller\Controller;

class Cd_colorController extends Controller{

    public function listView($next = 1, $per_page = 10){

            $lazyloading = $this->lazyloading(new Cd_color(), $next, $per_page);

        self::$jsfiles[] = Cd_color::classpath('Ressource/js/cd_colorCtrl.js');

        $this->entitytarget = 'Cd_color';
        $this->title = "Manage Cd_color";
        
        $this->renderListView(Cd_colorTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Cd_color(), $next, $per_page);
        return ['success' => true,
            'datatable' => Cd_colorTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($cd_color_form = null){
        extract($_POST);

        $cd_color = $this->form_fillingentity(new Cd_color(), $cd_color_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'cd_color' => $cd_color,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $cd_color->__insert();
        return 	array(	'success' => true,
                        'cd_color' => $cd_color,
                        'tablerow' => Cd_colorTable::init()->buildindextable()->getSingleRowRest($cd_color),
                        'detail' => '');

    }

    public function updateAction($id, $cd_color_form = null){
        extract($_POST);
            
        $cd_color = $this->form_fillingentity(new Cd_color($id), $cd_color_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'cd_color' => $cd_color,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $cd_color->__update();
        return 	array(	'success' => true,
                        'cd_color' => $cd_color,
                        'tablerow' => Cd_colorTable::init()->buildindextable()->getSingleRowRest($cd_color),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Cd_color';
        $this->title = "Detail Cd_color";

        $cd_color = Cd_color::find($id);

        $this->renderDetailView(
            Cd_colorTable::init()
                ->builddetailtable()
                ->renderentitydata($cd_color)
        );

    }
    
    public function deleteAction($id){
      
            Cd_color::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Cd_color::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
