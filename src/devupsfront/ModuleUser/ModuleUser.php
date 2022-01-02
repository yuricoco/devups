<?php


namespace spacekola\ModuleUser;


use Dvups_module;
use Genesis as g;
use LoginController;
use RegistrationController;
use Request;
use UserController;
use UserFrontController;

class ModuleUser
{

    public $moduledata;

    public function __construct()
    {

    }

    public function web()
    {

        $this->moduledata = Dvups_module::init('ModuleData');


        (new Request('layout'));

        switch (Request::get('path')) {

            case 'layout':
                g::renderView("overview");
                break;

            default:
                g::renderView('404', ['page' => Request::get('path')]);
                break;
        }
    }

    public function services()
    {

        (new Request('hello'));

        switch (Request::get('path')) {

            default:
                g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
                break;
        }
    }

    public function webservices()
    {

        $userCtrl = new UserFrontController();
        $addressCtrl = new \AddressController();

        (new Request('hello'));

        switch (Request::get('path')) {

            case 'address._new':
                \AddressForm::renderaccount();
                break;
            case 'address.create':
                g::json_encode($addressCtrl->createAction());
                break;
            case 'address.form':
                \AddressForm::renderaccount(Request::get("id"));
                break;
            case 'address.update':
                g::json_encode($addressCtrl->updateAction(Request::get("id")));
                break;
            case 'address._delete':
                g::json_encode($addressCtrl->deleteAction(Request::get("id")));
                break;
            case 'address.datatable':
                g::json_encode($addressCtrl->datatable(Request::get('next'), Request::get('per_page')));
                break;
            case 'user.create':
            case 'registration':
                g::json_encode((new UserFrontController())->createAction());
                break;
            case 'user.register':
                g::json_encode((new UserFrontController())->registration());
                break;
            case 'user.synchro':
                g::json_encode((new UserFrontController())->synchro());
                break;
            case 'user.update':
                g::json_encode((new UserFrontController())->updateAction(Request::get("id")));
                break;
            case 'user.login':
            case 'user.authentification':
                g::json_encode(LoginController::connexionAction());
                break;
            case 'user.initresetpassword':
                g::json_encode(LoginController::resetactivationcode());
                break;
            case 'user.resetpassword':
                g::json_encode(LoginController::resetpassword());
                break;
            case 'user.changeemail':
                g::json_encode(RegistrationController::changeemailAction());
                break;
            case 'user.changetelephone':
                g::json_encode(RegistrationController::changetelephoneAction());
                break;
            case 'user.changepassword':
                //isnotconnected();
                g::json_encode(LoginController::changepwAction());
                break;
            case 'user.activateaccount':
            case 'activateaccount':
                g::json_encode(RegistrationController::activateaccount());
                break;
            case 'resentactivationcode':
                g::json_encode(RegistrationController::resendactivationcode());
                break;
            case 'user.checkmail':
                g::json_encode(RegistrationController::checkmailAction());
                break;
            case 'user.checkphonenumber':
                g::json_encode(RegistrationController::checktelephoneAction());
                break;
            case 'user.updateimageprofile':
                g::json_encode(UserController::updateimageprofileAction(R::get("id")));
                break;

        }
    }

}