<?php 

    class Dvups_moduleForm extends FormManager{

        public static function formBuilder(\Dvups_module $dvups_module, $action = null, $button = false) {
            $entitycore = $dvups_module->scan_entity_core();
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $dvups_module->getName(), 
            ];

            $entitycore->field['label'] = [
                "label" => 'Label',
                "type" => FORMTYPE_TEXT,
                "value" => $dvups_module->getLabel(),
            ];


            return $entitycore;
        }
        
        public static function __renderForm(\Dvups_module $dvups_module, $action = null, $button = false) {
            return FormFactory::__renderForm(Dvups_moduleForm::formBuilder($dvups_module, $action, $button));
        }

        public static function __renderDetailWidget(\Dvups_module $dvups_module){
            include ROOT . Dvups_module::classpath() . "Form/Dvups_moduleDetailWidget.php";
        }
        
    }
    