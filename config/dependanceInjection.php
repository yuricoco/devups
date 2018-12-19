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
require __DIR__ . '/../lang.php';
require __DIR__ . '/Database.php';
require __DIR__ . '/dvups_functions.php';

//    require __DIR__ . '/../class/lib/lib_dependances.php';

require __DIR__ . '/../class/devups/Bugmanager.php';
require __DIR__ . '/../class/devups/Core.php';
require __DIR__ . '/../class/devups/DBAL.php';
require __DIR__ . '/../class/devups/QueryBuilder.php';
require __DIR__ . '/../class/devups/Dfile.php';
require __DIR__ . '/../class/devups/Model.php';
require __DIR__ . '/../class/devups/DvupsTranslation.php';
require __DIR__ . '/../class/devups/EntityCollection.php';
require __DIR__ . '/../class/devups/Controller.php';
require __DIR__ . '/../class/devups/Genesis.php';
require __DIR__ . '/../class/devups/Datatable.php';
require __DIR__ . '/../class/devups/System_prod.php';
require __DIR__ . '/../class/devups/UploadFile.php';
require __DIR__ . '/../class/devups/EntityCore.php';
require __DIR__ . '/../class/devups/FormFactory.php';
require __DIR__ . '/../class/devups/FormManager.php';
require __DIR__ . '/../class/devups/Form.php';
require __DIR__ . '/../class/devups/Request.php';

global $enittycollection;
global $em;
$em = DBAL::getEntityManager();

