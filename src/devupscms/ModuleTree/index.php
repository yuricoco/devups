<?php
//ModuleTree

require '../../../admin/header.php';

// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {
    header("location: " . __env . 'admin/login.php');
}

global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Resource/views';

$moduledata = Dvups_module::init('ModuleTree');

$treeCtrl = new TreeController();
$tree_itemCtrl = new Tree_itemController();


(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        $treeCtrl->managerView();
        //Genesis::renderView("");
        break;

    case 'tree/index':
        $treeCtrl->listView();
        break;
    case 'tree/manager':
        $treeCtrl->managerView();
        break;

    case 'tree-item/index':
        $tree_itemCtrl->listView();
        break;


    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
    