<?php 

        
use Genesis as g;

    class Page_local_contentForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $page_local_content = new \Page_local_content();
            extract($dataform);
            $entitycore = new Core($page_local_content);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Page_local_content::classpath('Ressource/js/page_local_contentForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(Page_local_contentForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $page_local_content = new Page_local_content();
                
                return [
                    'success' => true,
                    'page_local_content' => $page_local_content,
                    'action' => "create",
                ];
            endif;
            
            $page_local_content = Page_local_content::find($id);
            return [
                'success' => true,
                'page_local_content' => $page_local_content,
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
            Genesis::renderView("page_local_content.formWidget", self::getFormData($id, $action));
        }
        
    }
    