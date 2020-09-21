<?php 

        
use Genesis as g;

    class PageForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $page = new \Page();
            extract($dataform);
            $entitycore = new Core($page);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['label'] = [
                "label" => t('page.label'), 
			"type" => FORMTYPE_TEXT, 
                "value" => $page->getLabel(), 
            ];

                $entitycore->field['hooks'] = [
                    "type" => FORMTYPE_CHECKBOX, 
                    "values" => $page->inCollectionOf('Hooks'),
                    "label" => t('entity.hooks'),
                    "options" => FormManager::Options_Helper('label', Hooks::allrows()),
                ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Page::classpath('Ressource/js/pageForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(PageForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $page = new Page();
                
                return [
                    'success' => true,
                    'page' => $page,
                    'action' => "create",
                ];
            endif;
            
            $page = Page::find($id);
            return [
                'success' => true,
                'page' => $page,
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
            Genesis::renderView("page.formWidget", self::getFormData($id, $action));
        }
        
    }
    