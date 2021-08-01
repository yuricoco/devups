<?php 

        
use Genesis as g;

class Tree_item_langForm extends FormManager{

    public $tree_item_lang;

    public static function init(\Tree_item_lang $tree_item_lang, $action = ""){
        $fb = new Tree_item_langForm($tree_item_lang, $action);
        $fb->tree_item_lang = $tree_item_lang;
        return $fb;
    }

    public function buildForm()
    {
    
        
            $this->fields['value'] = [
                "label" => t('tree_item_lang.value'), 
"type" => FORMTYPE_TEXT,
            "value" => $this->tree_item_lang->getValue(), 
        ];

        $this->fields['tree_item'] = [
            "type" => FORMTYPE_SELECT, 
            "value" => $this->tree_item_lang->getTree_item()->getId(),
            "label" => t('entity.tree_item'),
            "options" => FormManager::Options_Helper('name', Tree_item::allrows()),
        ];

           
        return  $this;
    
    }

    public static function renderWidget($id = null, $action = "create")
    {
        Genesis::renderView("tree_item_lang.formWidget", self::getFormData($id, $action));
    }
    
}
    