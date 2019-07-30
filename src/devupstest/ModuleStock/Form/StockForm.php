<?php 

        
use Genesis as g;

    class StockForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $stock = new \Stock();
            extract($dataform);
            $entitycore = new Core($stock);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $stock->getName(), 
            ];

            
            $entitycore->addDformjs($action);
            $entitycore->addjs(Stock::classpath('Ressource/js/stockForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(StockForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $stock = new Stock();
                
                return [
                    'success' => true,
                    'stock' => $stock,
                    'action' => "create",
                ];
            endif;
            
            $stock = Stock::find($id);
            return [
                'success' => true,
                'stock' => $stock,
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
            Genesis::renderView("stock.formWidget", self::getFormData($id, $action));
        }
        
    }
    