<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class ConfigurationTable extends Datatable{
    

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Configuration $configuration = null){
    
        $dt = new ConfigurationTable();
        $dt->entity = $configuration;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('configuration.id', '#'), 'value' => 'id'], 
['header' => t('configuration._key', '_key'), 'value' => '_key'], 
['header' => t('configuration._value', '_value'), 'value' => '_value'], 
['header' => t('configuration._type', '_type'), 'value' => '_type']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('configuration._key'), 'value' => '_key'], 
['label' => t('configuration._value'), 'value' => '_value'], 
['label' => t('configuration._type'), 'value' => '_type']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
