<?php


use dclass\devups\Datatable\Datatable as Datatable;

class NotificationbroadcastedTable extends Datatable
{

    public $entity = "notificationbroadcasted";

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null)
    {
        $dt = new NotificationbroadcastedTable($lazyloading);
        return $dt;
    }

    public function buildindextable()
    {

        $this->datatablemodel = [
            ['header' => t('notificationbroadcasted.viewedat', 'Viewedat'), 'value' => 'viewedat'],
            ['header' => t('notificationbroadcasted.status', 'Status'), 'value' => 'status'],
            ['header' => t('entity.notification', 'Notification'), 'value' => 'Notification.entity'],
            ['header' => t('entity.user', 'User'), 'value' => 'User.firstname']
        ];

        return $this;
    }
    public function buildindexfronttable()
    {

        $this->disableColumnAction();
        $this->disableDefaultaction();

        $this->datatablemodel = [
            ['header' => "#", 'value' => 'id'],
            ['header' => t('Date'), 'value' => 'createdAt'],
            ['header' => t('entity.notification', 'Notification'), 'value' => 'Notification.content'],
        ];

        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => 'Viewedat', 'value' => 'viewedat'],
            ['label' => 'Status', 'value' => 'status'],
            ['label' => 'Notification', 'value' => 'Notification.entity'],
            ['label' => 'User', 'value' => 'User.firstname']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
