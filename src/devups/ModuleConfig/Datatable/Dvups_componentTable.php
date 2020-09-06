<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class Dvups_componentTable extends Datatable{
    

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Dvups_component $dvups_component = null){
    
        $dt = new Dvups_componentTable();
        $dt->entity = $dvups_component;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('dvups_component.id', '#'), 'value' => 'id'], 
['header' => t('dvups_component.name', 'Name'), 'value' => 'name']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('dvups_component.name'), 'value' => 'name']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
