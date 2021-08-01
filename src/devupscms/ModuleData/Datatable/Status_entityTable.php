<?php


use dclass\devups\Datatable\Datatable as Datatable;

class Status_entityTable extends Datatable
{


    public function __construct($status_entity = null, $datatablemodel = [])
    {
        parent::__construct($status_entity, $datatablemodel);
    }

    public static function init(\Status_entity $status_entity = null)
    {

        $dt = new Status_entityTable($status_entity);
        $dt->entity = $status_entity;

        return $dt;
    }

    public function buildindextable()
    {

        $this->datatablemodel = [
            ['header' => t('status_entity.id', '#'), 'value' => 'id'],
            ['header' => t('Entity'), 'value' => 'dvups_entity.name'],
            ['header' => t('status_entity.color', 'Color'), 'value' => 'color'],
            ['header' => t('status_entity.position', 'Position'), 'value' => 'position'],
            ['header' => t('entity.status', 'Status'), 'value' => 'Status.color']
        ];

        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('status_entity.color'), 'value' => 'color'],
            ['label' => t('status_entity.position'), 'value' => 'position'],
            ['label' => t('entity.status'), 'value' => 'Status.color']
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
