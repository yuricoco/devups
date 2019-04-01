<?php
//ModuleTranslate

require '../../../admin/header.php';

global $viewdir;
$viewdir[] = __DIR__ . '/Ressource/views';


define('CHEMINMODULE', ' <a href="index.php" target="_self" class="titre_module">Administration du system global</a> &gt; <a href="index.php?path=layout" target="_self" class="titre_module">Module ModuleTranslate</a> ');


$dvups_langCtrl = new Dvups_langController();
$dvups_contentlangCtrl = new Dvups_contentlangController();

(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderBladeView("layout");
        break;

    case 'generalinfo/index':
        Genesis::renderView('generalinfo.index',  GeneralinfoController::getdata());
        break;

    case 'dvups_lang/changelang':
        setlang(Request::get('lang'));
        redirect("admin");
        break;
    case 'dvups_lang/index':
        Genesis::renderView('dvups_lang.index', $dvups_langCtrl->listAction(), 'list');
        break;
    case 'dvups_lang/create':
        Genesis::renderView('dvups_lang.form', $dvups_langCtrl->createAction(), 'error creation', true);
        break;
    case 'dvups_lang/update':
        Genesis::renderView('dvups_lang.form', $dvups_langCtrl->updateAction($_GET['id']), 'error updating', true);
        break;


    case 'dvups_contentlang/index':
        Genesis::renderView('dvups_contentlang.index', $dvups_contentlangCtrl->listAction(), 'list');
        break;
    case 'dvups_contentlang/create':
        Genesis::renderView('dvups_contentlang.form', $dvups_contentlangCtrl->createAction(), 'error creation', true);
        break;
    case 'dvups_contentlang/update':
        Genesis::renderView('dvups_contentlang.form', $dvups_contentlangCtrl->updateAction($_GET['id']), 'error updating', true);
        break;


    default:
        echo 'la route n\'existe pas!';
        break;
}
