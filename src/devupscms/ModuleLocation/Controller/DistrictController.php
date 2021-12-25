<?php


use dclass\devups\Controller\Controller;

class DistrictController extends Controller{

    public function listView($next = 1, $per_page = 10){

            $lazyloading = $this->lazyloading(new District(), $next, $per_page);

        self::$jsfiles[] = District::classpath('Ressource/js/districtCtrl.js');

        $this->entitytarget = 'District';
        $this->title = "Manage District";
        
        $this->renderListView(DistrictTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new District(), $next, $per_page);
        return ['success' => true,
            'datatable' => DistrictTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($district_form = null){
        extract($_POST);

        $district = $this->form_fillingentity(new District(), $district_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'district' => $district,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $district->__insert();
        return 	array(	'success' => true,
                        'district' => $district,
                        'tablerow' => DistrictTable::init()->buildindextable()->getSingleRowRest($district),
                        'detail' => '');

    }

    public function updateAction($id, $district_form = null){
        extract($_POST);
            
        $district = $this->form_fillingentity(new District($id), $district_form);

                    
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'district' => $district,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $district->__update();
        return 	array(	'success' => true,
                        'district' => $district,
                        'tablerow' => DistrictTable::init()->buildindextable()->getSingleRowRest($district),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'District';
        $this->title = "Detail District";

        $district = District::find($id);

        $this->renderDetailView(
            DistrictTable::init()
                ->builddetailtable()
                ->renderentitydata($district)
        );

    }
    
    public function deleteAction($id){
      
            District::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        District::delete()->where("id")->in($ids);

        return array('success' => true,
                'detail' => ''); 

    }

}
