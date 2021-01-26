<?php 

            
use dclass\devups\Controller\Controller;

class Social_networkController extends Controller{

    public function listView($next = 1, $per_page = 10){

            $lazyloading = $this->lazyloading(new Social_network(), $next, $per_page);

        self::$jsfiles[] = Social_network::classpath('Ressource/js/social_networkCtrl.js');

        $this->entitytarget = 'Social_network';
        $this->title = "Manage Social_network";
        
        $this->renderListView(Social_networkTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page) {
        $lazyloading = $this->lazyloading(new Social_network(), $next, $per_page);
        return ['success' => true,
            'datatable' => Social_networkTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($social_network_form = null){
        extract($_POST);

        $social_network = $this->form_fillingentity(new Social_network(), $social_network_form);
 

        $social_network->uploadLogo();

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'social_network' => $social_network,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
        $id = $social_network->__insert();
        return 	array(	'success' => true,
                        'social_network' => $social_network,
                        'tablerow' => Social_networkTable::init()->buildindextable()->getSingleRowRest($social_network),
                        'detail' => '');

    }

    public function updateAction($id, $social_network_form = null){
        extract($_POST);
            
        $social_network = $this->form_fillingentity(new Social_network($id), $social_network_form);

            
                        $social_network->uploadLogo();
        
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'social_network' => $social_network,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $social_network->__update();
        return 	array(	'success' => true,
                        'social_network' => $social_network,
                        'tablerow' => Social_networkTable::init()->buildindextable()->getSingleRowRest($social_network),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'Social_network';
        $this->title = "Detail Social_network";

        $social_network = Social_network::find($id);

        $this->renderDetailView(
            Social_networkTable::init()
                ->builddetailtable()
                ->renderentitydata($social_network)
        );

    }
    
    public function deleteAction($id){
      
            Social_network::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        Social_network::where("id")->in($ids)->delete();

        return array('success' => true,
                'detail' => ''); 

    }

}
