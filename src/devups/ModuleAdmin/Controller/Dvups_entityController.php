<?php

class Dvups_entityController extends Controller {

    /**
     * retourne l'instance de l'entité ou un json pour les requete asynchrone (ajax)
     *
     * @param type $id
     * @return \Array
     */
    public function showAction($id) {

        $dvups_entity = Dvups_entity::find($id);

        return array('success' => true,
            'dvups_entity' => $dvups_entity,
            'detail' => 'detail de l\'action.');
    }

    /**
     * Data for creation form
     * @Sequences: controller - genesis - ressource/view/form
     * @return \Array
     */
    public function __newAction() {

        return array('success' => true, // pour le restservice
            'dvups_entity' => new Dvups_entity(),
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

        $dvups_entity = $this->form_generat(new Dvups_entity(), $dvups_entity_form);


        if ($id = $dvups_entity->__insert()) {
            return array('success' => true, // pour le restservice
                'dvups_entity' => $dvups_entity,
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'dvups_entity' => $dvups_entity,
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

        $dvups_entity = Dvups_entity::find($id);

        $dvups_entity->collectDvups_right();
        return array('success' => true, // pour le restservice
            'dvups_entity' => $dvups_entity,
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

        $dvups_entity = $this->form_generat(new Dvups_entity($id), $dvups_entity_form);


        if ($dvups_entity->__update()) {
            return array('success' => true, // pour le restservice
                'dvups_entity' => $dvups_entity,
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'dvups_entity' => $dvups_entity,
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

        $lazyloading = $this->lazyloading(new Dvups_entity(), $next, $per_page);
//        $lazyloading = $this->lazyloading(new Dvups_entity(), $next, $per_page);

        return array('success' => true, // pour le restservice
            'lazyloading' => $lazyloading, // pour le web service
            'detail' => '');
    }

    public function deleteAction($id) {

        $dvups_entity = Dvups_entity::find($id);


        if ($dvups_entity->__delete())
            return array('success' => true, // pour le restservice
                'redirect' => 'index', // pour le web service
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        else
            return array('success' => false, // pour le restservice
                'dvups_entity' => $dvups_entity,
                'detail' => 'Des problèmes sont survenus lors de la suppression de l\'élément.'); //Detail de l'action ou message d'erreur ou de succes
    }

}
