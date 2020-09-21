<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class EncreTable extends Datatable{
    

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Encre $encre = null){
    
        $dt = new EncreTable();
        $dt->entity = $encre;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('encre.id', '#'), 'value' => 'id'], 
['header' => t('entity.menu', 'Menu') , 'value' => 'Menu.label']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('entity.menu'), 'value' => 'Menu.label']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
