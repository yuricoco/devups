<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class BlockTable extends Datatable{
    

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Block $block = null){
    
        $dt = new BlockTable();
        $dt->entity = $block;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('block.id', '#'), 'value' => 'id'], 
['header' => t('block.label', 'Label'), 'value' => 'label']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('block.label'), 'value' => 'label']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
