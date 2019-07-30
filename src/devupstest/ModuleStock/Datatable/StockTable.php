<?php 


use DClass\devups\Datatable as Datatable;

class StockTable extends Datatable{
    
    public $entity = "stock";

    public $datatablemodel = [
['header' => 'Name', 'value' => 'name']
];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null){
        $dt = new StockTable($lazyloading);
        return $dt;
    }

    public function buildindextable(){

        // TODO: overwrite datatable attribute for this view

        return $this;
    }

}
