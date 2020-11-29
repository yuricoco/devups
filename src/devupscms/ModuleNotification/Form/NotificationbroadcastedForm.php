<?php 

        
use Genesis as g;

    class NotificationbroadcastedForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $notificationbroadcasted = new \Notificationbroadcasted();
            extract($dataform);
            $entitycore = new Core($notificationbroadcasted);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['viewedat'] = [
                "label" => 'Viewedat', 
			FH_REQUIRE => false,
 			"type" => FORMTYPE_DATE, 
                "value" => $notificationbroadcasted->getViewedat(), 
            ];

            $entitycore->field['status'] = [
                "label" => 'Status', 
			"type" => FORMTYPE_RADIO, 
                "value" => $notificationbroadcasted->getStatus(), 
            ];

                $entitycore->field['notification'] = [
                    "type" => FORMTYPE_SELECT, 
                    "value" => $notificationbroadcasted->getNotification()->getId(),
                    "label" => 'Notification',
                    "options" => FormManager::Options_Helper('entity', Notification::allrows()),
                ];

                $entitycore->field['user'] = [
                    "type" => FORMTYPE_SELECT, 
                    "value" => $notificationbroadcasted->getUser()->getId(),
                    "label" => 'User',
                    "options" => FormManager::Options_Helper('firstname', User::allrows()),
                ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Notificationbroadcasted::classpath('Ressource/js/notificationbroadcastedForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(NotificationbroadcastedForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $notificationbroadcasted = new Notificationbroadcasted();
                
                return [
                    'success' => true,
                    'notificationbroadcasted' => $notificationbroadcasted,
                    'action' => "create",
                ];
            endif;
            
            $notificationbroadcasted = Notificationbroadcasted::find($id);
            return [
                'success' => true,
                'notificationbroadcasted' => $notificationbroadcasted,
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
            Genesis::renderView("notificationbroadcasted.formWidget", self::getFormData($id, $action));
        }
        
    }
    