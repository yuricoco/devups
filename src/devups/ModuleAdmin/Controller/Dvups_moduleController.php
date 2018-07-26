<?php

class Dvups_moduleController extends Controller {

    public static function updatelabel($id, $label) {


        $dvups_module = new Dvups_module($id);
        $dvups_module->__update("dvups_module.label", $label)->exec();

        return array( 'success' => true,
            'dvups_module' => $dvups_module,
            'detail' => 'detail de l\'action.');
    }

    /**
     * retourne l'instance de l'entité ou un json pour les requete asynchrone (ajax)
     *
     * @param type $id
     * @return \Array
     */
    public function showAction($id) {

        $dvups_module = Dvups_module::find($id);

        return array('success' => true,
            'dvups_module' => $dvups_module,
            'detail' => 'detail de l\'action.');
    }

    /**
     * Data for creation form
     * @Sequences: controller - genesis - ressource/view/form
     * @return \Array
     */
    public function __newAction() {

        return array('success' => true, // pour le restservice
            'dvups_module' => new Dvups_module(),
            'action_form' => 'create', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }

    /**
     * Action on creation form
     * @Sequences: controller - genesis - ressource/view/form
     * @return \Array
     */
    public function createAction() {
        extract($_POST);
        $this->err = array();

        $dvups_module = $this->form_generat(new Dvups_module(), $dvups_module_form);


        if ($id = $dvups_module->__insert()) {
            return array('success' => true, // pour le restservice
                'dvups_module' => $dvups_module,
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'dvups_module' => $dvups_module,
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

        $dvups_module = Dvups_module::find($id);

        return array('success' => true, // pour le restservice
            'dvups_module' => $dvups_module,
            'action_form' => 'update&id=' . $id, // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }

    /**
     * Action on edit form
     * @Sequences: controller - genesis - ressource/view/index
     * @param type $id
     * @return \Array
     */
    public function updateAction($id) {
        extract($_POST);

        $dvups_module = $this->form_generat(new Dvups_module($id), $dvups_module_form);


        if ($dvups_module->__update()) {
            return array('success' => true, // pour le restservice
                'dvups_module' => $dvups_module,
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'dvups_module' => $dvups_module,
                'action_form' => 'update&id=' . $id, // pour le web service
                'detail' => 'error data not updated'); //Detail de l'action ou message d'erreur ou de succes
        }
    }

    /**
     * 
     *
     * @param type $id
     * @return \Array
     */
    public function listAction($next = 1, $per_page = 10) {

        $lazyloading = $this->lazyloading(new Dvups_module(), $next, $per_page);

        return array('success' => true, // pour le restservice
            'lazyloading' => $lazyloading, // pour le web service
            'detail' => '');
    }

    public function deleteAction($id) {

        $dvups_module = Dvups_module::find($id);


        if ($dvups_module->__delete())
            return array('success' => true, // pour le restservice
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        else
            return array('success' => false, // pour le restservice
                'dvups_module' => $dvups_module,
                'detail' => 'Des problèmes sont survenus lors de la suppression de l\'élément.'); //Detail de l'action ou message d'erreur ou de succes
    }

}
