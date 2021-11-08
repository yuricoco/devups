<?php


use Genesis as g;

class StatusForm extends FormManager
{

    public static function formBuilder($dataform, $button = false)
    {
        $status = new \Status();
        extract($dataform);
        $entitycore = new Core($status);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;

        //$entitycore->addcss('csspath');


        $entitycore->field['entityid'] = [
            "label" => t('Entity'),
            "type" => FORMTYPE_SELECT,
            "value" => $status->entity->getId(),
            "options" => FormManager::Options_Helper("name", Dvups_entity::allrows("name")),
        ];

        $entitycore->field['color'] = [
            "label" => t('status.color'),
            "type" => FORMTYPE_TEXT,
            "directive" => ["class"=> "form-control color_picker", "autocomplete"=>"off"],
            "value" => $status->getColor(),
        ];

        $entitycore->field['_key'] = [
            "label" => t('status.key'),
            "type" => FORMTYPE_TEXT,
            "value" => $status->getKey(),
        ];

        $entitycore->field['label'] = [
            "label" => t('status.label'),
            "type" => FORMTYPE_TEXT,
            "value" => $status->getLabel(),
        ];


        $entitycore->addDformjs($button);
        $entitycore->addcss(__admin.'plugins/colorpicker/css/evol-colorpicker.min');
        $entitycore->addjs(__admin.'plugins/colorpicker/js/evol-colorpicker.min');
        $entitycore->addjs(Status::classpath('Resource/js/statusForm'));

        return $entitycore;
    }

    public static function __renderForm($dataform, $button = false)
    {
        return FormFactory::__renderForm(StatusForm::formBuilder($dataform, $button));
    }

    public static function getFormData($id = null, $action = "create")
    {
        if (!$id):
            $status = new Status();

            return [
                'success' => true,
                'status' => $status,
                'action' => Status::classpath("services.php?path=status.create"),
            ];
        endif;

        $status = Status::find($id);
        return [
            'success' => true,
            'status' => $status,
            'action' => Status::classpath("services.php?path=status.update&id=" . $id),
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
        Genesis::renderView("status.formWidget", self::getFormData($id, $action));
    }

}
    