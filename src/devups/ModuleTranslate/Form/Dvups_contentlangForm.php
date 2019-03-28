<?php

class Dvups_contentlangForm extends FormManager
{

    public static function formBuilder(\Dvups_contentlang $dvups_contentlang, $action = null, $button = false)
    {
        $entitycore = new Core($dvups_contentlang);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;


        $entitycore->field['content'] = [
            "label" => 'Content',
            "type" => FORMTYPE_TEXT,
            "value" => $dvups_contentlang->getContent(),
        ];

        $entitycore->field['lang'] = [
            "label" => 'Lang',
            "type" => FORMTYPE_TEXT,
            "value" => $dvups_contentlang->getLang(),
        ];

        $entitycore->field['dvups_lang'] = [
            "type" => FORMTYPE_SELECT,
            "value" => $dvups_contentlang->getDvups_lang()->getId(),
            "label" => 'Dvups_lang',
            "options" => FormManager::Options_Helper('ref', Dvups_lang::allrows()),
        ];


        return $entitycore;
    }

    public static function __renderForm(\Dvups_contentlang $dvups_contentlang, $action = null, $button = false)
    {
        return FormFactory::__renderForm(Dvups_contentlangForm::formBuilder($dvups_contentlang, $action, $button));
    }

    public static function __renderFormWidget(\Dvups_contentlang $dvups_contentlang, $action_form = null)
    {
        include ROOT . Dvups_contentlang::classpath() . "Form/Dvups_contentlangFormWidget.php";
    }

    public static function __renderDetailWidget(\Dvups_contentlang $dvups_contentlang)
    {
        include ROOT . Dvups_contentlang::classpath() . "Form/Dvups_contentlangDetailWidget.php";
    }
}
    