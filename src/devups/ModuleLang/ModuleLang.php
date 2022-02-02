<?php


namespace devups\ModuleLang;


use Dvups_module;
use Genesis as g;
use Local_content;
use Local_content_keyController;
use Local_content_keyForm;
use Local_content_keyFrontController;
use Local_contentController;
use Local_contentForm;
use Local_contentFrontController;
use Page_local_contentController;
use Page_local_contentForm;
use Page_mappedController;
use Page_mappedForm;
use Request;
use Request as R;

class ModuleLang
{

    public $moduledata;

    public function __construct()
    {

    }

    public function web()
    {

        $this->moduledata = Dvups_module::init('ModuleLang');


        (new Request('layout'));

        switch (Request::get('path')) {

            case 'layout':
                g::renderView("overview");
                break;

            default:
                g::renderView('404', ['page' => Request::get('path')]);
                break;
        }
    }

    public static function services($path)
    {

        header("Access-Control-Allow-Origin: *");

        $local_content_keyCtrl = new Local_content_keyController();
        $local_contentCtrl = new Local_contentController();
        $page_mappedCtrl = new Page_mappedController();
        $page_local_contentCtrl = new Page_local_contentController();

        switch ($path) {

            case 'local-content.get':
                g::json_encode(Local_content_keyFrontController::i()->ll());
                break;
            case 'local-content.getlang':
                g::json_encode( Local_content::getDataLang(Request::get('id')));
                break;
            case 'local-content.update':
                g::json_encode( Local_content::updateLang());
                break;

            case 'local_content_key._new':
                Local_content_keyForm::render();
                break;
            case 'local_content_key.create':
                g::json_encode($local_content_keyCtrl->createAction());
                break;
            case 'local_content_key.form':
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
            case 'local_content.form':
                Local_contentForm::render(R::get("id"));
                break;
            case 'local_content.update':
                g::json_encode($local_contentCtrl->updateAction(R::get("id")));
                break;
            case 'local_content._show':
                $local_contentCtrl->detailView(R::get("id"));
                break;
            case 'local_content.delete':
                g::json_encode($local_contentCtrl->deleteAction(R::get("id")));
                break;
            case 'local_content.deletegroup':
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
            case 'page_mapped.form':
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
            case 'page_local_content.form':
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

            case 'local-content.edit':
                global $viewdir;
                $viewdir[] = Local_content::classroot("Ressource/views");
                g::json_encode(Local_contentForm::renderWidgetFront(Request::get("ref")));
                break;

            case 'local-content.update':
                g::json_encode((new Local_contentFrontController())->updateAction(Request::get("id")));
                break;
            case 'local-content.regeneratecache':
                g::json_encode((new Local_contentFrontController())->regeneratecacheAction());
                break;

            default:
                Request::service(Request::get('path'));
                break;
        }
    }

    public function webservices()
    {

        $local_contentCtrl = new \Local_contentFrontController();

        (new Request('hello'));

        switch (Request::get('path')) {

            case 'local_content._new':
                Local_contentForm::render();
                break;
            case 'local_content.create':
                g::json_encode($local_contentCtrl->createAction());
                break;
            case 'local_content.form':
                Local_contentForm::render(Request::get("id"));
                break;
            case 'local_content.update':
                g::json_encode($local_contentCtrl->updateAction(Request::get("id")));
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

        }
    }

}