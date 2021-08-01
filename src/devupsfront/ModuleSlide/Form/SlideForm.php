<?php


use Genesis as g;

class SlideForm extends FormManager
{

    public static function formBuilder($dataform, $button = false)
    {
        $slide = new \Slide();
        extract($dataform);
        $entitycore = new Core($slide);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;

        //$entitycore->addcss('csspath');


        $entitycore->field['activated'] = [
            "label" => t('slide.activated'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $slide->getActivated(),
        ];

        $entitycore->field['redirect'] = [
            "label" => t('slide.targeturl'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $slide->getRedirect(),
        ];

        $entitycore->field['dv_image'] = [
            "type" => FORMTYPE_INJECTION,
            FH_REQUIRE => true,
            "label" => t('entity.dv_image'),
            "imbricate" => Dv_imageForm::__renderForm(Dv_imageForm::getFormData($slide->dv_image->getId(), false)),
        ];


        $entitycore->addDformjs($button);
        $entitycore->addjs(Slide::classpath('Resource/js/slideForm'));

        return $entitycore;
    }

    public static function __renderForm($dataform, $button = false)
    {
        return FormFactory::__renderForm(SlideForm::formBuilder($dataform, $button));
    }

    public static function getFormData($id = null, $action = "create")
    {
        if (!$id):
            $slide = new Slide();

            return [
                'success' => true,
                'slide' => $slide,
                'action' => Slide::classpath("services.php?path=slide.create"),
            ];
        endif;

        $slide = Slide::find($id);
        return [
            'success' => true,
            'slide' => $slide,
            'action' => Slide::classpath("services.php?path=slide.update&id=" . $id),
        ];

    }

    public static function render($id = null, $action = "create")
    {
        Genesis::json_encode(
            [
                'success' => true,
                'form' => Genesis::getView("admin.slide.formWidget", self::getFormData($id, $action)),
            ]
        );
//            g::json_encode(['success' => true,
//                'form' => self::__renderForm(self::getFormData($id, $action),true),
//            ]);
    }

    public static function renderWidget($id = null, $action = "create")
    {
        Genesis::renderView("slide.formWidget", self::getFormData($id, $action));
    }

}
    