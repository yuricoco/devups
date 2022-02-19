<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require __DIR__ . '/constante.php';

if (__debug)
    require 'php_ini.php';

if (file_exists(__DIR__ . '/../vendor')) {
    require __DIR__ . '/../vendor/autoload.php';
}

require __DIR__ . '/Database.php';

require __DIR__ . '/../dclass/devups/Tchutte/Bugmanager.php';
require __DIR__ . '/../dclass/devups/Core.php';
require __DIR__ . '/../dclass/devups/Tchutte/DBAL.php';
require __DIR__ . '/../dclass/devups/Tchutte/DB_dumper.php';
require __DIR__ . '/../dclass/devups/Tchutte/QueryBuilder.php';
require __DIR__ . '/../dclass/devups/Dfile.php';
require __DIR__ . '/../dclass/devups/ScanDir.php';
require __DIR__ . '/../dclass/devups/model/Model.php';
require __DIR__ . '/../dclass/devups/DvupsTranslation.php';
require __DIR__ . '/../dclass/devups/model/EntityCollection.php';
require __DIR__ . '/../dclass/devups/Controller/Controller.php';
require __DIR__ . '/../dclass/devups/Controller/FrontController.php';
require __DIR__ . '/../dclass/devups/Controller/CrudTrait.php';
require __DIR__ . '/../dclass/devups/Genesis.php';
require __DIR__ . '/../dclass/devups/Datatable/Lazyloading.php';
require __DIR__ . '/../dclass/devups/Datatable/Datatable.php';
require __DIR__ . '/../dclass/devups/Datatable/DatatableOverwrite.php';
require __DIR__ . '/../dclass/devups/Datatable/Dbutton.php';
require __DIR__ . '/../dclass/devups/System_prod.php';
require __DIR__ . '/../dclass/devups/UploadFile.php';
require __DIR__ . '/../dclass/devups/model/EntityCore.php';
require __DIR__ . '/../dclass/devups/Form/FormFactory.php';
require __DIR__ . '/../dclass/devups/Form/FormManager.php';
require __DIR__ . '/../dclass/devups/Form/Form.php';
require __DIR__ . '/../dclass/devups/Http/Request.php';
require __DIR__ . '/../dclass/devups/Http/Response.php';

require __DIR__ . '/../dclass/dvups_functions.php';
require __DIR__ . '/../dclass/lib/lib_dependances.php';

require __DIR__ . '/../admin/generator/TableTemplateRender.php';

require __DIR__ . '/../dclass/extends/extends_dependances.php';
require __DIR__ . '/../dclass/generator/template/Templatedependences.php';

global $enittycollection;
global $em;
$em = DBAL::getEntityManager();

if (dbdumper) {
    $db_dump = new \dclass\devups\Tchutte\DB_dumper();
    $db_dump->dump();
}
