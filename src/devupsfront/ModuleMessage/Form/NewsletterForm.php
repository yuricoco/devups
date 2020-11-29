<?php 

        
use Genesis as g;

    class NewsletterForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $newsletter = new \Newsletter();
            extract($dataform);
            $entitycore = new Core($newsletter);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['creationdate'] = [
                "label" => 'Creationdate', 
			"type" => FORMTYPE_TEXT, 
                "value" => $newsletter->getCreationdate(), 
            ];

            $entitycore->field['email'] = [
                "label" => 'Email', 
			"type" => FORMTYPE_EMAIL, 
                "value" => $newsletter->getEmail(), 
            ];

            
            $entitycore->addDformjs($action);
            $entitycore->addjs(Newsletter::classpath('Ressource/js/newsletterForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(NewsletterForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $newsletter = new Newsletter();
                
                return [
                    'success' => true,
                    'newsletter' => $newsletter,
                    'action' => "create",
                ];
            endif;
            
            $newsletter = Newsletter::find($id);
            return [
                'success' => true,
                'newsletter' => $newsletter,
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
            Genesis::renderView("newsletter.formWidget", self::getFormData($id, $action));
        }
        
    }
    