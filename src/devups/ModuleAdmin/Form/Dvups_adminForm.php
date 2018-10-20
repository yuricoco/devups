<?php 

    class Dvups_adminForm extends FormManager{

        public static function formBuilder(\Dvups_admin $dvups_admin, $action = null, $button = false) {
            //$entitycore = $dvups_admin->scan_entity_core();
            $entitycore = new Core($dvups_admin);

            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $dvups_admin->getName(), 
            ];

            $entitycore->field['dvups_role'] = [
                "type" => FORMTYPE_CHECKBOX,
                "values" => FormManager::Options_Helper('name', $dvups_admin->getDvups_role()),
                "label" => 'Dvups_role',
                "options" => FormManager::Options_ToCollect_Helper('name', new Dvups_role(), $dvups_admin->getDvups_role()),
            ];

            if($dvups_admin->getId())
                $entitycore->addDformjs();

            return $entitycore;
        }
        
        public static function __renderForm(\Dvups_admin $dvups_admin, $action = null, $button = false) {
            return FormFactory::__renderForm(Dvups_adminForm::formBuilder($dvups_admin, $action, $button));
        }
        
    }
    