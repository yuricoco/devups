<?php


use dclass\devups\Datatable\Datatable as Datatable;

class MessageTable extends Datatable
{


    public function __construct($message = null, $datatablemodel = [])
    {
        parent::__construct($message, $datatablemodel);
    }

    public static function init(\Message $message = null)
    {

        $dt = new MessageTable($message);
        $dt->entity = $message;

        return $dt;
    }

    public function buildindextable()
    {

        $this->datatablemodel = [
            ['header' => t('message.id', '#'), 'value' => 'id'],
            ['header' => t('message.created_at', 'Created_at'), 'value' => 'createdAt'],
            ['header' => t('message.firstname', 'Firstname'), 'value' => 'firstname'],
            ['header' => t('message.lastname', 'Lastname'), 'value' => 'lastname'],
            ['header' => t('message.email', 'Email'), 'value' => 'email'],
            ['header' => t('message.subject', 'Subject'), 'value' => 'subject'],
            ['header' => t('message.telephone', 'Telephone'), 'value' => 'telephone'],
            ['header' => t('message.message', 'Message'), 'value' => 'message'],
        ];

        $this->order_by = "id desc";
        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('message.id'), 'value' => 'id'],
            ['label' => t('message.firstname'), 'value' => 'firstname'],
            ['label' => t('message.lastname'), 'value' => 'lastname'],
            ['label' => t('message.email'), 'value' => 'email'],
            ['label' => t('message.subject'), 'value' => 'subject'],
            ['label' => t('message.telephone'), 'value' => 'telephone'],
            ['label' => t('message.message'), 'value' => 'message'],
            ['label' => t('message.created_at'), 'value' => 'created_at'],
            ['label' => t('message.updated_at'), 'value' => 'updated_at'],
            ['label' => t('message.deleted_at'), 'value' => 'deleted_at']
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
