<?php


use Genesis as g;

class ImagecmsForm extends FormManager
{

    public static function formBuilder($dataform, $button = false)
    {
        $imagecms = new \Imagecms();
        extract($dataform);
        $entitycore = new Core($imagecms);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;

        //$entitycore->addcss('csspath');

        $entitycore->field['cmstext'] = [
            "type" => FORMTYPE_SELECT,
            FH_REQUIRE => true,
            "label" => t('entity.dv_image'),
            "value" => $imagecms->cmstext->getId(),
            "options" => FormManager::Options_Helper("title", Cmstext::allrows()),
        ];


        $entitycore->field['dv_image'] = [
            "type" => FORMTYPE_INJECTION,
            FH_REQUIRE => true,
            "label" => t('entity.dv_image'),
            "imbricate" => Dv_imageForm::__renderForm(Dv_imageForm::getFormData($imagecms->image->getId(), false)),
        ];


        $entitycore->addDformjs($button);
        $entitycore->addjs(Imagecms::classpath('Ressource/js/imagecmsForm'));

        return $entitycore;
    }

    public static function __renderForm($dataform, $button = false)
    {
        return FormFactory::__renderForm(ImagecmsForm::formBuilder($dataform, $button));
    }

    public static function getFormData($id = null, $action = "create")
    {
        if (!$id):
            $imagecms = new Imagecms();

            return [
                'success' => true,
                'imagecms' => $imagecms,
                'action' => Imagecms::classpath("services.php?path=imagecms.create"),
            ];
        endif;

        $imagecms = Imagecms::find($id);
        return [
            'success' => true,
            'imagecms' => $imagecms,
            'action' => Imagecms::classpath("services.php?path=imagecms.update&id=" . $id),
        ];

    }

    public static function render($id = null, $action = "create")
    {
        g::json_encode(['success' => true,
            'form' => self::__renderForm(self::getFormData($id, $action), true),
        ]);
    }

    public static function renderWidget($id = null, $action = "create")
    {
        Genesis::renderView("admin.imagecms.formWidget", self::getFormData($id, $action));
    }

}
    