<?php 

    class Dvups_rightForm extends FormManager{

        public static function formBuilder(\Dvups_right $dvups_right, $action = null, $button = false) {
            $entitycore = $dvups_right->scan_entity_core();
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $dvups_right->getName(), 
            ];


            return $entitycore;
        }
        
        public static function __renderForm(\Dvups_right $dvups_right, $action = null, $button = false) {
            return FormFactory::__renderForm(Dvups_rightForm::formBuilder($dvups_right, $action, $button));
        }
        
    }
    