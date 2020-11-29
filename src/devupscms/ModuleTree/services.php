<?php
//ModuleTree

require '../../../admin/header.php';

// verification token
//

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");


$treeCtrl = new TreeController();
$tree_itemCtrl = new Tree_itemController();

(new Request('hello'));

switch (R::get('path')) {

    case 'tree._new':
        TreeForm::render();
        break;
    case 'tree.create':
        g::json_encode($treeCtrl->createAction());
        break;
    case 'tree._edit':
        TreeForm::render(R::get("id"));
        break;
    case 'tree.update':
        g::json_encode($treeCtrl->updateAction(R::get("id")));
        break;
    case 'tree._show':
        $treeCtrl->detailView(R::get("id"));
        break;
    case 'tree._delete':
        g::json_encode($treeCtrl->deleteAction(R::get("id")));
        break;
    case 'tree._deletegroup':
        g::json_encode($treeCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'tree.datatable':
        g::json_encode($treeCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'tree_item._new':
        Tree_itemForm::render();
        break;
    case 'tree_item.create':
        g::json_encode($tree_itemCtrl->createAction());
        break;
    case 'tree_item._edit':
        Tree_itemForm::render(R::get("id"));
        break;
    case 'tree_item.update':
        g::json_encode($tree_itemCtrl->updateAction(R::get("id")));
        break;
    case 'tree_item._show':
        $tree_itemCtrl->detailView(R::get("id"));
        break;
    case 'tree_item._delete':
        g::json_encode($tree_itemCtrl->deleteAction(R::get("id")));
        break;
    case 'tree_item._deletegroup':
        g::json_encode($tree_itemCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'tree_item.datatable':
        g::json_encode($tree_itemCtrl->datatable(R::get('next'), R::get('per_page')));
        break;


    default:
        g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
        break;
}

