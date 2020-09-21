<?php 

        
use Genesis as g;

    class EncreForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $encre = new \Encre();
            extract($dataform);
            $entitycore = new Core($encre);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
                $entitycore->field['menu'] = [
                    "type" => FORMTYPE_INJECTION, 
                    FH_REQUIRE => true,
                    "label" => t('entity.menu'),
                    "imbricate" => MenuForm::__renderForm(MenuForm::getFormData($encre->menu->getId(), false)),
                ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Encre::classpath('Ressource/js/encreForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(EncreForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $encre = new Encre();
                
                return [
                    'success' => true,
                    'encre' => $encre,
                    'action' => "create",
                ];
            endif;
            
            $encre = Encre::find($id);
            return [
                'success' => true,
                'encre' => $encre,
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
            Genesis::renderView("encre.formWidget", self::getFormData($id, $action));
        }
        
    }
    