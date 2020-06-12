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

        $entitycore->field['phonenumber'] = [
            "label" => t('Numéro téléphone'),
            "type" => FORMTYPE_TEXT,
            "directive" => ["require"=>true],
            "value" => $dvups_admin->getPhonenumber(),
        ];
        $entitycore->field['email'] = [
            "label" => t('Email'),
            "type" => FORMTYPE_EMAIL,
            "directive" => ["require"=>true],
            "value" => $dvups_admin->getEmail(),
        ];

        // administrator, admin_central, agent_central, admin_center,  agent_center

        $admin = getadmin();
        if($admin->dvups_role->is(Dvups_admin::role_administrator))
            $dvups_roles = Dvups_role::where("name")->in("'".Dvups_admin::role_admin_center."' , '".Dvups_admin::role_agent_center."' ")->__getAllRow();
        else if($admin->dvups_role->is(Dvups_admin::role_agent_center))
            $dvups_roles = Dvups_role::where("name",Dvups_admin::role_agent_center)->__getAllRow();
        else if($admin->dvups_role->is(Dvups_admin::role_admin_center))
            $dvups_roles = Dvups_role::where("name",Dvups_admin::role_agent_approved_center)->__getAllRow();
        else if($admin->dvups_role->is(Dvups_admin::role_admin_approved_center))
            $dvups_roles = Dvups_role::where("name")->in([Dvups_admin::role_admin_approved_center, Dvups_admin::role_agent_approved_center])->__getAllRow();
        else if($admin->dvups_role->is(Dvups_admin::role_agent_approved_center))
            $dvups_roles = Dvups_role::where("name",Dvups_admin::role_agent_approved_center)->__getAllRow();
        else
            $dvups_roles = Dvups_role::allrows();

        if($admin->dvups_role->is("admin"))
            $entitycore->field['approved_center'] = [
                "type" => FORMTYPE_SELECT,
                "value" => $dvups_admin->approved_center->getId(),
                //"values" => FormManager::Options_Helper('name', $dvups_admin->getDvups_role()),
                "label" => 'Approved_center',
                "placeholder" => '--- défaut ---',
                "options" => FormManager::Options_Helper('name', Approved_center::allrows()),
            ];

        $entitycore->field['dvups_role'] = [
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

        $entitycore->field['phonenumber'] = [
            "label" => t('Numéro téléphone responsable'),
            "type" => FORMTYPE_TEXT,
            "directive" => ["require"=>true],
            "value" => $dvups_admin->getPhonenumber(),
        ];
        $entitycore->field['email'] = [
            "label" => t('Email Responsable'),
            "type" => FORMTYPE_TEXT,
            "directive" => ["require"=>true],
            "value" => $dvups_admin->getEmail(),
        ];

        //if($dvups_admin->getId())
        $entitycore->addDformjs($action);

        return $entitycore;
    }

    public static function __renderFormImbricate(\Dvups_admin $dvups_admin, $action = null, $button = false)
    {
        return FormFactory::__renderForm(Dvups_adminForm::formBuilderImbricate($dvups_admin, $action, $button));
    }

}
