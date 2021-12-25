<?php


use Genesis as g;

class ContinentForm extends FormManager
{

    public $continent;

    public static function init(\Continent $continent, $action = "")
    {
        $fb = new ContinentForm($continent, $action);
        $fb->continent = $continent;
        return $fb;
    }

    public function buildForm()
    {


        $this->fields['code'] = [
            "label" => t('code'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->continent->getCode(),
        ];
        $this->fields['name'] = [
            "label" => t('continent.name'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->continent->getName(),
        ];

        $this->fields['status'] = [
            "label" => t('continent.status'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->continent->getStatus(),
        ];


        return $this;

    }

    public static function renderWidget($id = null, $action = "create")
    {
        Genesis::renderView("continent.formWidget", self::getFormData($id, $action));
    }

}
    