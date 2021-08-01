<?php

define('sm_port', '465');
define('sm_smtp', 'mail.spacekola.com');
define('sm_username', 'no-reply@spacekola.com');
define('sm_password', 'No-reply1963');
define('sm_from', 'no-reply@spacekola.com');
define('sm_name', 'Buyamsellam24');
define('sm_smtpsecurity', 'ssl');

    require 'Entity/Emaillog.php';
    require 'Form/EmaillogForm.php';
    require 'Datatable/EmaillogTable.php';
    require 'Controller/EmaillogController.php';
    require 'Controller/EmaillogFrontController.php';

    require 'Entity/Reportingmodel.php';
    require 'Form/ReportingmodelForm.php';
    require 'Datatable/ReportingmodelTable.php';
    require 'Controller/ReportingmodelController.php';
    require 'Controller/ReportingmodelFrontController.php';
