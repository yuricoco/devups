<?php 


use DClass\devups\Datatable as Datatable;

class CategoryTable extends Datatable{
    
    public $entity = "category";

    public $datatablemodel = [
['header' => 'Name', 'value' => 'name']
];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null){
        $dt = new CategoryTable($lazyloading);
        return $dt;
    }

    public function buildindextable(){

        // TODO: overwrite datatable attribute for this view

        return $this;
    }

}
