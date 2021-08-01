<?php 


use dclass\devups\Datatable\Datatable as Datatable;

class Tree_item_langTable extends Datatable{
    

    public function __construct($tree_item_lang = null, $datatablemodel = [])
    {
        parent::__construct($tree_item_lang, $datatablemodel);
    }

    public static function init(\Tree_item_lang $tree_item_lang = null){
    
        $dt = new Tree_item_langTable($tree_item_lang);
        $dt->entity = $tree_item_lang;
        
        return $dt;
    }

    public function buildindextable(){

        $this->datatablemodel = [
['header' => t('tree_item_lang.id', '#'), 'value' => 'id'], 
['header' => t('tree_item_lang.value', 'Value'), 'value' => 'value'], 
['header' => t('entity.tree_item', 'Tree_item') , 'value' => 'Tree_item.name']
];

        return $this;
    }
    
    public function builddetailtable()
    {
        $this->datatablemodel = [
['label' => t('tree_item_lang.value'), 'value' => 'value'], 
['label' => t('entity.tree_item'), 'value' => 'Tree_item.name']
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
