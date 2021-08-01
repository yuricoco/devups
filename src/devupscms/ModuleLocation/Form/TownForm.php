<?php 

        
use Genesis as g;

    class TownForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $town = new \Town();
            extract($dataform);
            $entitycore = new Core($town);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $town->getName(), 
            ];

                $entitycore->field['department'] = [
                    "type" => FORMTYPE_SELECT, 
                    "value" => $town->getDepartment()->getId(),
                    "label" => 'Department',
                    "options" => FormManager::Options_Helper('name', Department::allrows()),
                ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Town::classpath('Ressource/js/townForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(TownForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $town = new Town();
                
                return [
                    'success' => true,
                    'town' => $town,
                    'action' => "create",
                ];
            endif;
            
            $town = Town::find($id);
            return [
                'success' => true,
                'town' => $town,
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
            Genesis::renderView("town.formWidget", self::getFormData($id, $action));
        }
        
    }
    