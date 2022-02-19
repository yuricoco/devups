<?php


use dclass\devups\Datatable\Datatable as Datatable;

class NotificationbroadcastedTable extends Datatable
{


    public function __construct($notificationbroadcasted = null, $datatablemodel = [])
    {
        parent::__construct($notificationbroadcasted, $datatablemodel);
    }

    public static function init(\Notificationbroadcasted $notificationbroadcasted = null)
    {

        $dt = new NotificationbroadcastedTable($notificationbroadcasted);
        $dt->entity = $notificationbroadcasted;

        return $dt;
    }

    public function buildindextable()
    {

        $this->base_url = __env."admin/";
        $this->order_by = " this.id desc";
        $this->datatablemodel = [
            ['header' => t('#'), 'value' => 'id'],
            ['header' => t('User'), 'value' => 'user.email'],
            ['header' => t('Admin'), 'value' => 'admin.name'],
            ['header' => t('Viewedat'), 'value' => 'viewedat'],
            ['header' => t('Status'), 'value' => 'status'],
            ['header' => t('Notification'), 'value' => 'Notification.entity']
        ];
        $this->setModel("buil");
        return $this;
    }
    public function buildcustomertable()
    {

        $this->groupaction = false;
        $this->enabletopaction = false;
        $this->searchaction = false;
        $this->enablecolumnaction = false;
        $this->base_url = __env."api/";
        $this->datatablemodel = [
            //['header' => t('#'), 'value' => 'id'],
            ['header' => t('Status'), 'value' => 'status'],
            ['header' => t('Viewedat'), 'value' => 'viewedat'],
            ['header' => t('Notification'), 'value' => function(\Notificationbroadcasted $item){
                return $item->notification->getContent();
            }]
        ];
        $this->setModel("customer");
        return $this;
    }
    public function builddashboardtable()
    {

        $this->order_by = "this.id desc";
        $this->groupaction = false;
        $this->disablepagination();
        $this->enabletopaction = false;
        $this->searchaction = false;
        $this->enablecolumnaction = false;
        $this->base_url = Notification::classpath("services.php?path=");
        $this->datatablemodel = [
            //['header' => t('#'), 'value' => 'id'],
            // ['header' => t('Status'), 'value' => 'status'],
            ['header' => t('Viewedat'), 'value' => 'viewedat'],
            ['header' => t('Notification'), 'value' => function(\Notificationbroadcasted $item){
                return $item->notification->getContent();
            }]
        ];
        $this->setModel("dashboard");
        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('notificationbroadcasted.viewedat'), 'value' => 'viewedat'],
            ['label' => t('notificationbroadcasted.status'), 'value' => 'status'],
            ['label' => t('entity.notification'), 'value' => 'Notification.entity']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

    public function router()
    {
        $tablemodel = Request::get("tablemodel", null);
        if ($tablemodel && method_exists($this, "build" . $tablemodel . "table") && $result = call_user_func(array($this, "build" . $tablemodel . "table"))) {
            return $result;
        } else
            switch ($tablemodel) {
                // case "": return this->
                default:
                    return $this->buildindextable();
            }

    }

}
