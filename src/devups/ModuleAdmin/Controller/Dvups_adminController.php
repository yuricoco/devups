<?php

use DClass\devups\Datatable as Datatable;

class Dvups_adminController extends Controller {

    private $err;

    function __construct() {
        $this->err = array();
    }

    public static function renderFormWidget($id = null) {
        if($id)
            Dvups_adminForm::__renderFormWidget(Dvups_admin::find($id), "update&id=".$id);
        else
            Dvups_adminForm::__renderFormWidget(new Dvups_admin(), 'create');
    }

    public function resetcredential() {

        $dvups_admin = Dvups_admin::find($_GET["id"]);
        $password = $dvups_admin->generatePassword();
        $dvups_admin->setPassword(sha1($password));
//        $dvups_admin->setLogin();
        $dvups_admin->generateLogin($dvups_admin->getName());

        $dvups_admin->__save();

        return array('success' => true, // pour le restservice
            'dvups_admin' => $dvups_admin,
            'redirect' => 'added&login=' . $dvups_admin->getLogin() . "&password=" . $password, // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    //
    }

    public function changepwAction() {
//        $adminDao = new AdminDAO();
        $dvups_admin = Dvups_admin::find(getadmin()->getId());
        extract($_POST);
        if (sha1($oldpwd) == $dvups_admin->getPassword()) {
            $dvups_admin->__update("password", sha1($newpwd))->exec();
            return array('success' => true, // pour le restservice
                'redirect' => 'profile&detail=password updated successfully', // pour le web service
                'detail' => '');
        } else {
            return array('success' => false, // pour le restservice
                'detail' => 'mot de passe incorrect');
        }
    }

    public function deconnexionAction($admin) {

        $_SESSION[ADMIN] = array();
        session_destroy();
        header("location: " . path('admin/login.php'));
    }

    public function connexionAction($login, $password) {

        $admin = Dvups_admin::select()->where('login', $login)->andwhere('password', sha1($password))->__getOne();
        //dv_dump($login, $password, $admin);
        if (!$admin->getId())
            return array('success' => false, "err" => 'Login ou mot de passe incorrect.');

        $admin->collectDvups_role();

        Dvups_roleController::getNavigationAction($admin);

        $_SESSION[ADMIN] = serialize($admin);
        
        return array('success' => true,
            'url' => 'index.php',
            'detail' => 'detail de l\'action.');
    }

    /**
     * retourne l'instance de l'entité ou un json pour les requete asynchrone (ajax)
     *
     * @param type $id
     * @return \Array
     */
    public function showAction($id) {
        //$dvups_adminDao = new Dvups_adminDAO();
        $dvups_admin = Dvups_admin::find($id);

        return array('success' => true,
            //'url' => 'index.php?path=dvups_admin/show&id='.$id,
            'dvups_admin' => $dvups_admin,
            'detail' => 'detail de l\'action.');
    }

    /**
     * Data for creation form
     * @Sequences: controller - genesis - ressource/view/form
     * @return \Array
     */
    public function __newAction() {

        return array('success' => true, // pour le restservice
            'dvups_admin' => new Dvups_admin(),
            'action_form' => 'create', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }

    public function createAction() {
        extract($_POST);
        $this->err = array();

        $dvups_admin = $this->form_generat(new Dvups_admin(), $dvups_admin_form);

        if ( $this->error ) {
            return 	array(	'success' => false,
                'testentity' => $dvups_admin,
                'action_form' => 'create',
                'error' => $this->error);
        }

        $password = $dvups_admin->generatePassword();
        $dvups_admin->setPassword(sha1($password));
        $dvups_admin->setLogin($dvups_admin->generateLogin());

        $id = $dvups_admin->__insert();

        return array('success' => true, // pour le restservice
            'dvups_admin' => $dvups_admin,
            'tablerow' => Datatable::getSingleRowRest($dvups_admin),
            'redirect' => 'index.php?path=dvups_admin/added&login=' . $dvups_admin->getLogin() . "&password=" . $password, // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    /**
     * Data for edit form
     * @Sequences: controller - genesis - ressource/view/form
     * @param type $id
     * @return \Array
     */
    public function __editAction($id) {
        //$dvups_adminDao = new Dvups_adminDAO();
        $dvups_admin = (new DBAL())->findByIdDbal(new Dvups_admin($id));
        $dvups_admin->collectDvups_role();

        return array('success' => true, // pour le restservice
            'dvups_admin' => $dvups_admin,
            'action_form' => 'update&id=' . $id, // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }

    public function updateAction($id) {
        extract($_POST);
        $this->err = array();

        $dvups_admin = $this->form_generat(new Dvups_admin($id), $dvups_admin_form);

        if ( $this->error ) {
            return 	array(	'success' => false,
                'testentity' => $dvups_admin,
                'action_form' => 'create',
                'error' => $this->error);
        }

        $dvups_admin->__update();

        return array('success' => true, // pour le restservice
                'dvups_admin' => $dvups_admin,
                'tablerow' => Datatable::getSingleRowRest($dvups_admin),
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    public static function renderDetail($id)
    {
        Dvups_adminForm::__renderDetailWidget(Dvups_admin::find($id));
    }

    public static function renderForm($id = null, $action = "create")
    {
        $dvups_admin = new Dvups_admin();
        if ($id) {
            $action = "update&id=" . $id;
            $dvups_admin = Dvups_admin::find($id);
            $dvups_admin->collectDvups_role();
        }

        return ['success' => true,
            'form' => Dvups_adminForm::__renderForm($dvups_admin, $action, true),
        ];
    }

    public function datatable($next, $per_page)
    {
        $lazyloading = $this->lazyloading(new Dvups_admin(), $next, $per_page);
        return ['success' => true,
            'tablebody' => Datatable::getTableRest($lazyloading),
            'tablepagination' => Datatable::pagination($lazyloading)
        ];
    }

    public function listAction($next = 1, $per_page = 10)
    {

        $lazyloading = $this->lazyloading(new Dvups_admin(), $next, $per_page, null, "dvups_admin.id desc");

        return array('success' => true, // pour le restservice
            'lazyloading' => $lazyloading, // pour le web service
            'detail' => '');

    }

}
