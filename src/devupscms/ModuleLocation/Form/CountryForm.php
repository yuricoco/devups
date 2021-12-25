<?php


use Genesis as g;

class CountryForm extends FormManager
{

    public $country;

    public static function init(\Country $country, $action = "")
    {
        $fb = new CountryForm($country, $action);
        $fb->country = $country;
        return $fb;
    }

    public function buildForm()
    {


        $this->fields['continent.id'] = [
            "label" => t('Continent'),
            "type" => FORMTYPE_SELECT,
            "placeholder" => "--- continent ---",
            "options" => FormManager::Options_Helper("name", Continent::allrows("name")),
            "value" => $this->country->continent->getId(),
        ];

        $this->fields['name'] = [
            "label" => t('country.name'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->country->getName(),
        ];
        $this->fields['nicename'] = [
            "label" => t('Nom commun'),
            "type" => FORMTYPE_TEXT,
            "lang" => true,
            "value" => $this->country->nicename,
        ];

        $this->fields['iso'] = [
            "label" => t('country.iso'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->country->getIso(),
        ];

        $this->fields['phonecode'] = [
            "label" => t('country.phonecode'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->country->getPhonecode(),
        ];

        $this->fields['status'] = [
            "label" => t('country.status'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->country->getStatus(),
        ];


        return $this;

    }

    public static function renderWidget($id = null, $action = "create")
    {
        Genesis::renderView("country.formWidget", self::getFormData($id, $action));
    }

}
    