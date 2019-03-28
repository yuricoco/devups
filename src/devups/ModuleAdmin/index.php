<?php

//ModuleAdmin

require '../../../admin/header.php';

$adminCtrl = new Dvups_adminController();

global $viewdir;
$viewdir[] = __DIR__ . '/Ressource/views';

    define('CHEMINMODULE', ' <a href="index.php" target="_self" class="titre_module">Administration du system global</a> &gt; <a href="index.php?path=layout" target="_self" class="titre_module">Module ModuleAdmin</a> ');

    $controllers = [
        'dvups_adminCtrl' => new Dvups_adminController(),
        'dvups_moduleCtrl' => new Dvups_moduleController(),
        'dvups_entityCtrl' => new Dvups_entityController(),
        'dvups_roleCtrl' => new Dvups_roleController(),
        'dvups_rightCtrl' => new Dvups_rightController()
    ];

(new Request('hello'));


    //extract($_GET['path']);
    if (Request::get('path')) {

        $path = explode('/', Request::get('path'));

        switch ($path[ENTITY]) {

            case 'layout':
                Genesis::renderBladeView("layout");
                break;

            case 'dvups-admin':
                Dvups_adminGenesis::genesis($path[VIEW], $controllers);
                break;

            case 'dvups-module':
                Dvups_moduleGenesis::genesis($path[VIEW], $controllers);
                break;

            case 'dvups-entity':
                Dvups_entityGenesis::genesis($path[VIEW], $controllers);
                break;

            case 'dvups-role':
                Dvups_roleGenesis::genesis($path[VIEW], $controllers);
                break;

            case 'dvups-right':
                Dvups_rightGenesis::genesis($path[VIEW], $controllers);
                break;


            default:
                echo 'la route n\'existe pas!';
                break;
        }
    } else {
        Genesis::renderBladeView("layout");
    }