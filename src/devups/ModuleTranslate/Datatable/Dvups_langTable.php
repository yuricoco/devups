<?php


use dclass\devups\Datatable\Datatable;

class Dvups_langTable extends Datatable
{

    public $entity = "dvups_lang";

    public $datatablemodel = [
        ['header' => 'Ref', 'value' => 'ref'],
        ['header' => '_table', 'value' => '_table'],
        ['header' => '_column', 'value' => '_column'],
        ['header' => '_row', 'value' => '_row'],
    ];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null)
    {
        $dt = new Dvups_langTable($lazyloading);
        return $dt;
    }

    public function buildindextable()
    {

        // TODO: overwrite datatable attribute for this view

        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => 'Ref', 'value' => 'ref'],
            ['label' => 'Content', 'value' => 'content'],
            ['label' => '_table', 'value' => '_table'],
            ['label' => '_column', 'value' => '_column'],
            ['label' => 'Lang', 'value' => 'lang']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
