<?php


use dclass\devups\Datatable\Datatable as Datatable;

class ReportingmodelTable extends Datatable
{


    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Reportingmodel $emailmodel = null)
    {

        $dt = new ReportingmodelTable(new Reportingmodel());
        $dt->entity = $emailmodel;

        return $dt;
    }

    public function buildindextable()
    {

        $this->base_url = __env."admin/";
        // $this->topactions[] = "<a href='" . Reportingmodel::classpath("emailmodel/new") . "' class='btn btn-primary'>Create new content</a>";

        $this->datatablemodel = [
            ['header' => t('emailmodel.id', '#'), 'value' => 'id'],
            ['header' => t('Name'), 'value' => 'name'],
            // ['header' => t('Type'), 'value' => 'type'],
            ['header' => t('emailmodel.object', 'Object'), 'value' => 'object'],
            ['header' => t('Description'), 'value' => 'description'],
            ['header' => t('emailmodel.content', 'Content'), 'value' => 'test']
        ];

        $this->addcustomaction(function ($item){

            return '<a class="btn btn-warning btn-block"  href="' . Reportingmodel::classpath("reportingmodel/edit-email?id=") . $item->id . '">Edit email</a>';

        });
        $this->addcustomaction(function ($item){
            return "<button class='btn btn-default btn-block' onclick='model.clonerow(".$item->getId().", \"reportingmodel\")'>duplicate</button>";
        });
        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('emailmodel.object'), 'value' => 'object'],
            ['label' => t('emailmodel.contenttext'), 'value' => 'contenttext'],
            ['label' => t('emailmodel.content'), 'value' => 'preview']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
