<?php

class Dvups_adminController extends Controller {

    private $err;

    function __construct() {
        $this->err = array();
    }

    public function resetcredential($id) {

        $dvups_admin = Dvups_admin::find($id);
        $password = $dvups_admin->generatePassword();
        $dvups_admin->setPassword(sha1($password));
//        $dvups_admin->setLogin();
        $dvups_admin->generateLogin($dvups_admin->getName());

        $dvups_admin->__save();

        return array('success' => true, // pour le restservice
            'dvups_admin' => $dvups_admin,
            'redirect' => 'added&login=' . $dvups_admin->getLogin() . "&pwd=" . $password, // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
            //
    }
    
    public function changepwAction(Dvups_admin $admin = null) {
//        $adminDao = new AdminDAO();
        extract($_POST);
        if (sha1($oldpwd) == $admin->getPassword()) {
            $admin->setPassword(sha1($newpwd));
            return $admin->__save($admin);
        } else {
            //return false;
            echo 'rien';
        }
    }

    public function deconnexionAction($admin) {

        $_SESSION[ADMIN] = array();
        session_destroy();
        header("location: " . path('admin/login.php'));
    }

    public function connexionAction($login, $password) {
        $adminDao = new Dvups_adminDAO();
        //$connexionDao = new ConnexionDAO();
        //$mdp = sha1($password);
        $admin = $adminDao->findByConnectic($login, $password);
        $admin->collectDvups_role();

        if (!is_array($admin) and is_object($admin)) {
            $_SESSION[ADMIN] = serialize($admin);
            Dvups_roleController::getNavigationAction($admin);

            return array('success' => true,
                'url' => 'index.php',
                'detail' => 'detail de l\'action.');

            //}
        } else {
            return array('success' => false, 'err' => 'login ou mot de passe incorrecte!');
        }
        //}
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
        $password = $dvups_admin->generatePassword();
        $dvups_admin->setPassword(sha1($password));
        $dvups_admin->setLogin($dvups_admin->generateLogin());

        if ($dvups_admin->__insert()) {
            return array('success' => true, // pour le restservice
                'dvups_admin' => $dvups_admin,
                'redirect' => 'added&login=' . $dvups_admin->getLogin()."&password=" . $password, // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'dvups_admin' => $dvups_admin,
                'action_form' => 'create', // pour le web service
                'detail' => 'error data not persisted'); //Detail de l'action ou message d'erreur ou de succes
        }
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

        if ($dvups_admin->__save()) {
            return array('success' => true, // pour le restservice
                'dvups_admin' => $dvups_admin,
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'dvups_admin' => $dvups_admin,
                'view' => 'form', // pour le web service
                'detail' => "Detail de l'action ou message d'erreur ou de succes"); //
        }
    }

    /**
     * retourne un tableau d'instance de l'entité ou un json pour les requetes asynchrone (ajax)
     *
     * @param type $id
     * @return \Array
     */
    public function listAction() {

        $qb = new QueryBuilder(new Dvups_admin());
        $qb->select()->orderby("dvups_admin.id desc");

        $pagination = $this->lazyloading(new Dvups_admin(), 1, 10, $qb);

        return array('success' => true, // pour le restservice
            'lazyloading' => $pagination, // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }
    

    public function deleteAction($id) {

        $dvups_admin = Dvups_admin::find($id);

        if ($dvups_admin->__delete())
            return array('success' => true, // pour le restservice
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        else
            return array('success' => false, // pour le restservice
                'dvups_admin' => $dvups_admin,
                'detail' => 'Des problèmes sont survenus lors de la suppression de l\'élément.'); //Detail de l'action ou message d'erreur ou de succes
    }

}