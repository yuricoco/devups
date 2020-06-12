<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class Page_local_contentTable extends Datatable{
    
    public $entity = "page_local_content";

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null){
        $dt = new Page_local_contentTable($lazyloading);
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
