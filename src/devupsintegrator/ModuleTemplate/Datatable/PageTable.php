<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class PageTable extends Datatable{
    

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Page $page = null){
    
        $dt = new PageTable();
        $dt->entity = $page;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('page.id', '#'), 'value' => 'id'], 
['header' => t('page.label', 'Label'), 'value' => 'label']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('page.label'), 'value' => 'label']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
