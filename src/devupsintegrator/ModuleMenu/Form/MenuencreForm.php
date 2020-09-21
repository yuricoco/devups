<?php 

        
use Genesis as g;

    class MenuencreForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $menuencre = new \Menuencre();
            extract($dataform);
            $entitycore = new Core($menuencre);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
                $entitycore->field['encre'] = [
                    "type" => FORMTYPE_SELECT, 
                    "value" => $menuencre->getEncre()->getId(),
                    "label" => t('entity.encre'),
                    "options" => FormManager::Options_Helper('id', Encre::allrows()),
                ];

                $entitycore->field['menu'] = [
                    "type" => FORMTYPE_SELECT, 
                    "value" => $menuencre->getMenu()->getId(),
                    "label" => t('entity.menu'),
                    "options" => FormManager::Options_Helper('label', Menu::allrows()),
                ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Menuencre::classpath('Ressource/js/menuencreForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(MenuencreForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $menuencre = new Menuencre();
                
                return [
                    'success' => true,
                    'menuencre' => $menuencre,
                    'action' => "create",
                ];
            endif;
            
            $menuencre = Menuencre::find($id);
            return [
                'success' => true,
                'menuencre' => $menuencre,
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
            Genesis::renderView("menuencre.formWidget", self::getFormData($id, $action));
        }
        
    }
    