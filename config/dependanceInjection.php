<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (file_exists(__DIR__ . '/../vendor')) {
    require __DIR__ . '/../vendor/autoload.php';
}

require __DIR__ . '/constante.php';
require __DIR__ . '/Database.php';
require __DIR__ . '/dvups_functions.php';

require __DIR__ . '/../dclass/lib/lib_dependances.php';
require __DIR__ . '/../dclass/extends/extends_dependances.php';

require __DIR__ . '/../dclass/devups/Bugmanager.php';
require __DIR__ . '/../dclass/devups/Core.php';
require __DIR__ . '/../dclass/devups/DBAL.php';
require __DIR__ . '/../dclass/devups/QueryBuilder.php';
require __DIR__ . '/../dclass/devups/Dfile.php';
require __DIR__ . '/../dclass/devups/ScanDir.php';
require __DIR__ . '/../dclass/devups/Model.php';
require __DIR__ . '/../dclass/devups/DvupsTranslation.php';
require __DIR__ . '/../dclass/devups/EntityCollection.php';
require __DIR__ . '/../dclass/devups/Controller.php';
require __DIR__ . '/../dclass/devups/Genesis.php';
require __DIR__ . '/../dclass/devups/Datatable.php';
require __DIR__ . '/../dclass/devups/System_prod.php';
require __DIR__ . '/../dclass/devups/UploadFile.php';
require __DIR__ . '/../dclass/devups/EntityCore.php';
require __DIR__ . '/../dclass/devups/FormFactory.php';
require __DIR__ . '/../dclass/devups/FormManager.php';
require __DIR__ . '/../dclass/devups/Form.php';
require __DIR__ . '/../dclass/devups/Request.php';

global $enittycollection;
global $em;
$em = DBAL::getEntityManager();

