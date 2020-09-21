<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class MenuTable extends Datatable{
    

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Menu $menu = null){
    
        $dt = new MenuTable();
        $dt->entity = $menu;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('menu.id', '#'), 'value' => 'id'], 
['header' => t('menu.label', 'Label'), 'value' => 'label'], 
['header' => t('entity.page', 'Page') , 'value' => 'Page.label']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('menu.label'), 'value' => 'label'], 
['label' => t('entity.page'), 'value' => 'Page.label']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
