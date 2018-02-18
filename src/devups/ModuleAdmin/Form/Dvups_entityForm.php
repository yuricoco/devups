<?php 

    class Dvups_entityForm extends FormManager{

        public static function formBuilder(\Dvups_entity $dvups_entity, $action = null, $button = false) {
            $entitycore = $dvups_entity->scan_entity_core();
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $dvups_entity->getName(), 
            ];

                $entitycore->field['dvups_module'] = [
                    "type" => FORMTYPE_SELECT, 
                    "value" => $dvups_entity->getDvups_module()->getId(),
                    "label" => 'Dvups_module',
                    "options" => FormManager::Options_Helper('name', ( new DBAL( new Dvups_module()) )->findAllDbalEntireEntity()),
                ];


            return $entitycore;
        }
        
        public static function __renderForm(\Dvups_entity $dvups_entity, $action = null, $button = false) {
            return FormFactory::__renderForm(Dvups_entityForm::formBuilder($dvups_entity, $action, $button));
        }
        
    }
    