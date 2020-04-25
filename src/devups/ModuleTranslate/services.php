<?php
//ModuleTranslate

require '../../../admin/header.php';

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");


$dvups_langCtrl = new Dvups_langController();
$dvups_contentlangCtrl = new Dvups_contentlangController();

(new Request('hello'));

switch (Request::get('path')) {

    case 'generalinfo.collectfromsession':
        g::json_encode(GeneralinfoController::newdatafromsessioncollection());
        break;
    case 'generalinfo.convertphparraytojson':
        g::json_encode(GeneralinfoController::parsedatalangphparraytojson());
        break;
    case 'generalinfo.save':
        g::json_encode(GeneralinfoController::savedata());
        break;

    case 'dvups_lang._new':
        Dvups_langForm::render();
        break;

    case 'dvups_lang._edit':
        Dvups_langForm::render(R::get("id"));
        break;

    case 'dvups_lang._delete':
        g::json_encode($dvups_langCtrl->deleteAction(R::get("id")));
        break;

    case 'dvups_lang._deletegroup':
        g::json_encode($dvups_langCtrl->deletegroupAction(R::get("ids")));
        break;

    case 'dvups_lang.datatable':
        g::json_encode($dvups_langCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'dvups_contentlang._new':
        Dvups_contentlangForm::render();
        break;

    case 'dvups_contentlang._edit':
        Dvups_contentlangForm::render(R::get("id"));
        break;

    case 'dvups_contentlang.create':
        g::json_encode($dvups_contentlangCtrl->createAction());
        break;
    case 'dvups_contentlang.update':
        g::json_encode($dvups_contentlangCtrl->updateAction(R::get("id")));
        break;
    case 'dvups_contentlang._delete':
        g::json_encode($dvups_contentlangCtrl->deleteAction(R::get("id")));
        break;

    case 'dvups_contentlang._deletegroup':
        g::json_encode($dvups_contentlangCtrl->deletegroupAction(R::get("ids")));
        break;

    case 'dvups_contentlang.datatable':
        g::json_encode($dvups_contentlangCtrl->datatable(R::get('next'), R::get('per_page')));
        break;


    default:
        echo json_encode("404 : page note found");
        break;
}

