<?php 

        
use Genesis as g;

    class Dvups_componentForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $dvups_component = new \Dvups_component();
            extract($dataform);
            $entitycore = new Core($dvups_component);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['name'] = [
                "label" => t('dvups_component.name'), 
			"type" => FORMTYPE_TEXT, 
                "value" => $dvups_component->getName(), 
            ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Dvups_component::classpath('Ressource/js/dvups_componentForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(Dvups_componentForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $dvups_component = new Dvups_component();
                
                return [
                    'success' => true,
                    'dvups_component' => $dvups_component,
                    'action' => "create",
                ];
            endif;
            
            $dvups_component = Dvups_component::find($id);
            return [
                'success' => true,
                'dvups_component' => $dvups_component,
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
            Genesis::renderView("dvups_component.formWidget", self::getFormData($id, $action));
        }
        
    }
    