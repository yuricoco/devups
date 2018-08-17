<?php

//ModuleAdmin

require '../../../admin/header.php';

$adminCtrl = new Dvups_adminController();

if (isset($_GET['path']) and $_GET['path'] == 'connexion') {

    if (isset($_POST['login']) and $_POST['login'] != '' and isset($_POST['password'])) {
        $reponse = $adminCtrl->connexionAction($_POST['login'], $_POST['password']);

        if ($reponse['success']) {
            header("location: " . __env . "admin/");
        } else {
            header("Location: " . __env . "admin/login.php?err=" . $reponse['detail']);
        }
    } else {
        header("Location: " . __env . "admin/login.php?err=Entré le login et le mot de passe.");
    }
}


    if (isset($_GET['path']) and $_GET['path'] == 'deconnexion') {

        $adminCtrl->deconnexionAction($moi);
    }

global $views;
$views = __DIR__ . '/Ressource/views';

    define('CHEMINMODULE', ' <a href="index.php" target="_self" class="titre_module">Administration du system global</a> &gt; <a href="index.php?path=layout" target="_self" class="titre_module">Module ModuleAdmin</a> ');

    $controllers = [
        'dvups_adminCtrl' => new Dvups_adminController(),
        'dvups_moduleCtrl' => new Dvups_moduleController(),
        'dvups_entityCtrl' => new Dvups_entityController(),
        'dvups_roleCtrl' => new Dvups_roleController(),
        'dvups_rightCtrl' => new Dvups_rightController()
    ];


    //extract($_GET['path']);
    if (isset($_GET['path'])) {

        $path = explode('/', $_GET['path']);

        switch ($path[ENTITY]) {

            case 'layout':
                Genesis::renderBladeView("layout");
                break;

            case 'dvups_admin':
                Dvups_adminGenesis::genesis($path[VIEW], $controllers);
                break;

            case 'dvups_module':
                Dvups_moduleGenesis::genesis($path[VIEW], $controllers);
                break;

            case 'dvups_entity':
                Dvups_entityGenesis::genesis($path[VIEW], $controllers);
                break;

            case 'dvups_role':
                Dvups_roleGenesis::genesis($path[VIEW], $controllers);
                break;

            case 'dvups_right':
                Dvups_rightGenesis::genesis($path[VIEW], $controllers);
                break;


            default:
                echo 'la route n\'existe pas!';
                break;
        }
    } else {
        Genesis::renderBladeView("layout");
    }