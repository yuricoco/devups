<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class Cd_colorTable extends Datatable{
    
    public $entity = "cd_color";

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init($lazyloading = null){
        $dt = new Cd_colorTable($lazyloading);
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('cd_color.color', 'Color'), 'value' => 'color'], 
['header' => t('cd_color.label', 'Label'), 'value' => 'label']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => 'Color', 'value' => 'color'], 
['label' => 'Label', 'value' => 'label']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
