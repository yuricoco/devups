<?php
//ModuleTranslate

require '../../../admin/header.php';

global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Ressource/views';
$moduledata = Dvups_module::init("ModuleTranslate");

define('CHEMINMODULE', ' <a href="index.php" target="_self" class="titre_module">Administration du system global</a> &gt; <a href="index.php?path=layout" target="_self" class="titre_module">Module ModuleTranslate</a> ');


$dvups_langCtrl = new Dvups_langController();
$dvups_contentlangCtrl = new Dvups_contentlangController();

(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderBladeView("layout");
        break;

    case 'generalinfo/index':
        Genesis::renderView('generalinfo.index',  GeneralinfoController::getdataView());
        break;

    case 'dvups-lang/changelang':
        setlang(Request::get('lang'));
        redirect("admin");
        break;
    case 'dvups-lang/index':
        $dvups_langCtrl->listView();
        break;
    case 'dvups-lang/create':
        Genesis::renderView('dvups_lang.form', $dvups_langCtrl->createAction(), 'error creation', true);
        break;
    case 'dvups-lang/update':
        Genesis::renderView('dvups_lang.form', $dvups_langCtrl->updateAction($_GET['id']), 'error updating', true);
        break;


    case 'dvups-contentlang/index':
        $dvups_contentlangCtrl->listView();
        break;
    case 'dvups-contentlang/create':
        Genesis::renderView('dvups_contentlang.form', $dvups_contentlangCtrl->createAction(), 'error creation', true);
        break;
    case 'dvups-contentlang/update':
        Genesis::renderView('dvups_contentlang.form', $dvups_contentlangCtrl->updateAction($_GET['id']), 'error updating', true);
        break;


    default:
        echo 'la route n\'existe pas!';
        break;
}
