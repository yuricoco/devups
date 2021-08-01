<?php 

        
use Genesis as g;

    class Cd_colorForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $cd_color = new \Cd_color();
            extract($dataform);
            $entitycore = new Core($cd_color);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['color'] = [
                "label" => 'Color', 
			"type" => FORMTYPE_TEXT, 
                "value" => $cd_color->getColor(), 
            ];

            $entitycore->field['label'] = [
                "label" => 'Label', 
			"type" => FORMTYPE_TEXT, 
                "value" => $cd_color->getLabel(), 
            ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Cd_color::classpath('Ressource/js/cd_colorForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(Cd_colorForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $cd_color = new Cd_color();
                
                return [
                    'success' => true,
                    'cd_color' => $cd_color,
                    'action' => "create",
                ];
            endif;
            
            $cd_color = Cd_color::find($id);
            return [
                'success' => true,
                'cd_color' => $cd_color,
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
            Genesis::renderView("cd_color.formWidget", self::getFormData($id, $action));
        }
        
    }
    