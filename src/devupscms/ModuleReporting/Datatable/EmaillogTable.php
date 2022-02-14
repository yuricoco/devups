<?php


use dclass\devups\Datatable\Datatable as Datatable;

class EmaillogTable extends Datatable
{


    public function __construct($emaillog = null, $datatablemodel = [])
    {
        parent::__construct($emaillog, $datatablemodel);
    }

    public static function init(\Emaillog $emaillog = null)
    {

        $dt = new EmaillogTable($emaillog);
        $dt->entity = $emaillog;

        return $dt;
    }

    public function buildindextable()
    {

        $this->base_url = __env."admin/";
        $this->order_by =" this.id desc ";
        $this->datatablemodel = [
            ['header' => t('emaillog.id', '#'), 'value' => 'id'],
            ['header' => t('Date'), 'value' => 'createdAt'],
            ['header' => t('emaillog.object', 'Object'), 'value' => 'object'],
            ['header' => t('emaillog.log', 'Log'), 'value' => 'logmessage']
        ];

        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('emaillog.object'), 'value' => 'object'],
            ['label' => t('emaillog.log'), 'value' => 'log']
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
