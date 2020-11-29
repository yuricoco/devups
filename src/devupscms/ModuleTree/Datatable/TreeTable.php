<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class TreeTable extends Datatable{
    

    public function __construct($lazyloading = null, $datatablemodel = [])
    {
        parent::__construct($lazyloading, $datatablemodel);
    }

    public static function init(\Tree $tree = null){
    
        $dt = new TreeTable();
        $dt->entity = $tree;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('tree.id', '#'), 'value' => 'id'], 
['header' => t('tree.name', 'Name'), 'value' => 'name'], 
['header' => t('tree.description', 'Description'), 'value' => 'description']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('tree.name'), 'value' => 'name'], 
['label' => t('tree.description'), 'value' => 'description']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

}
