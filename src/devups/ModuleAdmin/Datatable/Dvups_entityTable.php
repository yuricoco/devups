<?php


use dclass\devups\Datatable\Datatable;

class Dvups_entityTable extends Datatable
{

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
        $this->entity = new  Dvups_entity();
    }

    public static function init(\Dvups_entity $entity = null)
    {
        $dt = new Dvups_entityTable();
        // $dt->entity = $entity;

        return $dt;
    }

    public function buildindextable()
    {

        $this->datatablemodel = [
            ['header' => "#", 'value' => 'id', "order"=>true],
            ['header' => 'Name', 'value' => 'name', 'search' => true],
            ['header' => 'Dvups_module', 'value' => 'Dvups_module.name'],
            ['header' => 'Label', 'value' => 'label', 'get' => 'labelform']
        ];
        $this->enablefilter();

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
