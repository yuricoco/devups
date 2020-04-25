<?php


use dclass\devups\Datatable\Datatable;

class Dvups_langavailableTable extends Datatable{
    
    public $entity = "dvups_langavailable";

    public $datatablemodel = [
['header' => 'Name', 'value' => 'name']
];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null){
        $dt = new Dvups_langavailableTable($lazyloading);
        return $dt;
    }

    public function buildindextable(){

        // TODO: overwrite datatable attribute for this view

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => 'Name', 'value' => 'name']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
