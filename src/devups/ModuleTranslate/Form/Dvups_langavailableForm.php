<?php 

        
use Genesis as g;

    class Dvups_langavailableForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $dvups_langavailable = new \Dvups_langavailable();
            extract($dataform);
            $entitycore = new Core($dvups_langavailable);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $dvups_langavailable->getName(), 
            ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Dvups_langavailable::classpath('Ressource/js/dvups_langavailableForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(Dvups_langavailableForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $dvups_langavailable = new Dvups_langavailable();
                
                return [
                    'success' => true,
                    'dvups_langavailable' => $dvups_langavailable,
                    'action' => "create",
                ];
            endif;
            
            $dvups_langavailable = Dvups_langavailable::find($id);
            return [
                'success' => true,
                'dvups_langavailable' => $dvups_langavailable,
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
            Genesis::renderView("dvups_langavailable.formWidget", self::getFormData($id, $action));
        }
        
    }
    