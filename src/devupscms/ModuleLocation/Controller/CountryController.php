<?php 

            
use dclass\devups\Controller\Controller;

class CountryController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = CountryTable::init(new Country())->buildindextable();

        self::$jsfiles[] = Country::classpath('Resource/js/countryCtrl.js');

        $this->entitytarget = 'Country';
        $this->title = "Manage Country";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => CountryTable::init(new Country())->router()->getTableRest(),
        ];
        
    }

    public function formView($id = null)
    {
        $country = new Country();
        $action = Country::classpath("services.php?path=country.create");
        if ($id) {
            $action = Country::classpath("services.php?path=country.update&id=" . $id);
            $country = Country::find($id);
        }

        return ['success' => true,
            'form' => CountryForm::init($country, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function createAction($country_form = null ){
        extract($_POST);

        $country = $this->form_fillingentity(new Country(), $country_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'country' => $country,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $country->__insert();
        return 	array(	'success' => true,
                        'country' => Country::find($id, 1),
                        'tablerow' => CountryTable::init()->router()->getSingleRowRest($country),
                        'detail' => '');

    }

    public function updateAction($id, $country_form = null){
        extract($_POST);
            
        $country = $this->form_fillingentity(new Country($id), $country_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                'country' => Country::find($id, 1),
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $country->__update();
        return 	array(	'success' => true,
                        'country' => $country,
                        'tablerow' => CountryTable::init()->router()->getSingleRowRest($country),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Country';
        $this->title = "Detail Country";

        $country = Country::find($id);

        $this->renderDetailView(
            CountryTable::init()
                ->builddetailtable()
                ->renderentitydata($country)
        );

    }
    
    public function deleteAction($id){
    
        Country::delete($id);
        
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Country::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

}
