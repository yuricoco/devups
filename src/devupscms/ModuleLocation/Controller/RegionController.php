<?php


use dclass\devups\Controller\Controller;

class RegionController extends Controller{

    public function listView($next = 1, $per_page = 10){

            $lazyloading = $this->lazyloading(new Region(), $next, $per_page);

        self::$jsfiles[] = Region::classpath('Ressource/js/regionCtrl.js');

        $this->entitytarget = 'Region';
        $this->title = "Manage Region";
        
        $this->renderListView(RegionTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Region(), $next, $per_page);
        return ['success' => true,
            'datatable' => RegionTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($region_form = null){
        extract($_POST);

        $region = $this->form_fillingentity(new Region(), $region_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'region' => $region,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $region->__insert();
        return 	array(	'success' => true,
                        'region' => $region,
                        'tablerow' => RegionTable::init()->buildindextable()->getSingleRowRest($region),
                        'detail' => '');

    }

    public function updateAction($id, $region_form = null){
        extract($_POST);
            
        $region = $this->form_fillingentity(new Region($id), $region_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'region' => $region,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $region->__update();
        return 	array(	'success' => true,
                        'region' => $region,
                        'tablerow' => RegionTable::init()->buildindextable()->getSingleRowRest($region),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Region';
        $this->title = "Detail Region";

        $region = Region::find($id);

        $this->renderDetailView(
            RegionTable::init()
                ->builddetailtable()
                ->renderentitydata($region)
        );

    }
    
    public function deleteAction($id){
      
            Region::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Region::delete()->where("id")->in($ids);

        return array('success' => true,
                'detail' => ''); 

    }

}
