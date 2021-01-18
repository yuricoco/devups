<?php


use Genesis as g;

class Dv_imageForm extends FormManager
{

    public static function formBuilder($dataform, $button = false)
    {
        $dv_image = new \Dv_image();
        extract($dataform);
        $entitycore = new Core($dv_image);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;

        //$entitycore->addcss('csspath');


        $entitycore->field['reference'] = [
            "label" => t('dv_image.reference'),
            "type" => FORMTYPE_TEXT,
            "value" => $dv_image->getReference(),
        ];

        $entitycore->field['name'] = [
            "label" => t('dv_image.name'),
            "type" => FORMTYPE_TEXT,
            "value" => $dv_image->getName(),
        ];

        $entitycore->field['description'] = [
            "label" => t('dv_image.description'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $dv_image->getDescription(),
        ];

        $entitycore->field['image'] = [
            "label" => t('dv_image.image'),
            "type" => FORMTYPE_FILE,
            "filetype" => FILETYPE_IMAGE,
            "value" => $dv_image->getImage(),
            "src" => $dv_image->showImage(),
        ];

        $entitycore->field['size'] = [
            "label" => t('dv_image.size'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $dv_image->getSize(),
        ];

        $entitycore->field['width'] = [
            "label" => t('dv_image.width'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $dv_image->getWidth(),
        ];

        $entitycore->field['height'] = [
            "label" => t('dv_image.height'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $dv_image->getHeight(),
        ];


        $entitycore->addDformjs($button);
        $entitycore->addjs(Dv_image::classpath('Resource/js/dv_imageForm'));

        return $entitycore;
    }

    public static function __renderForm($dataform, $button = false)
    {
        return FormFactory::__renderForm(Dv_imageForm::formBuilder($dataform, $button));
    }

    public static function getFormData($id = null, $action = "create")
    {
        if (!$id):
            $dv_image = new Dv_image();

            return [
                'success' => true,
                'dv_image' => $dv_image,
                'action' => "create&tablemodel=frontcustom",
            ];
        endif;

        $dv_image = Dv_image::find($id);
        return [
            'success' => true,
            'dv_image' => $dv_image,
            'action' => "update&tablemodel=frontcustom&id=" . $id,
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
        Genesis::renderView("dv_image.formWidget", self::getFormData($id, $action));
    }

}
    