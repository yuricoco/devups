<?php

class Dvups_langForm extends FormManager
{

    public static function formBuilder(\Dvups_lang $dvups_lang, $action = null, $button = false)
    {
        $entitycore = new Core($dvups_lang);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;


        $entitycore->field['ref'] = [
            "label" => 'Ref',
            "type" => FORMTYPE_TEXT,
            "value" => $dvups_lang->getRef(),
        ];

        $entitycore->field['lang'] = [
            "label" => 'Lang',
            "type" => FORMTYPE_TEXTAREA,
            "value" => $dvups_lang->getLang(),
        ];


        return $entitycore;
    }

    public static function __renderForm(\Dvups_lang $dvups_lang, $action = null, $button = false)
    {
        return FormFactory::__renderForm(Dvups_langForm::formBuilder($dvups_lang, $action, $button));
    }

    public static function __renderFormWidget(\Dvups_lang $dvups_lang, $action_form = null)
    {
        include ROOT . Dvups_lang::classpath() . "Form/Dvups_langFormWidget.php";
    }

    public static function __renderDetailWidget(\Dvups_lang $dvups_lang)
    {
        include ROOT . Dvups_lang::classpath() . "Form/Dvups_langDetailWidget.php";
    }
}
    