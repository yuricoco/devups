<?php

define('USERAPP', __project_id . '_customer');
define('USER', __project_id . '_customer');
define('USERID', __project_id . '_customer_id');

define('USERCOOKIE', __project_id . '_usercookie');
define('USERMAIL', __project_id . '_usermail');
define('USERPHONE', __project_id . '_userphone');
define('USERPASS', __project_id . '_userpass');


/**
 * @return \User Description
 */
function userapp() {

    if(isset($_SESSION[USER])) {
        $user = unserialize($_SESSION[USER]);

        return User::find($user->getId());
    }

    return new User();
}

require 'Entity/User.php';
require 'Form/UserForm.php';
require 'Datatable/UserTable.php';
require 'Controller/UserController.php';
require 'Controller/UserFrontController.php';
require 'Controller/LoginController.php';
require 'Controller/RegistrationController.php';

require 'ModuleUser.php';
