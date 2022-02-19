<?php


use dclass\devups\Datatable\Datatable as Datatable;

class NotificationtypeTable extends Datatable
{


    public function __construct($notificationtype = null, $datatablemodel = [])
    {
        parent::__construct($notificationtype, $datatablemodel);
    }

    public static function init(\Notificationtype $notificationtype = null)
    {

        $dt = new NotificationtypeTable($notificationtype);
        $dt->entity = $notificationtype;

        return $dt;
    }

    public function buildindextable()
    {

        $this->base_url = __env."admin/";
        $this->datatablemodel = [
            ['header' => t('notificationtype.id', '#'), 'value' => 'id'],
            ['header' => t('Entity'), 'value' => 'dvups_entity.name'],
            ['header' => t('notificationtype._key', '_key'), 'value' => '_key'],
            ['header' => t('notificationtype.content', 'Content'), 'value' => 'content'],
            ['header' => 'Test', 'value' => 'test']
        ];
        $this->addcustomaction(function ($item){
            return "<button class='btn btn-default btn-block' onclick='model.clonerow(".$item->getId().", \"notificationtype\")'>duplicate</button>";
        });

        return $this;
    }

    public function buildconfigtable()
    {

        $this->enabletopaction = false;
        $this->datatablemodel = [
            ['header' => t('notificationtype.id', '#'), 'value' => 'id'],
            ['header' => t('Entity'), 'value' => 'dvups_entity.name'],
            ['header' => t('notificationtype._key', '_key'), 'value' => '_key'],
            ['header' => t('notificationtype.content', 'Content'), 'value' => 'content'],
            //['header' => t('Redirect'), 'value' => 'redirection'],
            ['header' => 'Test', 'value' => 'test']

        ];

        /*$this->addcustomaction(function ($item){

        });*/

        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('notificationtype._key'), 'value' => '_key'],
            ['label' => t('notificationtype.content'), 'value' => 'content']
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
