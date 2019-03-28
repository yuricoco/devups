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

    case 'generalinfo.convertphparraytojson':
        g::json_encode(GeneralinfoController::parsedatalangphparraytojson());
        break;
    case 'generalinfo.save':
        g::json_encode(GeneralinfoController::savedata());
        break;

    case 'dvups_lang._new':
        g::json_encode(Dvups_langController::renderForm());
        break;

    case 'dvups_lang._edit':
        g::json_encode(Dvups_langController::renderForm(R::get("id")));
        break;

    case 'dvups_lang._show':
        g::json_encode(Dvups_langController::renderDetail(R::get("id")));
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
        g::json_encode(Dvups_contentlangController::renderForm());
        break;

    case 'dvups_contentlang._edit':
        g::json_encode(Dvups_contentlangController::renderForm(R::get("id")));
        break;

    case 'dvups_contentlang._show':
        g::json_encode(Dvups_contentlangController::renderDetail(R::get("id")));
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

