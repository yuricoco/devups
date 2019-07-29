<?php 


use DClass\devups\Datatable as Datatable;

class Dvups_entityTable extends Datatable{
    
    public $entity = "dvups_entity";

    public $datatablemodel = [
        ['header' => 'Name', 'value' => 'name'],
        ['header' => 'Dvups_module', 'value' => 'Dvups_module.name'],
        ['header' => 'Label', 'value' => 'label', 'get' => 'labelform']
    ];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null){
        $dt = new Dvups_entityTable($lazyloading);
        return $dt;
    }

    public function buildindextable(){

        // TODO: overwrite datatable attribute for this view

        return $this;
    }

}
