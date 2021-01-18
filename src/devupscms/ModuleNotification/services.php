<?php
//ModuleNotification

require '../../../admin/header.php';

// verification token
//

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");


$emailmodelCtrl = new EmailmodelController();
$notificationCtrl = new NotificationController();
$notificationbroadcastedCtrl = new NotificationbroadcastedController();

(new Request('hello'));

switch (R::get('path')) {

    case 'emailmodel._new':
        EmailmodelForm::render();
        break;
    case 'emailmodel.testmail':
        g::json_encode($emailmodelCtrl->testmailAction(R::get("id"), R::get("email")));
        break;
    case 'emailmodel.create':
        g::json_encode($emailmodelCtrl->createAction());
        break;
    case 'emailmodel._edit':
        EmailmodelForm::render(R::get("id"));
        break;
    case 'emailmodel.update':
        g::json_encode($emailmodelCtrl->updateAction(R::get("id")));
        break;
    case 'emailmodel._show':
        $emailmodelCtrl->detailView(R::get("id"));
        break;
    case 'emailmodel._delete':
        g::json_encode($emailmodelCtrl->deleteAction(R::get("id")));
        break;
    case 'emailmodel._deletegroup':
        g::json_encode($emailmodelCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'emailmodel.datatable':
        g::json_encode($emailmodelCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'notification._new':
        NotificationForm::render();
        break;
    case 'notification.create':
        g::json_encode($notificationCtrl->createAction());
        break;
    case 'notification._edit':
        NotificationForm::render(R::get("id"));
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
        NotificationbroadcastedForm::render();
        break;
    case 'notificationbroadcasted.create':
        g::json_encode($notificationbroadcastedCtrl->createAction());
        break;
    case 'notificationbroadcasted._edit':
        NotificationbroadcastedForm::render(R::get("id"));
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


    default:
        g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
        break;
}

