<?php

class Dvups_roleController extends Controller {

    private $err;

    function __construct() {
        $this->err = array();
    }

    public static function getNavigationAction(\Dvups_admin $admin) {
        global $dvups_action;
        global $dvups_navigation;

        $dvups_navigation = [];
        foreach ($admin->getDvups_role() as $key => $role) {

            $role->collectDvups_entity();
            $role->collectDvups_module();
            $role->collectDvups_right();

            foreach ($role->getDvups_module() as $module) {
                $entities = [];
                foreach ($role->getDvups_entity() as $key => $entity) {
                    if ($entity->getDvups_module()->getId() == $module->getId()) {
                        $entities[] = $entity;
                        unset($role->getDvups_entity()[$key]);
                    }
                }
                $dvups_navigation[] = ['module' => $module, 'entities' => $entities];
            }
            foreach ($role->getDvups_right() as $value) {

                $right[] = $value->getName();
            }

            break;
        }
//                    echo "<pre>";
//                    die(var_dump($dvups_navigation));

        $_SESSION['action'] = $right;
//                    $dvups_action = $right;
        $_SESSION["navigation"] = serialize($dvups_navigation);
//                    $navigation = $navigation;
    }

    /**
     * retourne l'instance de l'entité ou un json pour les requete asynchrone (ajax)
     *
     * @param type $id
     * @return \Array
     */
    public function showAction($id) {
        //$dvups_roleDao = new Dvups_roleDAO();
        $dvups_role = (new DBAL())->findByIdDbal(new Dvups_role($id));

        return array('success' => true,
            //'url' => 'index.php?path=dvups_role/show&id='.$id,
            'dvups_role' => $dvups_role,
            'detail' => 'detail de l\'action.');
    }

    /**
     * Data for creation form
     * @Sequences: controller - genesis - ressource/view/form
     * @return \Array
     */
    public function __newAction() {

        return array('success' => true, // pour le restservice
            'dvups_role' => new Dvups_role(),
            'action_form' => 'create', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }

    public function createAction() {
        extract($_POST);
        $this->err = array();
        //$dvups_roleDao = new Dvups_roleDAO();

        $dvups_role = $this->form_generat(new Dvups_role(), $dvups_role_form);


        if (!array_key_exists('err', $this->err) and $id = (new DBAL())->createDbal($dvups_role)) {
            return array('success' => true, // pour le restservice
                'dvups_role' => $dvups_role,
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'dvups_role' => $dvups_role,
                'action_form' => 'create', // pour le web service
                'detail' => $this->err['err']); //Detail de l'action ou message d'erreur ou de succes
        }
    }

    /**
     * Data for edit form
     * @Sequences: controller - genesis - ressource/view/form
     * @param type $id
     * @return \Array
     */
    public function __editAction($id) {
        //$dvups_roleDao = new Dvups_roleDAO();
        $dvups_role = (new DBAL())->findByIdDbal(new Dvups_role($id));

        $dvups_role->collectDvups_entity();
        $dvups_role->collectDvups_module();
        $dvups_role->collectDvups_right();

        return array('success' => true, // pour le restservice
            'dvups_role' => $dvups_role,
            'action_form' => 'update&id=' . $id, // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }

    public function updateAction($id) {
        extract($_POST);
        $this->err = array();

        $dvups_role = $this->form_generat(new Dvups_role($id), $dvups_role_form);

        if ($dvups_role->__save()) {
            return array('success' => true, // pour le restservice
                'dvups_role' => $dvups_role,
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'dvups_role' => $dvups_role,
                'action_form' => 'update&id=' . $id, // pour le web service
                'detail' => "error data not persisted"); //Detail de l'action ou message d'erreur ou de succes
        }
    }

    /**
     * retourne un tableau d'instance de l'entité ou un json pour les requetes asynchrone (ajax)
     *
     * @param type $id
     * @return \Array
     */
    public function listAction() {

        $dvups_roleDao = new Dvups_roleDAO();
        $listDvups_role = $dvups_roleDao->findAll();

        return array('success' => true, // pour le restservice
            'listDvups_role' => $listDvups_role,
            'url' => '#', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }

    public function deleteAction($id) {


        if ((new DBAL())->deleteDbal(new Dvups_role($id)))
            return array('success' => true, // pour le restservice
                'url' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        else
            return array('success' => false, // pour le restservice
                'url' => '#', // pour le web service
                'detail' => 'Des problèmes sont survenus lors de la suppression de l\'élément.'); //Detail de l'action ou message d'erreur ou de succes
    }

}
