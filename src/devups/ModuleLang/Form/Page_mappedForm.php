<?php 

        
use Genesis as g;

    class Page_mappedForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $page_mapped = new \Page_mapped();
            extract($dataform);
            $entitycore = new Core($page_mapped);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['base_url'] = [
                "label" => 'Base_url', 
			"type" => FORMTYPE_TEXT, 
                "value" => $page_mapped->getBase_url(), 
            ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Page_mapped::classpath('Ressource/js/page_mappedForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(Page_mappedForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $page_mapped = new Page_mapped();
                
                return [
                    'success' => true,
                    'page_mapped' => $page_mapped,
                    'action' => "create",
                ];
            endif;
            
            $page_mapped = Page_mapped::find($id);
            return [
                'success' => true,
                'page_mapped' => $page_mapped,
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
            Genesis::renderView("page_mapped.formWidget", self::getFormData($id, $action));
        }
        
    }
    