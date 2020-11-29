<?php 

        
use Genesis as g;

    class EmailmodelForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $emailmodel = new \Emailmodel();
            extract($dataform);
            $entitycore = new Core($emailmodel);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['object'] = [
                "label" => t('emailmodel.object'), 
			"type" => FORMTYPE_TEXT, 
                "value" => $emailmodel->getObject(), 
            ];

            $entitycore->field['contenttext'] = [
                "label" => t('emailmodel.contenttext'), 
			FH_REQUIRE => false,
 			"type" => FORMTYPE_TEXT, 
                "value" => $emailmodel->getContenttext(), 
            ];

            $entitycore->field['content'] = [
                "label" => t('emailmodel.content'), 
			FH_REQUIRE => false,
 			"type" => FORMTYPE_TEXTAREA, 
                "value" => $emailmodel->getContent(), 
            ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Emailmodel::classpath('Ressource/js/emailmodelForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(EmailmodelForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $emailmodel = new Emailmodel();
                
                return [
                    'success' => true,
                    'emailmodel' => $emailmodel,
                    'action' => Emailmodel::classpath("emailmodel/create"),
                ];
            endif;
            
            $emailmodel = Emailmodel::find($id);
            return [
                'success' => true,
                'emailmodel' => $emailmodel,
                'action' => Emailmodel::classpath("emailmodel/update&id=" . $id),
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
            Genesis::renderView("emailmodel.form", self::getFormData($id, $action));
        }
        
    }
    