<?php


use dclass\devups\Datatable\Datatable;

class DistrictTable extends Datatable{
    
    public $entity = "district";

    public $datatablemodel = [
['header' => 'Name', 'value' => 'name'], 
['header' => 'Town', 'value' => 'Town.id']
];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null){
        $dt = new DistrictTable($lazyloading);
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
['label' => 'Town', 'value' => 'Town.id']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
