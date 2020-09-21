<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class MenuencreTable extends Datatable{
    

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Menuencre $menuencre = null){
    
        $dt = new MenuencreTable();
        $dt->entity = $menuencre;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('menuencre.id', '#'), 'value' => 'id'], 
['header' => t('entity.encre', 'Encre') , 'value' => 'Encre.id'], 
['header' => t('entity.menu', 'Menu') , 'value' => 'Menu.label']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('entity.encre'), 'value' => 'Encre.id'], 
['label' => t('entity.menu'), 'value' => 'Menu.label']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
