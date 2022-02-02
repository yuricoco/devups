<?php
//ModuleNotification

require '../../../admin/header.php';

// verification token
//

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");

$notificationCtrl = new NotificationController();
$notificationbroadcastedCtrl = new NotificationbroadcastedController();
$notificationtypeCtrl = new NotificationtypeController();

(new Request('hello'));

switch (R::get('path')) {

    case 'notification._new':
        g::json_encode($notificationCtrl->formView());
        break;
    case 'notification.create':
        g::json_encode($notificationCtrl->createAction());
        break;
    case 'notification.form':
        g::json_encode($notificationCtrl->formView(R::get("id")));
        break;
    case 'notification.update':
        g::json_encode($notificationCtrl->updateAction(R::get("id")));
        break;
    case 'notification._show':
        $notificationCtrl->detailView(R::get("id"));
        break;
    case 'notification._delete':
        g::json_encode($notificationCtrl->deleteAction(R::get("id")));
        break;
    case 'notification._deletegroup':
        g::json_encode($notificationCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'notification.datatable':
        g::json_encode($notificationCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'notificationbroadcasted._new':
        g::json_encode($notificationbroadcastedCtrl->formView());
        break;
    case 'notificationbroadcasted.create':
        g::json_encode($notificationbroadcastedCtrl->createAction());
        break;
    case 'notificationbroadcasted.form':
        g::json_encode($notificationbroadcastedCtrl->formView(R::get("id")));
        break;
    case 'notificationbroadcasted.update':
        g::json_encode($notificationbroadcastedCtrl->updateAction(R::get("id")));
        break;
    case 'notificationbroadcasted._show':
        $notificationbroadcastedCtrl->detailView(R::get("id"));
        break;
    case 'notificationbroadcasted._delete':
        g::json_encode($notificationbroadcastedCtrl->deleteAction(R::get("id")));
        break;
    case 'notificationbroadcasted._deletegroup':
        g::json_encode($notificationbroadcastedCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'notificationbroadcasted.datatable':
        g::json_encode($notificationbroadcastedCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'notificationtype._clonerow':
        g::json_encode($notificationtypeCtrl->cloneAction(Request::get("id")));
        break;
    case 'notificationtype._new':
        g::json_encode($notificationtypeCtrl->formView());
        break;
    case 'notificationtype.create':
        g::json_encode($notificationtypeCtrl->createAction());
        break;
    case 'notificationtype.form':
        g::json_encode($notificationtypeCtrl->formView(R::get("id")));
        break;
    case 'notificationtype.update':
        g::json_encode($notificationtypeCtrl->updateAction(R::get("id")));
        break;
    case 'notificationtype._show':
        $notificationtypeCtrl->detailView(R::get("id"));
        break;
    case 'notificationtype._delete':
        g::json_encode($notificationtypeCtrl->deleteAction(R::get("id")));
        break;
    case 'notificationtype._deletegroup':
        g::json_encode($notificationtypeCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'notificationtype.datatable':
        g::json_encode($notificationtypeCtrl->datatable(R::get('next'), R::get('per_page')));
        break;
    case 'notificationtype.test':
        g::json_encode($notificationtypeCtrl->testnotificationAction(R::get('id'), R::get('number')));
        break;


    default:
        g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
        break;
}

