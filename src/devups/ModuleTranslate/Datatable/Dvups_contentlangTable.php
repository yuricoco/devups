<?php


use dclass\devups\Datatable\Datatable;

class Dvups_contentlangTable extends Datatable
{

    public $entity = "dvups_contentlang";

    public $datatablemodel = [
        ['header' => 'Content', 'value' => 'content', 'search' => true],
        ['header' => 'Lang', 'value' => 'lang', "search"=>true],
        ['header' => 'Dvups_lang', 'value' => 'Dvups_lang.ref', "search"=>true]
    ];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null)
    {
        $dt = new Dvups_contentlangTable($lazyloading);
        return $dt;
    }

    public function buildindextable()
    {

        $this->enablefilter();
        // TODO: overwrite datatable attribute for this view

        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => 'Content', 'value' => 'content'],
            ['label' => 'Lang', 'value' => 'lang'],
            ['label' => 'Dvups_lang', 'value' => 'Dvups_lang.ref']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
