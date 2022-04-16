<?php


use Genesis as g;

class CmstextForm extends FormManager
{

    public $cmstext;

    public static function init(\Cmstext $cmstext, $action = "")
    {
        $fb = new CmstextForm($cmstext, $action);
        $fb->cmstext = $cmstext;
        return $fb;
    }

    public function buildForm()
    {


        $this->fields['title'] = [
            "label" => t('Titre'),
            FH_REQUIRE => false,
            "lang" => true,
            "type" => FORMTYPE_TEXT,
            "value" => $this->cmstext->title,
        ];

        $this->fields['reference'] = [
            "label" => t('cmstext.reference'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $this->cmstext->getReference(),
        ];


        return $this;

    }

    public static function renderWidget($id = null, $action = "create")
    {
        Genesis::renderView("cmstext.formWidget", self::getFormData($id, $action));
    }

}
    