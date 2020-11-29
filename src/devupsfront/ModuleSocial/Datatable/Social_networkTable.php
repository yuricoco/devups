<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class Social_networkTable extends Datatable{
    
    public $entity = "social_network";

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null){
        $dt = new Social_networkTable($lazyloading);
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('social_network.name', 'Name'), 'value' => 'name'], 
['header' => t('social_network.logo', 'Logo'), 'value' => 'src:logo'], 
['header' => t('social_network.logo', 'Logo'), 'value' => 'logo']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => 'Name', 'value' => 'name'], 
['label' => 'Logo', 'value' => 'src:logo'], 
['label' => 'Logo', 'value' => 'logo']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
