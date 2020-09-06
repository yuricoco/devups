<?php 

        
use Genesis as g;

    class ConfigurationForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $configuration = new \Configuration();
            extract($dataform);
            $entitycore = new Core($configuration);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['_key'] = [
                "label" => t('configuration._key'), 
"type" => FORMTYPE_TEXT,
                "value" => $configuration->get_key(), 
            ];

            $entitycore->field['_value'] = [
                "label" => t('configuration._value'), 
"type" => FORMTYPE_TEXT,
                "value" => $configuration->get_value(), 
            ];

            $entitycore->field['_type'] = [
                "label" => t('configuration._type'), 
			FH_REQUIRE => false,
 "type" => FORMTYPE_TEXT,
                "value" => $configuration->get_type(), 
            ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Configuration::classpath('Ressource/js/configurationForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(ConfigurationForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $configuration = new Configuration();
                
                return [
                    'success' => true,
                    'configuration' => $configuration,
                    'action' => "create",
                ];
            endif;
            
            $configuration = Configuration::find($id);
            return [
                'success' => true,
                'configuration' => $configuration,
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
            Genesis::renderView("configuration.formWidget", self::getFormData($id, $action));
        }
        
    }
    