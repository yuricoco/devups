<?php


use dclass\devups\Datatable\Datatable as Datatable;

class EmailmodelTable extends Datatable
{


    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Emailmodel $emailmodel = null)
    {

        $dt = new EmailmodelTable();
        $dt->entity = $emailmodel;

        return $dt;
    }

    public function buildindextable()
    {

        $this->topactions[] = "<a href='" . Emailmodel::classpath("emailmodel/new") . "' class='btn btn-primary'>Create new content</a>";

        $this->datatablemodel = [
            ['header' => t('emailmodel.id', '#'), 'value' => 'id'],
            ['header' => t('emailmodel.object', 'Object'), 'value' => 'object'],
            ['header' => t('emailmodel.content', 'Content'), 'value' => 'test']
        ];

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
