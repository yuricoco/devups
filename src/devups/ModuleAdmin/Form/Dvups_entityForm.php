<?php

class Dvups_entityForm extends FormManager
{

    public static function formBuilder(\Dvups_entity $dvups_entity, $action = null, $button = false)
    {
        $entitycore = new Core($dvups_entity);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;


        $entitycore->field['name'] = [
            "label" => 'Name',
            "type" => FORMTYPE_TEXT,
            "value" => $dvups_entity->getName(),
        ];

        $entitycore->field['label'] = [
            "label" => 'Label',
            "type" => FORMTYPE_TEXT,
            "value" => $dvups_entity->getLabel(),
        ];

        $entitycore->field['dvups_module'] = [
            "type" => FORMTYPE_SELECT,
            "value" => $dvups_entity->getDvups_module()->getId(),
            "label" => 'Dvups_module',
            "options" => FormManager::Options_Helper('name', Dvups_module::all()),
        ];

        $entitycore->field['dvups_right'] = [
            "type" => FORMTYPE_CHECKBOX,
            "values" => FormManager::Options_Helper('name', $dvups_entity->getDvups_right()),
            "label" => 'Dvups_right',
            "options" => FormManager::Options_ToCollect_Helper('name', new Dvups_right(), $dvups_entity->getDvups_right()),
        ];


        $entitycore->addDformjs();
        return $entitycore;
    }

    public static function __renderForm(\Dvups_entity $dvups_entity, $action = null, $button = false)
    {
        return FormFactory::__renderForm(Dvups_entityForm::formBuilder($dvups_entity, $action, $button));
    }

    public static function __renderDetailWidget(\Dvups_entity $dvups_entity)
    {
        include ROOT . Dvups_entity::classpath() . "Form/Dvups_entityDetailWidget.php";
    }

}
    