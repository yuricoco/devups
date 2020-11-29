<?php 

        
use Genesis as g;

    class MessageForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $message = new \Message();
            extract($dataform);
            $entitycore = new Core($message);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['nom'] = [
                "label" => 'Nom', 
			"type" => FORMTYPE_TEXT, 
                "value" => $message->getNom(), 
            ];

            $entitycore->field['email'] = [
                "label" => 'Email', 
			"type" => FORMTYPE_EMAIL, 
                "value" => $message->getEmail(), 
            ];

            $entitycore->field['telephone'] = [
                "label" => 'Telephone', 
			FH_REQUIRE => false,
 			"type" => FORMTYPE_TEXT, 
                "value" => $message->getTelephone(), 
            ];

            $entitycore->field['message'] = [
                "label" => 'Message', 
			FH_REQUIRE => false,
 			"type" => FORMTYPE_TEXTAREA, 
                "value" => $message->getMessage(), 
            ];

            
            $entitycore->addDformjs($action);
            $entitycore->addjs(Message::classpath('Ressource/js/messageForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(MessageForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $message = new Message();
                
                return [
                    'success' => true,
                    'message' => $message,
                    'action' => "create",
                ];
            endif;
            
            $message = Message::find($id);
            return [
                'success' => true,
                'message' => $message,
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
            Genesis::renderView("message.formWidget", self::getFormData($id, $action));
        }
        
    }
    