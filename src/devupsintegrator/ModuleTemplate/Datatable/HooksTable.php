<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class HooksTable extends Datatable{
    

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Hooks $hooks = null){
    
        $dt = new HooksTable();
        $dt->entity = $hooks;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('hooks.id', '#'), 'value' => 'id'], 
['header' => t('hooks.label', 'Label'), 'value' => 'label']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('hooks.label'), 'value' => 'label']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
