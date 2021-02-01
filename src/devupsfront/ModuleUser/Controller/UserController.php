<?php 

            
use dclass\devups\Controller\Controller;

class UserController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = UserTable::init(new User())->buildindextable();

        self::$jsfiles[] = User::classpath('Ressource/js/userCtrl.js');

        $this->entitytarget = 'User';
        $this->title = "Manage User";
        
        $this->renderListView();

    }

    public function datatable($next, $per_page) {
    
        return ['success' => true,
            'datatable' => UserTable::init(new User())->buildindextable()->getTableRest(),
        ];
        
    }

    public function createAction($user_form = null , $enterprise_form = null){
        extract($_POST);

        $user = $this->form_fillingentity(new User(), $user_form);

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'user' => $user,
                            'action' => 'create', 
                            'error' => $this->error);
        } 
                    
//        $enterprise = $this->form_fillingentity(new Enterprise(), $enterprise_form);
//        if ( $this->error ) {
//            return 	array(	'success' => false,
//                            'enterprise' => $enterprise,
//                            'error' => $this->error);
//        }
//
//        $enterprise->__insert();
//        $user->setEnterprise($enterprise);
        $id = $user->__insert();
        return 	array(	'success' => true,
                        'user' => $user,
                        'tablerow' => UserTable::init()->buildindextable()->getSingleRowRest($user),
                        'detail' => '');

    }

    public function updateAction($id, $user_form = null){
        extract($_POST);
            
        $user = $this->form_fillingentity(new User($id), $user_form);
     
        if ( $this->error ) {
            return 	array(	'success' => false,
                            'user' => $user,
                            'action_form' => 'update&id='.$id,
                            'error' => $this->error);
        }
        
        $user->__update();
        return 	array(	'success' => true,
                        'user' => $user,
                        'tablerow' => UserTable::init()->buildindextable()->getSingleRowRest($user),
                        'detail' => '');
                        
    }
    

    public function detailView($id)
    {

        $this->entitytarget = 'User';
        $this->title = "Detail User";

        $user = User::find($id);

        $this->renderDetailView(
            UserTable::init()
                ->builddetailtable()
                ->renderentitydata($user)
        );

    }
    
    public function deleteAction($id){
      
            User::delete($id);
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($ids)
    {

        User::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }

}
