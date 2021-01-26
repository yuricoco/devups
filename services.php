<?php

global $_start;
$_start = microtime(true);

require __DIR__ . '/header.php';

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");

$storageCtrl = new StorageFrontController();
$treeCtrl = new TreeFrontController();
$treeitemCtrl = new Tree_itemFrontController();
$local_contentCtrl = new Local_contentController();
$dv_imageCtrl = new Dv_imageController();


(new Request('hello'));

switch (Request::get('path')) {

    case 'uploadfile':
        $result = Dfile::init("image")
            ->sanitize()
            ->moveto("test");

        g::json_encode($result);
        break;

    case 'lazyloading':
        g::json_encode((new dclass\devups\Controller\Controller())->ll());
        break;

    case 'test.webservice': // test.webservice
        g::json_encode(Local_content::select()->__getAll(true, []));
        break;

    case 'tree.create':
        g::json_encode($treeCtrl->createAction());
        break;
    case 'tree-item.create':
        g::json_encode($treeitemCtrl->createAction());
        break;
    case 'tree-item.detail':
        g::json_encode($treeitemCtrl->detailAction(Request::get('id')));
        break;
    case 'tree.lazyloading':
        g::json_encode((new TreeFrontController())->ll());
        break;
    case 'tree-item.lazyloading':
        g::json_encode($treeitemCtrl->ll());
        break;
    case 'tree-item.update':
        g::json_encode($treeitemCtrl->updateAction(Request::get('id')));
        break;
    case 'tree-item.order':
        g::json_encode($treeitemCtrl->orderAction());
        break;
    case 'tree-item.addcontent':
        g::json_encode($treeitemCtrl->addcontentAction());
        break;
    case 'tree-item.delete':
        g::json_encode($treeitemCtrl->deleteAction(Request::get('id')));
        break;

    case 'tree-item.getdatafront':
        g::json_encode($treeitemCtrl->getdatafront());
        break;
    case 'tree-item.getdata':
    case 'tree-items.getdata':
    case 'tree-item.init':
        g::json_encode($treeitemCtrl->getdata());
        break;
    case 'tree-item.getchildren':
        g::json_encode($treeitemCtrl->getchildren(Request::get("id")));
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

    case 'dv_image._new':
        Dv_imageForm::render();
        break;
    case 'dv_image.create':
        g::json_encode($dv_imageCtrl->createAction());
        break;
    case 'dv_image._edit':
        Dv_imageForm::render(R::get("id"));
        break;
    case 'dv_image.update':
        g::json_encode($dv_imageCtrl->updateAction(R::get("id")));
        break;
    case 'dv_image._show':
        $dv_imageCtrl->detailView(R::get("id"));
        break;
    case 'dv_image._delete':
        g::json_encode($dv_imageCtrl->deleteAction(R::get("id")));
        break;
    case 'dv_image._deletegroup':
        g::json_encode($dv_imageCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'dv_image.datatable':
        g::json_encode($dv_imageCtrl->datatable(R::get('next'), R::get('per_page')));
        break;
    default :
        g::json_encode(["success" => false, "message" => "404 :".Request::get('path')." page note found"]);
        break;
}
