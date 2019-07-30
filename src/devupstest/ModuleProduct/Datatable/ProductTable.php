<?php


use DClass\devups\Datatable as Datatable;

class ProductTable extends Datatable
{

    public $entity = "product";

    public $datatablemodel = [
        ['header' => 'Name', 'value' => 'name', 'search' => true, 'order' => true],
        ['header' => 'Price', 'value' => 'price', 'order' => true],
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

        $this->searchaction = true;
        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => 'Name', 'value' => 'name'],
            ['label' => 'Price', 'value' => 'price'],
            ['label' => 'Description', 'value' => 'description'],
            ['label' => 'Category', 'value' => 'Category.name']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

    public function buildfronttable()
    {
        // TODO: overwrite datatable attribute for this view

        $this->isFrontEnd = true;
        $this->searchaction = true;
        return $this;
    }

}
