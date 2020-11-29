<?php 

        
use Genesis as g;

    class NotificationForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $notification = new \Notification();
            extract($dataform);
            $entitycore = new Core($notification);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['entity'] = [
                "label" => 'Entity', 
			"type" => FORMTYPE_TEXT, 
                "value" => $notification->getEntity(), 
            ];

            $entitycore->field['entityid'] = [
                "label" => 'Entityid', 
			"type" => FORMTYPE_TEXT, 
                "value" => $notification->getEntityid(), 
            ];

            $entitycore->field['content'] = [
                "label" => 'Content', 
			FH_REQUIRE => false,
 			"type" => FORMTYPE_TEXT, 
                "value" => $notification->getContent(), 
            ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Notification::classpath('Ressource/js/notificationForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(NotificationForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $notification = new Notification();
                
                return [
                    'success' => true,
                    'notification' => $notification,
                    'action' => "create",
                ];
            endif;
            
            $notification = Notification::find($id);
            return [
                'success' => true,
                'notification' => $notification,
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
            Genesis::renderView("notification.formWidget", self::getFormData($id, $action));
        }
        
    }
    