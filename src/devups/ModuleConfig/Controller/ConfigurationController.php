<?php 

            
use dclass\devups\Controller\Controller;

class ConfigurationController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = ConfigurationTable::init(new Configuration())->buildindextable();

        self::$jsfiles[] = Configuration::classpath('Ressource/js/configurationCtrl.js');

        $this->entitytarget = 'Configuration';
        $this->title = "Manage Configuration";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => ConfigurationTable::init(new Configuration())->buildindextable()->getTableRest(),
        ];
        
    }

    public function createAction($configuration_form = null ){
        extract($_POST);

        $configuration = $this->form_fillingentity(new Configuration(), $configuration_form);
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'configuration' => $configuration,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
        

        $id = $configuration->__insert();
        return 	array(	'success' => true,
                        'configuration' => $configuration,
                        'tablerow' => ConfigurationTable::init()->router()->getSingleRowRest($configuration),
                        'detail' => '');

    }

    public function updateAction($id, $configuration_form = null){
        extract($_POST);
            
        $configuration = $this->form_fillingentity(new Configuration($id), $configuration_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'configuration' => $configuration,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $configuration->__update();
        return 	array(	'success' => true,
                        'configuration' => $configuration,
                        'tablerow' => ConfigurationTable::init()->router()->getSingleRowRest($configuration),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Configuration';
        $this->title = "Detail Configuration";

        $configuration = Configuration::find($id);

        $this->renderDetailView(
            ConfigurationTable::init()
                ->builddetailtable()
                ->renderentitydata($configuration)
        );

    }
    
    public function deleteAction($id){
      
            Configuration::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Configuration::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

    public function buildAction()
    {
        Configuration::buildConfig();
        return  Response::$data;
    }

}
