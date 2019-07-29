<?php


use DClass\devups\Datatable as Datatable;

class Dvups_roleTable extends Datatable
{

    public $entity = "dvups_role";

    public $datatablemodel = [
        ['header' => 'Name', 'value' => 'name'],
        ['header' => 'Alias', 'value' => 'alias']
    ];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null)
    {
        $dt = new Dvups_roleTable($lazyloading);
        return $dt;
    }

    public function buildindextable()
    {

        // TODO: overwrite datatable attribute for this view

        return $this;
    }

}
