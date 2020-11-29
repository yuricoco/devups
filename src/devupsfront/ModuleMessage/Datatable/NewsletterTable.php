<?php


use dclass\devups\Datatable\Datatable;

class NewsletterTable extends Datatable{
    
    public $entity = "newsletter";

    public $datatablemodel = [
['header' => 'Creationdate', 'value' => 'creationdate'], 
['header' => 'Email', 'value' => 'email']
];

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null){
        $dt = new NewsletterTable($lazyloading);
        return $dt;
    }

    public function buildindextable(){

        // TODO: overwrite datatable attribute for this view

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => 'Creationdate', 'value' => 'creationdate'], 
['label' => 'Email', 'value' => 'email']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
