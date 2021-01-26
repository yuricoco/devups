<?php 

        
use Genesis as g;

    class Social_networkForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $social_network = new \Social_network();
            extract($dataform);
            $entitycore = new Core($social_network);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $social_network->getName(), 
            ];

            $entitycore->field['logo'] = [
                "label" => 'Logo', 
			"type" => FORMTYPE_FILE,
                "filetype" => FILETYPE_IMAGE, 
                "value" => $social_network->getLogo(),
                "src" => $social_network->showLogo(), 
            ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Social_network::classpath('Ressource/js/social_networkForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(Social_networkForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $social_network = new Social_network();
                
                return [
                    'success' => true,
                    'social_network' => $social_network,
                    'action' => "create",
                ];
            endif;
            
            $social_network = Social_network::find($id);
            return [
                'success' => true,
                'social_network' => $social_network,
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
            Genesis::renderView("social_network.formWidget", self::getFormData($id, $action));
        }
        
    }
    