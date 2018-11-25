<?php

class Dvups_adminGenesis {

    static function genesis($view, $controllers, \Dvups_adminController $dvups_adminCtrl = null) {
        extract($controllers);

        switch ($view) {
            case 'profile':
                Genesis::renderView('dvups_admin.profile', ["admin" => Dvups_admin::find(getadmin()->getId())], "profile");
                break;

            case 'changepassword':
                Genesis::renderView('dvups_admin.changepwd', $dvups_adminCtrl->changepwAction(), 'list', true);
                break;

            case '_editpassword':
                Genesis::renderView('dvups_admin.changepwd', ["detail" => ""], 'list');
                break;

            case 'resetcredential':
                Genesis::renderView('dvups_admin.index', $dvups_adminCtrl->resetcredential($_GET["id"]), 'list', true);
                break;

            case 'added':
                Genesis::renderView('dvups_admin.added');
                break;
            
            case 'index':
                Genesis::renderView('dvups_admin.index', $dvups_adminCtrl->listAction(), 'list');
                break;

            case '_new':
                Genesis::renderView('dvups_admin.form', $dvups_adminCtrl->__newAction(), 'new');
                break;

            case 'create':
                Genesis::renderView('dvups_admin.form', $dvups_adminCtrl->createAction(), 'error creation', true);
                break;

            case '_edit':
                Genesis::renderView('dvups_admin.form', $dvups_adminCtrl->__editAction($_GET['id']), 'edite');
                break;

            case 'update':
                Genesis::renderView('dvups_admin.form', $dvups_adminCtrl->updateAction($_GET['id']), 'error updating', true);
                break;

            case 'show':
                Genesis::renderView('dvups_admin.show', $dvups_adminCtrl->showAction($_GET['id']), 'Show');
                break;

            case 'delete':
                Genesis::renderView('dvups_admin.show', $dvups_adminCtrl->deleteAction($_GET['id']), 'delete', true);
                break;

            default:
                echo 'la route n\'existe pas!';
                break;
        }
    }

    static function restGenesis($view, $controllers, \Dvups_adminController $dvups_adminCtrl = null) {
        extract($controllers);

        switch ($view) {
            case 'index':
                echo json_encode($dvups_adminCtrl->listAction());
                break;

            case 'new':
                echo json_encode($dvups_adminCtrl->createAction());
                break;

            case 'edit':
                echo json_encode($dvups_adminCtrl->editAction($_GET['id']));
                break;

            case 'show':
                echo json_encode($dvups_adminCtrl->showAction($_GET['id']));
                break;

            case 'delete':
                echo json_encode($dvups_adminCtrl->deleteAction($_GET['id']));
                break;


            default:
                echo 'la route n\'existe pas!';
                break;
        }
    }

}
