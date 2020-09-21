<?php 

        
use Genesis as g;

    class TemplateForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $template = new \Template();
            extract($dataform);
            $entitycore = new Core($template);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['header'] = [
                "label" => t('template.header'), 
			"type" => FORMTYPE_TEXT, 
                "value" => $template->getHeader(), 
            ];

            $entitycore->field['footer'] = [
                "label" => t('template.footer'), 
			"type" => FORMTYPE_TEXT, 
                "value" => $template->getFooter(), 
            ];

            $entitycore->field['logo'] = [
                "label" => t('template.logo'), 
			"type" => FORMTYPE_TEXT, 
                "value" => $template->getLogo(), 
            ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Template::classpath('Ressource/js/templateForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(TemplateForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $template = new Template();
                
                return [
                    'success' => true,
                    'template' => $template,
                    'action' => "create",
                ];
            endif;
            
            $template = Template::find($id);
            return [
                'success' => true,
                'template' => $template,
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
            Genesis::renderView("template.formWidget", self::getFormData($id, $action));
        }
        
    }
    