<?php

class Dvups_adminForm extends FormManager
{

    public static function formBuilder(\Dvups_admin $dvups_admin, $action = null, $button = false)
    {
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
            "type" => FORMTYPE_RADIO,
            "value" => $dvups_admin->dvups_role->getId(),
            //"values" => FormManager::Options_Helper('name', $dvups_admin->getDvups_role()),
            "label" => 'Dvups_role',
            "options" => FormManager::Options_Helper('name', Dvups_role::allrows()),
        ];

        //if($dvups_admin->getId())
        $entitycore->addDformjs();

        return $entitycore;
    }

    public static function __renderForm(\Dvups_admin $dvups_admin, $action = null, $button = false)
    {
        return FormFactory::__renderForm(Dvups_adminForm::formBuilder($dvups_admin, $action, $button));
    }

}
    