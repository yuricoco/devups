<?php 

    class TestentityForm extends FormManager{

        public static function formBuilder(\Testentity $testentity, $action = null, $button = false) {
            $entitycore = new Core($testentity);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $testentity->getName(), 
            ];

            $entitycore->field['description'] = [
                "label" => 'Description', 
			"type" => FORMTYPE_TEXTAREA, 
                "value" => $testentity->getDescription(), 
            ];

            
            $entitycore->addDformjs($action);
            $entitycore->addjs('Ressource/js/testentityForm.js');
            
            return $entitycore;
        }
        
        public static function __renderForm(\Testentity $testentity, $action = null, $button = false) {
            return FormFactory::__renderForm(TestentityForm::formBuilder($testentity, $action, $button));
        }
        
        public static function __renderFormWidget(\Testentity $testentity, $action_form = null) {
            include ROOT.Testentity::classpath()."Form/TestentityFormWidget.php";
        }

        public static function __renderDetailWidget(\Testentity $testentity){
            include ROOT . Testentity::classpath() . "Form/TestentityDetailWidget.php";
        }
    }
    