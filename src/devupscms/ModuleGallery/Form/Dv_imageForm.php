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

        $entitycore->field['folder'] = [
            "label" => t('Folder'),
            "type" => FORMTYPE_SELECT,
            "value" => $dv_image->folder->getId(),
            "placeholder" => '--- choose a folder ---',
            "options" => FormManager::Options_Helper("name", Tree_item::getmainmenu("folder")),
        ];
        $entitycore->field['position'] = [
            "label" => t('Position'),
            "type" => FORMTYPE_SELECT,
            "value" => $dv_image->position->getId(),
            "placeholder" => '--- choose a position ---',
            "options" => FormManager::Options_Helper("name", Tree_item::getmainmenu("position")),
        ];
/*
        $entitycore->field['image'] = [
            "label" => t('dv_image.image'),
            "type" => FORMTYPE_FILE,
            "filetype" => FILETYPE_IMAGE,
            "value" => $dv_image->getImage(),
            "src" => $dv_image->showImage(),
        ];*/


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
                'action' => Dv_image::classpath("services.php?path=dv_image.create&tablemodel=frontcustom"),
            ];
        endif;

        $dv_image = Dv_image::find($id);
        return [
            'success' => true,
            'dv_image' => $dv_image,
            'action' => Dv_image::classpath("services.php?path=dv_image.update&tablemodel=frontcustom&id=" . $id),
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
    