<?php

class Dvups_adminForm extends FormManager
{

    public $dvups_admin;

    public static function init(\Dvups_admin $dvups_admin, $action = ""){
        $fb = new Dvups_adminForm($dvups_admin, $action);
        $fb->dvups_admin = $dvups_admin;
        return $fb;
    }

    public function buildForm()
    {

        $this->fields['name'] = [
            "label" => 'Nom',
            "type" => FORMTYPE_TEXT,
            "directive" => ["require"=>true],
            "value" => $this->dvups_admin->getName(),
        ];

        // administrator, admin_central, agent_central, admin_center,  agent_center

        $dvups_roles = Dvups_role::allrows();

        $this->fields['dvups_role'] = [
            "type" => FORMTYPE_RADIO,
            "value" => $this->dvups_admin->dvups_role->getId(),
            //"values" => FormManager::Options_Helper('name', $dvups_admin->getDvups_role()),
            "label" => 'Dvups_role',
            "options" => FormManager::Options_Helper('alias', $dvups_roles),
        ];

        return  $this;
        // return $this->renderForm();

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
