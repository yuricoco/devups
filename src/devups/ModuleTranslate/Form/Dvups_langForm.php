<?php 

        
use Genesis as g;

    class Dvups_langForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $dvups_lang = new \Dvups_lang();
            extract($dataform);
            $entitycore = new Core($dvups_lang);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['ref'] = [
                "label" => 'Ref', 
			"type" => FORMTYPE_TEXT, 
                "value" => $dvups_lang->getRef(), 
            ];

            $entitycore->field['content'] = [
                "label" => 'Content', 
			"type" => FORMTYPE_TEXTAREA, 
                "value" => $dvups_lang->getContent(), 
            ];

            $entitycore->field['_table'] = [
                "label" => '_table', 
			"type" => FORMTYPE_TEXTAREA, 
                "value" => $dvups_lang->get_table(), 
            ];

            $entitycore->field['_column'] = [
                "label" => '_column', 
			"type" => FORMTYPE_TEXTAREA, 
                "value" => $dvups_lang->get_column(), 
            ];

            $entitycore->field['lang'] = [
                "label" => 'Lang', 
			"type" => FORMTYPE_TEXTAREA, 
                "value" => $dvups_lang->getLang(), 
            ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Dvups_lang::classpath('Ressource/js/dvups_langForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(Dvups_langForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $dvups_lang = new Dvups_lang();
                
                return [
                    'success' => true,
                    'dvups_lang' => $dvups_lang,
                    'action' => "create",
                ];
            endif;
            
            $dvups_lang = Dvups_lang::find($id);
            return [
                'success' => true,
                'dvups_lang' => $dvups_lang,
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
            Genesis::renderView("dvups_lang.formWidget", self::getFormData($id, $action));
        }
        
    }
    