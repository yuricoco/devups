<?php


use dclass\devups\Datatable\Datatable as Datatable;

class StatusTable extends Datatable
{


    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Status $status = null)
    {

        $dt = new StatusTable($status);
        $dt->entity = $status;

        return $dt;
    }

    public function buildindextable()
    {

        // $this->qbcustom = Status::select()->leftjoin("entity");
        $this->topactions[] = '<button type="button" class="btn btn-info" onclick="model.status.sortlist(this)"><i class="fa fa-exchange"></i> Ordonner </button>';;
        $this->datatablemodel = [
            ['header' => t('status.id', '#'), 'value' => 'id'],
            ['header' => t('Entity'), 'value' => 'entity.name'],
            ['header' => t('status.color', 'Color'), 'value' => 'colortab'],
            ['header' => t('status.position', 'Position'), 'value' => 'positionLabel'],
            ['header' => t('status.key', 'Key'), 'value' => '_key'],
            ['header' => t('status.label', 'Label'), 'value' => 'label']
        ];

        $this->addcustomaction(function ($item){
            return "<button class='btn btn-default' onclick='model.clonerow(".$item->getId().", \"status\")'>duplicate</button>";
        });

        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('status.color'), 'value' => 'color'],
            ['label' => t('status.key'), 'value' => 'key'],
            ['label' => t('status.label'), 'value' => 'label']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
