<?php


use dclass\devups\Controller\Controller;

class Dvups_entityController extends Controller
{

    /**
     * retourne l'instance de l'entité ou un json pour les requete asynchrone (ajax)
     *
     * @param type $id
     * @return \Array
     */
    public static function updatelabel($id, $label)
    {


        $dvups_entity = new Dvups_entity($id);
        $dvups_entity->__update("dvups_entity.label", $label)->exec();

        return array('success' => true,
            'dvups_entity' => $dvups_entity,
            'detail' => 'detail de l\'action.');
    }

    public static function renderDetail($id)
    {
        Dvups_entityForm::__renderDetailWidget(Dvups_entity::find($id));
    }

    public static function renderForm($id = null, $action = "create")
    {
        $dvups_entity = new Dvups_entity();
        if ($id) {
            $action = "update&id=" . $id;
            $dvups_entity = Dvups_entity::find($id);
            $dvups_entity->collectDvups_right();
        }

        return ['success' => true,
            'form' => Dvups_entityForm::__renderForm($dvups_entity, $action, true),
        ];
    }

    public function datatable($next, $per_page)
    {
        $lazyloading = $this->lazyloading(new Dvups_entity(), $next, $per_page);
        return ['success' => true,
            'datatable' => Dvups_entityTable::init($lazyloading)
                ->buildindextable()
                ->getTableRest(),
        ];
    }

    public function listAction($next = 1, $per_page = 10)
    {

        $lazyloading = $this->lazyloading(new Dvups_entity(), $next, $per_page);

        return array('success' => true, // pour le restservice
            'lazyloading' => $lazyloading, // pour le web service
            'detail' => '');

    }

    public function createAction()
    {
        extract($_POST);
        $this->err = array();

        $dvups_entity = $this->form_generat(new Dvups_entity(), $dvups_entity_form);


        if ($id = $dvups_entity->__insert()) {
            return array('success' => true, // pour le restservice
                'dvups_entity' => $dvups_entity,
                'tablerow' => Dvups_entityTable::init()
                    ->buildindextable()
                    ->getSingleRowRest($dvups_entity),
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'dvups_entity' => $dvups_entity,
                'action_form' => 'create', // pour le web service
                'detail' => 'error data not persisted'); //Detail de l'action ou message d'erreur ou de succes
        }

    }

    public function updateAction($id)
    {
        extract($_POST);

        $dvups_entity = $this->form_generat(new Dvups_entity($id), $dvups_entity_form);

        if ($dvups_entity->__update()) {
            return array('success' => true, // pour le restservice
                'dvups_entity' => $dvups_entity,
                'tablerow' => Dvups_entityTable::init()
                    ->buildindextable()
                    ->getSingleRowRest($dvups_entity),
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'dvups_entity' => $dvups_entity,
                'action_form' => 'update&id=' . $id, // pour le web service
                'detail' => 'error data not updated'); //Detail de l'action ou message d'erreur ou de succes
        }
    }


    public function deleteAction($id)
    {

        Dvups_right_dvups_entity::delete()->where("dvups_entity_id", $id)->exec();
        Dvups_role_dvups_entity::delete()->where("dvups_entity_id", $id)->exec();
        Dvups_entity::delete($id);

        return array('success' => true, // pour le restservice
            //'redirect' => 'index', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }


    public function deletegroupAction($ids)
    {

        Dvups_right_dvups_entity::delete()->where("dvups_entity_id")->in($ids)->exec();
        Dvups_role_dvups_entity::delete()->where("dvups_entity_id")->in($ids)->exec();
        Dvups_entity::delete()->where("id")->in($ids)->exec();

        return array('success' => true, // pour le restservice
            'redirect' => 'index', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

}
