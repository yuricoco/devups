<?php 

        
use Genesis as g;

    class CategoryForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $category = new \Category();
            extract($dataform);
            $entitycore = new Core($category);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $category->getName(), 
            ];

            
            $entitycore->addDformjs($action);
            $entitycore->addjs(Category::classpath('Ressource/js/categoryForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(CategoryForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $category = new Category();
                
                return [
                    'success' => true,
                    'category' => $category,
                    'action' => "create",
                ];
            endif;
            
            $category = Category::find($id);
            return [
                'success' => true,
                'category' => $category,
                'action' => "update&id=" . $id,
            ];

        }
        
        public static function render($id = null, $action = "create")
        {
            g::json_encode(['success' => true,
                'form' => self::__renderForm(self::getFormData($id, $action),true),
            ]);
        }

        public static function renderWidget($id = null, $action = "create")
        {
            Genesis::renderView("category.formWidget", self::getFormData($id, $action));
        }
        
    }
    