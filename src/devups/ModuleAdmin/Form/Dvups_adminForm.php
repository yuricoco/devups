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
            "label" => 'Nom',
            "type" => FORMTYPE_TEXT,
            "directive" => ["require"=>true],
            "value" => $dvups_admin->getName(),
        ];
        $entitycore->field['email'] = [
            "label" => 'Email',
            "type" => FORMTYPE_TEXT,
            "value" => $dvups_admin->getEmail(),
        ];

        // administrator, admin_central, agent_central, admin_center,  agent_center

        $dvups_roles = Dvups_role::where("this.name", "!=", "admin")->get();

        $entitycore->field['dvups_role.id'] = [
            "type" => FORMTYPE_RADIO,
            "value" => $dvups_admin->dvups_role->getId(),
            //"values" => FormManager::Options_Helper('name', $dvups_admin->getDvups_role()),
            "label" => 'Dvups_role',
            "options" => FormManager::Options_Helper('alias', $dvups_roles),
        ];


        //if($dvups_admin->getId())
        $entitycore->addDformjs();

        return $entitycore;
    }

    public static function __renderForm(\Dvups_admin $dvups_admin, $action = null, $button = false)
    {
        return FormFactory::__renderForm(Dvups_adminForm::formBuilder($dvups_admin, $action, $button));
    }

    public static function formBuilderImbricate(\Dvups_admin $dvups_admin, $action = null, $button = false)
    {
        //$entitycore = $dvups_admin->scan_entity_core();
        $entitycore = new Core($dvups_admin);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;


        $entitycore->field['name'] = [
            "label" => t('Responsable centre'),
            "type" => FORMTYPE_TEXT,
            "directive" => ["require"=>true],
            "value" => $dvups_admin->getName(),
        ];

        //if($dvups_admin->getId())
        $entitycore->addDformjs($action);

        return $entitycore;
    }

    public static function __renderFormImbricate(\Dvups_admin $dvups_admin, $action = null, $button = false)
    {
        $entitycore = new Core($dvups_admin);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;


        $entitycore->field['name'] = [
            "label" => t('Responsable centre'),
            "type" => FORMTYPE_TEXT,
            "directive" => ["require"=>true],
            "value" => $dvups_admin->getName(),
        ];

        //if($dvups_admin->getId())
        $entitycore->addDformjs($action);

        return FormFactory::__renderForm($entitycore);

    }

}
