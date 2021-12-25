<?php


use dclass\devups\Datatable\Datatable;

class DepartmentTable extends Datatable{
    
    public $entity = "department";

    public $datatablemodel = [
['header' => 'Name', 'value' => 'name'], 
['header' => 'Region', 'value' => 'Region.id']
];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null){
        $dt = new DepartmentTable($lazyloading);
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
['label' => 'Region', 'value' => 'Region.id']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
