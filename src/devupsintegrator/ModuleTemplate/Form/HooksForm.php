<?php 

        
use Genesis as g;

    class HooksForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $hooks = new \Hooks();
            extract($dataform);
            $entitycore = new Core($hooks);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['label'] = [
                "label" => t('hooks.label'), 
			"type" => FORMTYPE_TEXT, 
                "value" => $hooks->getLabel(), 
            ];

                $entitycore->field['block'] = [
                    "type" => FORMTYPE_CHECKBOX, 
                    "values" => $hooks->inCollectionOf('Block'),
                    "label" => t('entity.block'),
                    "options" => FormManager::Options_Helper('label', Block::allrows()),
                ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Hooks::classpath('Ressource/js/hooksForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(HooksForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $hooks = new Hooks();
                
                return [
                    'success' => true,
                    'hooks' => $hooks,
                    'action' => "create",
                ];
            endif;
            
            $hooks = Hooks::find($id);
            return [
                'success' => true,
                'hooks' => $hooks,
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
            Genesis::renderView("hooks.formWidget", self::getFormData($id, $action));
        }
        
    }
    