<?php


namespace devupscms\ModuleNotification;

use Genesis as g;
use Request as R;
use Dvups_module;
use Genesis;
use Request;
use Tree_item;
use Tree_item_imageController;
use Tree_itemFrontController;
use TreeFrontController;

class ModuleNotification
{

    public $moduledata;

    public function __construct()
    {

    }

    public function web()
    {

        $this->moduledata = Dvups_module::init('ModuleData');

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

        (new Request('hello'));

        switch (R::get('path')) {

            default:
                g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
                break;
        }
    }

    public function webservices()
    {

        (new Request('hello'));

        switch (R::get('path')) {

            case 'notified':
                g::json_encode((new \NotificationController())->notifiedAction());
                break;
            case 'notificationbroadcasted.alert':
                g::json_encode((new \NotificationController())->alertAction());
                break;
            case 'notificationbroadcasted.alertuser':
                g::json_encode((new \NotificationController())->alertAction("user"));
                break;

        }
    }

}