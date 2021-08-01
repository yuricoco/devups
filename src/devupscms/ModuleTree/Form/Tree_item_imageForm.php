<?php 

        
use Genesis as g;

class Tree_item_imageForm extends FormManager{

    public $tree_item_image;

    public static function init(\Tree_item_image $tree_item_image, $action = ""){
        $fb = new Tree_item_imageForm($tree_item_image, $action);
        $fb->tree_item_image = $tree_item_image;
        return $fb;
    }

    public function buildForm()
    {
    
        
            $this->fields['width_size'] = [
                "label" => t('tree_item_image.width_size'), 
			FH_REQUIRE => false,
 			"type" => FORMTYPE_TEXT, 
                "value" => $this->tree_item_image->getWidth_size(), 
        ];

        $this->fields['tree_item'] = [
            "type" => FORMTYPE_SELECT, 
            "value" => $this->tree_item_image->getTree_item()->getId(),
            "label" => t('entity.tree_item'),
            "options" => FormManager::Options_Helper('name', Tree_item::allrows()),
        ];

        $this->fields['dv_image'] = [
            "type" => FORMTYPE_SELECT, 
            "value" => $this->tree_item_image->getDv_image()->getId(),
            "label" => t('entity.dv_image'),
            "options" => FormManager::Options_Helper('reference', Dv_image::allrows()),
        ];

           
        return  $this;
    
    }

    public static function renderWidget($id = null, $action = "create")
    {
        Genesis::renderView("tree_item_image.formWidget", self::getFormData($id, $action));
    }
    
}
    