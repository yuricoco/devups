<?php


use dclass\devups\Datatable\Datatable as Datatable;

class NotificationTable extends Datatable
{


    public function __construct($notification = null, $datatablemodel = [])
    {
        parent::__construct($notification, $datatablemodel);
    }

    public static function init(\Notification $notification = null)
    {

        $dt = new NotificationTable($notification);
        $dt->entity = $notification;

        return $dt;
    }

    public function buildindextable()
    {

        $this->base_url = __env."admin/";
        $this->order_by = "this.id desc";
        $this->datatablemodel = [
            ['header' => t('notification.id', '#'), 'value' => 'id'],
            ['header' => t('notification.entity', 'Entity'), 'value' => 'entity'],
            ['header' => t('notification.entityid', 'Entityid'), 'value' => 'entityid'],
            ['header' => t('notification.content', 'Content'), 'value' => 'content']
        ];

        return $this;
    }

    public function buildconfigtable()
    {
        $this->order_by = "this.id desc";
        $this->enabletopaction = false;
        $this->datatablemodel = [
            ['header' => t('notification.id', '#'), 'value' => 'id'],
            ['header' => t('notification.entity', 'Entity'), 'value' => 'entity'],
            ['header' => t('notification.entityid', 'Entityid'), 'value' => 'entityid'],
            ['header' => t('notification.content', 'Content'), 'value' => 'content']
        ];

        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('notification.entity'), 'value' => 'entity'],
            ['label' => t('notification.entityid'), 'value' => 'entityid'],
            ['label' => t('notification.creationdate'), 'value' => 'creationdate'],
            ['label' => t('notification.content'), 'value' => 'content']
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
