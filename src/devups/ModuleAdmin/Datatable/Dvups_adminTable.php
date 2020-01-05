<?php


use DClass\devups\Datatable as Datatable;

class Dvups_adminTable extends Datatable
{

    public $entity = "dvups_admin";

    public $datatablemodel = [
        ['header' => 'nom', 'value' => 'name'],
        ['header' => 'login', 'value' => 'login'],
    ];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null)
    {
        $dt = new Dvups_adminTable($lazyloading);
        return $dt;
    }

    public function buildindextable()
    {
//        $this->datatablemodel = [
//            ['header' => 'nom', 'value' => 'name'],
//            ['header' => 'login', 'value' => 'login'],
//            ['header' => 'password', 'value' => 'password'],
//        ];

        return $this;
    }

}
