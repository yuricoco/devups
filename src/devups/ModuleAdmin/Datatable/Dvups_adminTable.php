<?php


use dclass\devups\Datatable\Datatable;

class Dvups_adminTable extends Datatable
{

    public $entity = "dvups_admin";

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
        $this->datatablemodel = [
            ['header' => 'nom', 'value' => 'name', 'search' => true],
            ['header' => 'login', 'value' => 'login', 'search' => true],
            ['header' => 'Role', 'value' => 'dvups_role.name'],
        ];

        $this->addcustomaction("callbackbtn");
        return $this;
    }

}
