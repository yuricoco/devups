<?php 

    class StorageForm extends FormManager{

        public static function formBuilder(\Storage $storage, $action = null, $button = false) {
            $entitycore = $storage->scan_entity_core();
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
                
            
            $entitycore->field['town'] = [
                "label" => 'Town', 
			"type" => FORMTYPE_TEXT, 
                "value" => $storage->getTown(), 
            ];


            return $entitycore;
        }
        
        public static function __renderForm(\Storage $storage, $action = null, $button = false) {
            return FormFactory::__renderForm(StorageForm::formBuilder($storage, $action, $button));
        }
        
    }
    