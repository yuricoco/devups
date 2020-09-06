<?php


use dclass\devups\Datatable\Datatable as Datatable;

class Dvups_moduleTable extends Datatable
{


    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Dvups_module $dvups_module = null)
    {

        $dt = new Dvups_moduleTable();
        $dt->entity = $dvups_module;

        return $dt;
    }

    public function buildindextable()
    {

        $this->datatablemodel = [
            ['header' => t('dvups_module.id', '#'), 'value' => 'id'],
            ['header' => 'Favicon', 'value' => 'printicon'],
            ['header' => 'Name', 'value' => 'name', 'search' => true],
            ['header' => 'Label', 'value' => 'label', 'get' => 'labelform']
        ];

        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => t('dvups_module.name'), 'value' => 'name']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
