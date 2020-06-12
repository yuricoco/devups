<?php 

        
use Genesis as g;

    class Local_content_keyForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $local_content_key = new \Local_content_key();
            extract($dataform);
            $entitycore = new Core($local_content_key);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['reference'] = [
                "label" => 'Reference', 
			"type" => FORMTYPE_TEXT, 
                "value" => $local_content_key->getReference(), 
            ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Local_content_key::classpath('Ressource/js/local_content_keyForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(Local_content_keyForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $local_content_key = new Local_content_key();
                
                return [
                    'success' => true,
                    'local_content_key' => $local_content_key,
                    'action' => "create",
                ];
            endif;
            
            $local_content_key = Local_content_key::find($id);
            return [
                'success' => true,
                'local_content_key' => $local_content_key,
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
            Genesis::renderView("local_content_key.formWidget", self::getFormData($id, $action));
        }
        
    }
    