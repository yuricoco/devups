<?php 

        
use Genesis as g;

    class MenuForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $menu = new \Menu();
            extract($dataform);
            $entitycore = new Core($menu);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['label'] = [
                "label" => t('menu.label'), 
			"type" => FORMTYPE_TEXT, 
                "value" => $menu->getLabel(), 
            ];

                $entitycore->field['page'] = [
                    "type" => FORMTYPE_SELECT, 
                    "value" => $menu->getPage()->getId(),
                    "label" => t('entity.page'),
                    "options" => FormManager::Options_Helper('label', Page::allrows()),
                ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Menu::classpath('Ressource/js/menuForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(MenuForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $menu = new Menu();
                
                return [
                    'success' => true,
                    'menu' => $menu,
                    'action' => "create",
                ];
            endif;
            
            $menu = Menu::find($id);
            return [
                'success' => true,
                'menu' => $menu,
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
            Genesis::renderView("menu.formWidget", self::getFormData($id, $action));
        }
        
    }
    