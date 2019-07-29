<?php


use DClass\devups\Datatable as Datatable;

class ProductTable extends Datatable
{

    protected $entity = "product";

    public $datatablemodel = [
        ['header' => 'Name', 'value' => 'name'],
        ['header' => 'Price', 'value' => 'price'],
        ['header' => 'Description', 'value' => 'description'],
        ['header' => 'Category', 'value' => 'Category.id']
    ];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null)
    {
        $dt = new ProductTable($lazyloading);
        return $dt;
    }

    public function buildindextable()
    {

        // TODO: overwrite datatable attribute for this view

        $this->actionDropdown = false;
        return $this;
    }

}
