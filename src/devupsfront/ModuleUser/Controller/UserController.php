<?php 

            
use dclass\devups\Controller\Controller;

class UserController extends Controller{

    public function listView($next = 1, $per_page = 10){

        $this->datatable = UserTable::init(new User())->buildindextable();

        self::$jsfiles[] = User::classpath('Resource/js/userCtrl.js');

        $this->entitytarget = 'User';
        $this->title = "Manage User";

        $this->renderListView();


    }

    public function datatable($next, $per_page) {
        return ['success' => true,
            'datatable' => UserTable::init(new User())->router()->getTableRest(),
        ];

    }

    public function formView($id = null)
    {
        $user = new User();
        $action = User::classpath("services.php?path=user.create");
        if ($id) {
            $action = User::classpath("services.php?path=user.update&id=" . $id);
            $user = User::find($id);
        }

        return ['success' => true,
            'form' => UserForm::init($user, $action)
                ->buildAdminForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function createAction($user_form = null){
        extract($_POST);

        $user = $this->form_fillingentity(new User(), $user_form);
 

        if ( $this->error ) {
            return 	array(	'success' => false,
                            'user' => $user,
                            'action' => 'create', 
                            'error' => $this->error);
        }
        
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
                            'error' => $this->error);
        }
        
        $user->__update();
        return 	array(	'success' => true,
                        'user' => $user,
                        //'tablerow' => UserTable::init()->buildindextable()->getSingleRowRest($user),
                        'detail' => t('Information mis à jour avec succès'));
                        
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

        User::delete()->where("id")->in($ids);

        return array('success' => true,
                'detail' => ''); 

    }

}
