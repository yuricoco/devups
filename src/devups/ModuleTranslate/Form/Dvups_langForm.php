<?php 

    class Dvups_langForm extends FormManager{

        public static function formBuilder(\Dvups_lang $dvups_lang, $action = null, $button = false) {
            $entitycore = new Core($dvups_lang);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
                
            
            $entitycore->field['lable'] = [
                "label" => 'Lable', 
			"type" => FORMTYPE_TEXT, 
                "value" => $dvups_lang->getLable(), 
            ];

            $entitycore->field['_table'] = [
                "label" => '_table', 
			"type" => FORMTYPE_TEXTAREA, 
                "value" => $dvups_lang->get_table(), 
            ];

            $entitycore->field['_row'] = [
                "label" => '_row', 
			"type" => FORMTYPE_TEXTAREA, 
                "value" => $dvups_lang->get_row(), 
            ];

            $entitycore->field['lang'] = [
                "label" => 'Lang', 
			"type" => FORMTYPE_TEXTAREA, 
                "value" => $dvups_lang->getLang(), 
            ];

            $entitycore->field['content'] = [
                "label" => 'Content', 
			"type" => FORMTYPE_TEXTAREA, 
                "value" => $dvups_lang->getContent(), 
            ];


            return $entitycore;
        }
        
        public static function __renderForm(\Dvups_lang $dvups_lang, $action = null, $button = false) {
            return FormFactory::__renderForm(Dvups_langForm::formBuilder($dvups_lang, $action, $button));
        }
        
        public static function __renderFormWidget(\Dvups_lang $dvups_lang, $action_form = null) {
            include ROOT.Dvups_lang::classpath()."Form/Dvups_langFormWidget.php";
        }
        
    }
    