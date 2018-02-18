<?php 

    class SubcategoryForm extends FormManager{

        public static function formBuilder(\Subcategory $subcategory, $action = null, $button = false) {
            $entitycore = $subcategory->scan_entity_core();
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $subcategory->getName(), 
            ];

                $entitycore->field['category'] = [
                    "type" => FORMTYPE_SELECT, 
                    "value" => $subcategory->getCategory()->getId(),
                    "label" => 'Category',
                    "options" => FormManager::Options_Helper('name', Category::allrows()),
                ];


            return $entitycore;
        }
        
        public static function __renderForm(\Subcategory $subcategory, $action = null, $button = false) {
            return FormFactory::__renderForm(SubcategoryForm::formBuilder($subcategory, $action, $button));
        }
        
    }
    