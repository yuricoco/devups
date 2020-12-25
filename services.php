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


(new Request('hello'));

switch (Request::get('path')) {

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
    default :
        g::json_encode(["success" => false, "message" => "404 :".Request::get('path')." page note found"]);
        break;
}
