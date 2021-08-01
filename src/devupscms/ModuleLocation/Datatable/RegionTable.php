<?php


use dclass\devups\Datatable\Datatable;

class RegionTable extends Datatable{
    
    public $entity = "region";

    public $datatablemodel = [
['header' => 'Name', 'value' => 'name'], 
['header' => 'Country', 'value' => 'Country.name']
];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null){
        $dt = new RegionTable($lazyloading);
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
['label' => 'Country', 'value' => 'Country.name']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
