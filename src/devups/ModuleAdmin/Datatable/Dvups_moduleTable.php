<?php


use dclass\devups\Datatable\Datatable;

class Dvups_moduleTable extends Datatable
{

    public $entity = "dvups_module";

    public $datatablemodel = [
        ['header' => 'Favicon', 'value' => 'printicon'],
        ['header' => 'Name', 'value' => 'name', 'search' => true],
        ['header' => 'Label', 'value' => 'label', 'get' => 'labelform']
    ];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null)
    {
        $dt = new Dvups_moduleTable($lazyloading);
        return $dt;
    }

    public function buildindextable()
    {

        // TODO: overwrite datatable attribute for this view

        return $this;
    }

}
