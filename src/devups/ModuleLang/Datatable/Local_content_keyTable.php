<?php


use dclass\devups\Datatable\Datatable as Datatable;

class Local_content_keyTable extends Datatable
{

    public $entity = "local_content_key";

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null)
    {
        $dt = new Local_content_keyTable($lazyloading);
        return $dt;
    }

    public function buildindextable()
    {

        $this->datatablemodel = [
            ['header' => t('local_content_key.reference', 'Reference'), 'value' => 'reference']
        ];

        $this->per_page = 50;
        return $this;
    }

    public function builddetailtable()
    {
        $this->datatablemodel = [
            ['label' => 'Reference', 'value' => 'reference']
        ];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
