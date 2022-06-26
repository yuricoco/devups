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
        $files = scandir(ROOT."src/devupscms/ModuleReporting/Resource/views/models/");

        unset($files[0]);
        unset($files[1]);
        if (!$this->emailmodel->type)
            $this->emailmodel->type = explode(".", $files[2])[0];

        $this->fields['type'] = [
            "label" => t('Type of reporting '),
            "type" => FORMTYPE_RADIO,
            "options" => FormManager::key_as_value(array_values($files)),
            "value" => $this->emailmodel->getType().".blade.php",
        ];

        $this->fields['name'] = [
            "label" => t('Email model name'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->emailmodel->getName(),
        ];

        $this->fields['title'] = [
            "label" => t('Title of the mail'),
            "type" => FORMTYPE_TEXT,
            "lang" => true,
            "value" => $this->emailmodel->getTitle(),
        ];

        $this->fields['object'] = [
            "label" => t('Object of the mail'),
            "type" => FORMTYPE_TEXT,
            "lang" => true,
            "value" => $this->emailmodel->getObject(),
        ];
        $this->fields['description'] = [
            "label" => t('Description of the mail'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->emailmodel->description,
        ];
        $this->fields['contenttext'] = [
            "label" => t('Contenu text'),
            "type" => FORMTYPE_TEXTAREA,
            "lang" => true,
            "value" => $this->emailmodel->contenttext,
        ];


        return $this;

    }

    public static function renderWidget($id = null, $action = "create")
    {
        Genesis::renderView("emailmodel.formWidget", self::getFormData($id, $action));
    }

}
    