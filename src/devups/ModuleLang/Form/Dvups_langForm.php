<?php


use Genesis as g;

class Dvups_langForm extends FormManager
{

    public $dvups_lang;

    public static function init(\Dvups_lang $dvups_lang, $action = "")
    {
        $fb = new Dvups_langForm($dvups_lang, $action);
        $fb->dvups_lang = $dvups_lang;
        return $fb;
    }

    public function buildForm()
    {


        $this->fields['name'] = [
            "label" => t('dvups_lang.name'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->dvups_lang->getName(),
        ];

        $this->fields['main'] = [
            "label" => t('dvups_lang.main'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $this->dvups_lang->getMain(),
        ];


        $this->fields['active'] = [
            "label" => t('dvups_lang.active'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->dvups_lang->getActive(),
        ];

        $this->fields['iso_code'] = [
            "label" => t('dvups_lang.iso_code'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->dvups_lang->getIso_code(),
        ];

        $this->fields['language_code'] = [
            "label" => t('dvups_lang.language_code'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->dvups_lang->getLanguage_code(),
        ];

        $this->fields['locale'] = [
            "label" => t('dvups_lang.locale'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->dvups_lang->getLocale(),
        ];

        $this->fields['date_format_lite'] = [
            "label" => t('dvups_lang.date_format_lite'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->dvups_lang->getDate_format_lite(),
        ];

        $this->fields['date_format_full'] = [
            "label" => t('dvups_lang.date_format_full'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->dvups_lang->getDate_format_full(),
        ];


        return $this;

    }

    public static function renderWidget($id = null, $action = "create")
    {
        Genesis::renderView("dvups_lang.formWidget", self::getFormData($id, $action));
    }

}
    