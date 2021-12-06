<?php


namespace devupscms\ModuleTree;

use Genesis as g;
use Request as R;
use Dvups_module;
use Genesis;
use Request;
use Tree_item;
use Tree_item_imageController;
use Tree_itemFrontController;
use TreeFrontController;

class ModuleTree
{

    public $moduledata;

    public function __construct()
    {

    }

    public function web()
    {

        $this->moduledata = Dvups_module::init('ModuleData');

        $activity_sectorCtrl = new Activity_sectorController();


        (new Request('layout'));

        switch (Request::get('path')) {

            case 'layout':
                Genesis::renderView("overview");
                break;

            default:
                Genesis::renderView('404', ['page' => Request::get('path')]);
                break;
        }
    }

    public function services()
    {

        $activity_sectorCtrl = new Activity_sectorController();

        (new Request('hello'));

        switch (R::get('path')) {

            default:
                g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
                break;
        }
    }

    public function webservices()
    {

        $treeitemCtrl = new Tree_itemFrontController();
        $treeCtrl = new TreeFrontController();

        (new Request('hello'));

        switch (R::get('path')) {

            case 'tree.create':
                g::json_encode($treeCtrl->createAction());
                break;
            case 'tree.update':
                g::json_encode($treeCtrl->updateAction(Request::get("id")));
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
            case 'tree-item-image.upload':
                g::json_encode((new Tree_item_imageController())->uploadAction(Request::get('tree_item_id')));
                break;
            case 'tree-item-image.delete':
                g::json_encode((new Tree_item_imageController())->deleteAction(Request::get('id')));
                break;
            case 'tree-item.images':
                g::json_encode((new Tree_item(Request::get('id')))->images());
                break;
            case 'tree-item.getdata':
            case 'tree-items.getdata':
            case 'tree-item.init':
                g::json_encode($treeitemCtrl->getdata());
                break;
            case 'tree-item.getchildren':
                g::json_encode($treeitemCtrl->getchildren(Request::get("id")));
                break;

        }
    }

}