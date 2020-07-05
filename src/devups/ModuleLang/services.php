<?php
//ModuleLang

require '../../../admin/header.php';

// verification token
//

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");


$local_content_keyCtrl = new Local_content_keyController();
$local_contentCtrl = new Local_contentController();
$page_mappedCtrl = new Page_mappedController();
$page_local_contentCtrl = new Page_local_contentController();

(new Request('hello'));

switch (R::get('path')) {

    case 'local_content_key._new':
        Local_content_keyForm::render();
        break;
    case 'local_content_key.create':
        g::json_encode($local_content_keyCtrl->createAction());
        break;
    case 'local_content_key._edit':
        Local_content_keyForm::render(R::get("id"));
        break;
    case 'local_content_key.update':
        g::json_encode($local_content_keyCtrl->updateAction(R::get("id")));
        break;
    case 'local_content_key._show':
        $local_content_keyCtrl->detailView(R::get("id"));
        break;
    case 'local_content_key._delete':
        g::json_encode($local_content_keyCtrl->deleteAction(R::get("id")));
        break;
    case 'local_content_key._deletegroup':
        g::json_encode($local_content_keyCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'local_content_key.datatable':
        g::json_encode($local_content_keyCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'local_content._new':
        Local_contentForm::render();
        break;
    case 'local_content.create':
        g::json_encode($local_contentCtrl->createAction());
        break;
    case 'local_content._edit':
        Local_contentForm::render(R::get("id"));
        break;
    case 'local_content.update':
        g::json_encode($local_contentCtrl->updateAction(R::get("id")));
        break;
    case 'local_content._show':
        $local_contentCtrl->detailView(R::get("id"));
        break;
    case 'local_content._delete':
        g::json_encode($local_contentCtrl->deleteAction(R::get("id")));
        break;
    case 'local_content._deletegroup':
        g::json_encode($local_contentCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'local_content.datatable':
        g::json_encode($local_contentCtrl->datatable(R::get('next'), R::get('per_page')));
        break;
    case 'local_content.regeneratecache':
        g::json_encode($local_contentCtrl->regeneratecacheAction());
        break;

    case 'page_mapped._new':
        Page_mappedForm::render();
        break;
    case 'page_mapped.create':
        g::json_encode($page_mappedCtrl->createAction());
        break;
    case 'page_mapped._edit':
        Page_mappedForm::render(R::get("id"));
        break;
    case 'page_mapped.update':
        g::json_encode($page_mappedCtrl->updateAction(R::get("id")));
        break;
    case 'page_mapped._show':
        $page_mappedCtrl->detailView(R::get("id"));
        break;
    case 'page_mapped._delete':
        g::json_encode($page_mappedCtrl->deleteAction(R::get("id")));
        break;
    case 'page_mapped._deletegroup':
        g::json_encode($page_mappedCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'page_mapped.datatable':
        g::json_encode($page_mappedCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'page_local_content._new':
        Page_local_contentForm::render();
        break;
    case 'page_local_content.create':
        g::json_encode($page_local_contentCtrl->createAction());
        break;
    case 'page_local_content._edit':
        Page_local_contentForm::render(R::get("id"));
        break;
    case 'page_local_content.update':
        g::json_encode($page_local_contentCtrl->updateAction(R::get("id")));
        break;
    case 'page_local_content._show':
        $page_local_contentCtrl->detailView(R::get("id"));
        break;
    case 'page_local_content._delete':
        g::json_encode($page_local_contentCtrl->deleteAction(R::get("id")));
        break;
    case 'page_local_content._deletegroup':
        g::json_encode($page_local_contentCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'page_local_content.datatable':
        g::json_encode($page_local_contentCtrl->datatable(R::get('next'), R::get('per_page')));
        break;


    default:
        g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
        break;
}

