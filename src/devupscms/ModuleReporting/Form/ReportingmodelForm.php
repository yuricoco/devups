<?php


use Genesis as g;

class ReportingmodelForm extends FormManager
{

    public $emailmodel;

    public static function init(\Reportingmodel $emailmodel, $action = "")
    {
        $fb = new ReportingmodelForm($emailmodel, $action);
        $fb->emailmodel = $emailmodel;
        return $fb;
    }

    public function buildForm()
    {

        $this->fields['type'] = [
            "label" => t('Type of reporting '),
            "type" => FORMTYPE_RADIO,
            "options" => FormManager::key_as_value(["PDF", "email"]),
            "value" => $this->emailmodel->getType(),
        ];
        $this->fields['name'] = [
            "label" => t('Email model name'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->emailmodel->getName(),
        ];

        $this->fields['title'] = [
            "label" => t('Title of the mail'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->emailmodel->getTitle(),
        ];

        $this->fields['object'] = [
            "label" => t('Object of the mail'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->emailmodel->getObject(),
        ];
        $this->fields['description'] = [
            "label" => t('Description of the mail'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->emailmodel->description,
        ];


        return $this;

    }

    public static function renderWidget($id = null, $action = "create")
    {
        Genesis::renderView("emailmodel.formWidget", self::getFormData($id, $action));
    }

}
    