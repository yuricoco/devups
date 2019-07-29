<?php


use DClass\devups\Datatable as Datatable;

class Dvups_roleController extends Controller
{

    public static function getNavigationAction(\Dvups_admin $admin)
    {
        global $dvups_action;
        global $dvups_navigation;

        $admin->manageentity = [];
        $dvups_navigation = [];
        $role = $admin->getDvups_role();
        //foreach ($admin->getDvups_role() as $key => $role) {

        $role->collectDvups_entity();
        $role->collectDvups_module();
        $role->collectDvups_right();

        foreach ($role->getDvups_module() as $module) {
            $entities = [];
            foreach ($role->getDvups_entity() as $key => $entity) {
                if ($entity->getDvups_module()->getId() == $module->getId()) {
                    $entities[] = $entity;
                    $admin->manageentity[$entity->getName()] = $entity;
                    unset($role->getDvups_entity()[$key]);
                }
            }
            $dvups_navigation[] = ['module' => $module, 'entities' => $entities];
        }
        foreach ($role->getDvups_right() as $value) {
            $right[] = $value->getName();
        }

//            break;
//        }

        $_SESSION[dv_role_permission] = $right;
        $_SESSION[dv_role_navigation] = serialize($dvups_navigation);

    }

    public static function renderFormWidget($id = null)
    {
        if ($id)
            Dvups_roleForm::__renderFormWidget(Dvups_role::find($id), 'update');
        else
            Dvups_roleForm::__renderFormWidget(new Dvups_role(), 'create');
    }

    public static function renderDetail($id)
    {
        Dvups_roleForm::__renderDetailWidget(Dvups_role::find($id));
    }

    public static function renderForm($id = null, $action = "create")
    {
        $dvups_role = new Dvups_role();
        if ($id) {
            $action = "update&id=" . $id;
            $dvups_role = Dvups_role::find($id);
            $dvups_role->collectDvups_entity();
            $dvups_role->collectDvups_module();
            $dvups_role->collectDvups_right();
        }

        return ['success' => true,
            'form' => Dvups_roleForm::__renderForm($dvups_role, $action, true),
        ];
    }

    public function datatable($next, $per_page)
    {
        $lazyloading = $this->lazyloading(new Dvups_role(), $next, $per_page);
        return ['success' => true,
            'datatable' => Datatable::getTableRest($lazyloading),
        ];
    }

    public function listView($next = 1, $per_page = 10)
    {

        $lazyloading = $this->lazyloading(new Dvups_role(), $next, $per_page);

        //self::$jsfiles[] = Client::classpath('Ressource/js/dvups_roleCtrl.js');

        $this->entitytarget = 'dvups_role';
        $this->title = "Manage Role";
        $datatablemodel = [
            ['header' => 'Name', 'value' => 'name'],
            ['header' => 'Alias', 'value' => 'alias']
        ];

        $this->renderListView(
            \DClass\devups\Datatable::buildtable($lazyloading, $datatablemodel)
                ->render()
        );

    }

    public function showAction($id)
    {

        $dvups_role = Dvups_role::find($id);

        return array('success' => true,
            'dvups_role' => $dvups_role,
            'detail' => 'detail de l\'action.');

    }

    public function createAction()
    {
        extract($_POST);
        $this->err = array();

        $dvups_role = $this->form_generat(new Dvups_role(), $dvups_role_form);

        if ($id = $dvups_role->__insert()) {
            return array('success' => true, // pour le restservice
                'dvups_role' => $dvups_role,
                'tablerow' => Dvups_roleTable::init()
                    ->buildindextable()
                    ->getSingleRowRest($dvups_role),
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'dvups_role' => $dvups_role,
                'detail' => 'error data not persisted'); //Detail de l'action ou message d'erreur ou de succes
        }

    }

    public function updateAction($id)
    {
        extract($_POST);

        $dvups_role = $this->form_generat(new Dvups_role($id), $dvups_role_form);

        if ($dvups_role->__update()) {
            return array('success' => true, // pour le restservice
                'dvups_role' => $dvups_role,
                'tablerow' => Dvups_roleTable::init()
                    ->buildindextable()
                    ->getSingleRowRest($dvups_role),
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'dvups_role' => $dvups_role,
                'action_form' => 'update&id=' . $id, // pour le web service
                'detail' => 'error data not updated'); //Detail de l'action ou message d'erreur ou de succes
        }
    }

    public function deleteAction($id)
    {

        Dvups_role::delete($id);
        return array('success' => true, // pour le restservice
            'redirect' => 'index', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }


    public function deletegroupAction($ids)
    {

        Dvups_role::delete()->where("id")->in($ids)->exec();

        return array('success' => true, // pour le restservice
            'redirect' => 'index', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    public function __newAction()
    {

        return array('success' => true, // pour le restservice
            'dvups_role' => new Dvups_role(),
            'action_form' => 'create', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    public function __editAction($id)
    {

        $dvups_role = Dvups_role::find($id);

        return array('success' => true, // pour le restservice
            'dvups_role' => $dvups_role,
            'action_form' => 'update&id=' . $id, // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

}
