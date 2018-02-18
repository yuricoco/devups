<?php 

    class CategoryForm extends FormManager{

        public static function formBuilder(\Category $category, $action = null, $button = false) {
            $entitycore = $category->scan_entity_core();
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $category->getName(), 
            ];


            return $entitycore;
        }
        
        public static function __renderForm(\Category $category, $action = null, $button = false) {
            return FormFactory::__renderForm(CategoryForm::formBuilder($category, $action, $button));
        }
        
    }
    