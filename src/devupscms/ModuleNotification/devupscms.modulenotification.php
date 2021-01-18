<?php

define('sm_port', '465');
define('sm_smtp', 'mail.spacekola.com');
define('sm_username', 'no-reply@spacekola.com');
define('sm_password', 'No-reply1963');
define('sm_from', 'no-reply@spacekola.com');
define('sm_name', 'Buyamsellam24');
define('sm_smtpsecurity', 'ssl');

    require 'Entity/Emailmodel.php';
    require 'Form/EmailmodelForm.php';
    require 'Datatable/EmailmodelTable.php';
    require 'Controller/EmailmodelController.php';
    require 'Controller/EmailmodelFrontController.php';

    require 'Entity/Notification.php';
    require 'Form/NotificationForm.php';
    require 'Datatable/NotificationTable.php';
    require 'Controller/NotificationController.php';
    require 'Controller/NotificationFrontController.php';

    require 'Entity/Notificationbroadcasted.php';
    require 'Form/NotificationbroadcastedForm.php';
    require 'Datatable/NotificationbroadcastedTable.php';
    require 'Controller/NotificationbroadcastedController.php';
    require 'Controller/NotificationbroadcastedFrontController.php';
