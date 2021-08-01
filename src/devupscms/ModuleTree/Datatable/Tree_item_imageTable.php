<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class Tree_item_imageTable extends Datatable{
    

    public function __construct($tree_item_image = null, $datatablemodel = [])
    {
        parent::__construct($tree_item_image, $datatablemodel);
    }

    public static function init(\Tree_item_image $tree_item_image = null){
    
        $dt = new Tree_item_imageTable($tree_item_image);
        $dt->entity = $tree_item_image;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('tree_item_image.id', '#'), 'value' => 'id'], 
['header' => t('tree_item_image.width_size', 'Width_size'), 'value' => 'width_size'], 
['header' => t('entity.tree_item', 'Tree_item') , 'value' => 'Tree_item.name'], 
['header' => t('entity.dv_image', 'Dv_image') , 'value' => 'Dv_image.reference']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('tree_item_image.width_size'), 'value' => 'width_size'], 
['label' => t('entity.tree_item'), 'value' => 'Tree_item.name'], 
['label' => t('entity.dv_image'), 'value' => 'Dv_image.reference']
];
        // TODO: overwrite datatable attribute for this view
        return $this;
    }

    public function router()
    {
        $tablemodel = Request::get("tablemodel", null);
        if ($tablemodel && method_exists($this, "build" . $tablemodel . "table") && $result = call_user_func(array($this, "build" . $tablemodel . "table"))) {
            return $result;
        } else
            switch ($tablemodel) {
                // case "": return this->
                default:
                    return $this->buildindextable();
            }

    }
    
}
