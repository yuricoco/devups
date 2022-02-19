<?php


use dclass\devups\Controller\Controller;

class NotificationController extends Controller
{

    public function listView($next = 1, $per_page = 10)
    {

        $this->datatable = NotificationTable::init(new Notification())->buildindextable();

        self::$jsfiles[] = Notification::classpath('Resource/js/notificationCtrl.js');

        $this->entitytarget = 'Notification';
        $this->title = "Manage Notification";

        $this->renderListView();

    }

    public function datatable($next, $per_page)
    {

        return ['success' => true,
            'datatable' => NotificationTable::init(new Notification())->router()->getTableRest(),
        ];

    }

    public function formView($id = null)
    {
        $notification = new Notification();
        $action = Notification::classpath("services.php?path=notification.create");
        if ($id) {
            $action = Notification::classpath("services.php?path=notification.update&id=" . $id);
            $notification = Notification::find($id);
        }

        return ['success' => true,
            'form' => NotificationForm::init($notification, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];
    }

    public function createAction($notification_form = null)
    {
        extract($_POST);

        $notification = $this->form_fillingentity(new Notification(), $notification_form);
        if ($this->error) {
            return array('success' => false,
                'notification' => $notification,
                'action' => 'create',
                'error' => $this->error);
        }


        $id = $notification->__insert();
        return array('success' => true,
            'notification' => $notification,
            'tablerow' => NotificationTable::init()->router()->getSingleRowRest($notification),
            'detail' => '');

    }

    public function updateAction($id, $notification_form = null)
    {
        extract($_POST);

        $notification = $this->form_fillingentity(new Notification($id), $notification_form);

        if ($this->error) {
            return array('success' => false,
                'notification' => $notification,
                'action_form' => 'update&id=' . $id,
                'error' => $this->error);
        }

        $notification->__update();
        return array('success' => true,
            'notification' => $notification,
            'tablerow' => NotificationTable::init()->router()->getSingleRowRest($notification),
            'detail' => '');

    }


    public function detailView($id)
    {

        $this->entitytarget = 'Notification';
        $this->title = "Detail Notification";

        $notification = Notification::find($id);

        $this->renderDetailView(
            NotificationTable::init()
                ->builddetailtable()
                ->renderentitydata($notification)
        );

    }

    public function deleteAction($id)
    {

        Notification::delete($id);

        return array('success' => true,
            'detail' => '');
    }


    public function deletegroupAction($ids)
    {

        Notification::where("id")->in($ids)->delete();

        return array('success' => true,
            'detail' => '');

    }

    public function notifiedAction()
    {

        $ids = Request::post("ids");
        Notificationbroadcasted::where("this.id")->in($ids)->update([
            "status" => 1,
            "ping" => 0,
        ]);

        return array('success' => true,
            'detail' => '');

    }

    public function alertAction($session = "admin")
    {

        if ($session == "admin") {
            $notifications = Notificationbroadcasted::where("this.created_at", ">", Request::get("date"))
                ->where("admin.id", Request::get("adminid"))
                ->where("ping", 1)
                ->get();
            $unreaded = Notificationbroadcasted::where("admin.id", Request::get("adminid"))
                ->where("status", "=", 0)
                ->count();

            if (count($notifications))
                Notificationbroadcasted::where("admin.id", Request::get("adminid"))
                    //->where("ping", 1)
                    ->update([
                        "ping" => 0
                    ]);
        }else{
            $notifications = Notificationbroadcasted::where("this.created_at", ">", Request::get("date"))
                ->where("user.id", Request::get("user_id"))
                ->where("ping", 1)
                ->get();
            $unreaded = Notificationbroadcasted::where("user.id", Request::get("user_id"))
                ->where("status", "=", 0)
                ->count();

            if (count($notifications))
                Notificationbroadcasted::where("user.id", Request::get("user_id"))
                    //->where("ping", 1)
                    ->update([
                        "ping" => 0
                    ]);
        }
        return array('success' => true,
            'notifications' => $notifications,
            'unreaded' => $unreaded,
            'detail' => '');

    }

}
