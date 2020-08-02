<?php


use dclass\devups\Datatable\Datatable;

class Dvups_moduleTable extends Datatable
{

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
        $this->entity = new  Dvups_module();
    }

    public static function init(\Dvups_module $entity = null)
    {
        $dt = new Dvups_moduleTable();
        // $dt->entity = $entity;

        return $dt;
    }

    public function buildindextable()
    {

        // TODO: overwrite datatable attribute for this view
        $this->datatablemodel = [
            ['header' => 'Favicon', 'value' => 'printicon'],
            ['header' => 'Name', 'value' => 'name', 'search' => true],
            ['header' => 'Label', 'value' => 'label', 'get' => 'labelform']
        ];

        return $this;
    }

    public function render()
    {
        $this->lazyloading($this->entity);
        return parent::render();
    }

    public function getTableRest($datatablemodel = [])
    {
        $this->lazyloading($this->entity);
        return parent::getTableRest();
    }

}
