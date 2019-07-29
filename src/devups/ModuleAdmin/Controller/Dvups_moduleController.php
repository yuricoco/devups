<?php


use DClass\devups\Datatable as Datatable;

class Dvups_moduleController extends Controller
{

    public static function updatelabel($id, $label)
    {

        $dvups_module = new Dvups_module($id);
        $dvups_module->__update("dvups_module.label", $label)->exec();

        return array('success' => true,
            'dvups_module' => $dvups_module,
            'detail' => 'detail de l\'action.');
    }


    public static function renderFormWidget($id = null)
    {
        if ($id)
            Dvups_moduleForm::__renderFormWidget(Dvups_module::find($id), 'update');
        else
            Dvups_moduleForm::__renderFormWidget(new Dvups_module(), 'create');
    }

    public static function renderDetail($id)
    {
        Dvups_moduleForm::__renderDetailWidget(Dvups_module::find($id));
    }

    public static function renderForm($id = null, $action = "create")
    {
        $dvups_module = new Dvups_module();
        if ($id) {
            $action = "update&id=" . $id;
            $dvups_module = Dvups_module::find($id);
            //$dvups_module->collectStorage();
        }

        return ['success' => true,
            'form' => Dvups_moduleForm::__renderForm($dvups_module, $action, true),
        ];
    }

    public function datatable($next, $per_page)
    {
        $lazyloading = $this->lazyloading(new Dvups_module(), $next, $per_page);
        return ['success' => true,
            'datatable' => Dvups_moduleTable::init($lazyloading)
                ->buildindextable()
                ->getTableRest(),
        ];
    }

    public function listAction($next = 1, $per_page = 10)
    {

        $lazyloading = $this->lazyloading(new Dvups_module(), $next, $per_page);

        return array('success' => true, // pour le restservice
            'lazyloading' => $lazyloading, // pour le web service
            'detail' => '');

    }

    public function showAction($id)
    {

        $dvups_module = Dvups_module::find($id);

        return array('success' => true,
            'dvups_module' => $dvups_module,
            'detail' => 'detail de l\'action.');

    }

    public function createAction()
    {
        extract($_POST);
        $this->err = array();

        $dvups_module = $this->form_generat(new Dvups_module(), $dvups_module_form);

        if ($id = $dvups_module->__insert()) {
            return array('success' => true, // pour le restservice
                'dvups_module' => $dvups_module,
                'tablerow' => Dvups_moduleTable::init()
                    ->buildindextable()->getSingleRowRest($dvups_module),
                'detail' => '');
        } else {
            return array('success' => false, // pour le restservice
                'dvups_module' => $dvups_module,
                'action_form' => 'create', // pour le web service
                'detail' => 'error data not persisted'); //Detail de l'action ou message d'erreur ou de succes
        }

    }

    public function updateAction($id)
    {
        extract($_POST);

        $dvups_module = $this->form_generat(new Dvups_module($id), $dvups_module_form);


        if ($dvups_module->__update()) {
            return array('success' => true, // pour le restservice
                'dvups_module' => $dvups_module,
                'tablerow' => Dvups_moduleTable::init()
                    ->buildindextable()->getSingleRowRest($dvups_module),
                'detail' => '');
        } else {
            return array('success' => false, // pour le restservice
                'dvups_module' => $dvups_module,
                'action_form' => 'update&id=' . $id, // pour le web service
                'detail' => 'error data not updated'); //Detail de l'action ou message d'erreur ou de succes
        }
    }

    public function deleteAction($id)
    {

        Dvups_role_dvups_module::delete()->where("dvups_module_id", $id)->exec();

        Dvups_module::delete($id);
        return array('success' => true,
            'detail' => '');
    }


    public function deletegroupAction($ids)
    {

        Dvups_module::delete()->where("id")->in($ids)->exec();

        return array('success' => true, // pour le restservice
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    public function __newAction()
    {
        return array('success' => true, // pour le restservice
            'dvups_module' => new Dvups_module(),
            'action_form' => 'create', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    public function __editAction($id)
    {

        $dvups_module = Dvups_module::find($id);

        return array('success' => true, // pour le restservice
            'dvups_module' => $dvups_module,
            'action_form' => 'update&id=' . $id, // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

}
