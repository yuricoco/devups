<?php 

    class CategoryForm extends FormManager{

        public static function formBuilder(\Category $category, $action = null, $button = false) {
            $entitycore = new Core($category);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
			"setter" => "namesetter",
                "value" => $category->getName(),
            ];


            return $entitycore;
        }
        
        public static function __renderForm(\Category $category, $action = null, $button = false) {
            return FormFactory::__renderForm(CategoryForm::formBuilder($category, $action, $button));
        }
        
        public static function __renderFormWidget(\Category $category, $action_form = null) {
            include ROOT.Category::classpath()."Form/CategoryFormWidget.php";
        }

        public static function __renderDetailWidget(\Category $category){
            include ROOT . Category::classpath() . "Form/CategoryDetailWidget.php";
        }
    }
    