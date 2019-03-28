<?php

class Dvups_roleForm extends FormManager
{

    public static function formBuilder(\Dvups_role $dvups_role, $action = null, $button = false)
    {
        //$entitycore = $dvups_role->scan_entity_core();
        $entitycore = new Core($dvups_role);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;


        $entitycore->field['name'] = [
            "label" => 'Name',
            "type" => FORMTYPE_TEXT,
            "value" => $dvups_role->getName(),
        ];

        $entitycore->field['alias'] = [
            "label" => 'Alias',
            "type" => FORMTYPE_TEXT,
            "value" => $dvups_role->getAlias(),
        ];

        $entitycore->field['dvups_right'] = [
            "type" => FORMTYPE_CHECKBOX,
            "values" => FormManager::Options_Helper('name', $dvups_role->getDvups_right()),
            "label" => 'Dvups_right',
            "options" => FormManager::Options_ToCollect_Helper('name', new Dvups_right(), $dvups_role->getDvups_right()),
        ];

        $entitycore->field['dvups_module'] = [
            "type" => FORMTYPE_CHECKBOX,
            "values" => FormManager::Options_Helper('name', $dvups_role->getDvups_module()),
            "label" => 'Dvups_module',
            "options" => FormManager::Options_ToCollect_Helper('name', new Dvups_module(), $dvups_role->getDvups_module()),
        ];

        $entitycore->field['dvups_entity'] = [
            "type" => FORMTYPE_CHECKBOX,
            "values" => FormManager::Options_Helper('name', $dvups_role->getDvups_entity()),
            "label" => 'Dvups_entity',
            "options" => FormManager::Options_ToCollect_Helper('name', new Dvups_entity(), $dvups_role->getDvups_entity()),
        ];


        $entitycore->addDformjs();
        return $entitycore;
    }

    public static function __renderForm(\Dvups_role $dvups_role, $action = null, $button = false)
    {
        return FormFactory::__renderForm(Dvups_roleForm::formBuilder($dvups_role, $action, $button));
    }

    public static function __renderDetailWidget(\Testentity $testentity)
    {
        include ROOT . Testentity::classpath() . "Form/TestentityDetailWidget.php";
    }
}
    