<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class Page_mappedTable extends Datatable{
    
    public $entity = "page_mapped";

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null){
        $dt = new Page_mappedTable($lazyloading);
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('page_mapped.base_url', 'Base_url'), 'value' => 'base_url']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => 'Base_url', 'value' => 'base_url']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
