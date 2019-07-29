<?php 

        
use Genesis as g;

    class ProductForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $product = new \Product();
            extract($dataform);
            $entitycore = new Core($product);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $product->getName(), 
            ];

            $entitycore->field['price'] = [
                "label" => 'Price', 
			"type" => FORMTYPE_TEXT, 
                "value" => $product->getPrice(), 
            ];

            $entitycore->field['description'] = [
                "label" => 'Description', 
			"type" => FORMTYPE_TEXTAREA, 
                "value" => $product->getDescription(), 
            ];

                $entitycore->field['category'] = [
                    "type" => FORMTYPE_SELECT, 
                    "value" => $product->getCategory()->getId(),
                    "label" => 'Category',
                    "options" => FormManager::Options_Helper('id', Category::allrows()),
                ];

                $entitycore->field['stock'] = [
                    "type" => FORMTYPE_CHECKBOX, 
                    "values" => FormManager::Options_Helper('id', $product->getStock()),
                    "label" => 'Stock',
                    "options" => FormManager::Options_ToCollect_Helper('id', new Stock(), $product->getStock()),
                ];

            
            $entitycore->addDformjs($action);
            $entitycore->addjs(Product::classpath('Ressource/js/productForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(ProductForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $product = new Product();
                
                return [
                    'success' => true,
                    'product' => $product,
                    'action' => "create",
                ];
            endif;
            
            $product = Product::find($id);
            return [
                'success' => true,
                'product' => $product,
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
            Genesis::renderView("product.formWidget", self::getFormData($id, $action));
        }
        
    }
    