<?php


use dclass\devups\Datatable\Datatable;

class TownTable extends Datatable{
    
    public $entity = "town";

    public $datatablemodel = [
['header' => 'Name', 'value' => 'name'], 
['header' => 'Department', 'value' => 'Department.id']
];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null){
        $dt = new TownTable($lazyloading);
        return $dt;
    }

    public function buildindextable(){

        // TODO: overwrite datatable attribute for this view

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => 'Name', 'value' => 'name'], 
['label' => 'Department', 'value' => 'Department.id']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
