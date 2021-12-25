<?php 

            
use dclass\devups\Controller\Controller;

class ContinentController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = ContinentTable::init(new Continent())->buildindextable();

        self::$jsfiles[] = Continent::classpath('Resource/js/continentCtrl.js');

        $this->entitytarget = 'Continent';
        $this->title = "Manage Continent";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => ContinentTable::init(new Continent())->router()->getTableRest(),
        ];
        
    }

    public function formView($id = null)
    {
        $continent = new Continent();
        $action = Continent::classpath("services.php?path=continent.create");
        if ($id) {
            $action = Continent::classpath("services.php?path=continent.update&id=" . $id);
            $continent = Continent::find($id);
        }

        return ['success' => true,
            'form' => ContinentForm::init($continent, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function createAction($continent_form = null ){
        extract($_POST);

        $continent = $this->form_fillingentity(new Continent(), $continent_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'continent' => $continent,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $continent->__insert();
        return 	array(	'success' => true,
                        'continent' => $continent,
                        'tablerow' => ContinentTable::init()->router()->getSingleRowRest($continent),
                        'detail' => '');

    }

    public function updateAction($id, $continent_form = null){
        extract($_POST);
            
        $continent = $this->form_fillingentity(new Continent($id), $continent_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'continent' => $continent,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $continent->__update();
        return 	array(	'success' => true,
                        'continent' => $continent,
                        'tablerow' => ContinentTable::init()->router()->getSingleRowRest($continent),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Continent';
        $this->title = "Detail Continent";

        $continent = Continent::find($id);

        $this->renderDetailView(
            ContinentTable::init()
                ->builddetailtable()
                ->renderentitydata($continent)
        );

    }
    
    public function deleteAction($id){
    
        Continent::delete($id);
        
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Continent::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

}
