<?php


use Genesis as g;

class Local_contentForm extends FormManager
{

    public static function formBuilder($dataform, $button = false)
    {
        $local_content = new \Local_content();
        extract($dataform);
        $entitycore = new Core($local_content);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;

        //$entitycore->addcss('csspath');

        // todo: add hidden field for csrf look for : https://resources.infosecinstitute.com/fixing-csrf-vulnerability-in-php-application/#gref

        $entitycore->field['lang'] = [
            "label" => 'Lang',
            "type" => FORMTYPE_TEXT,
            "directive" => ["readonly" => true],
            "value" => $local_content->getLang(),
        ];

        $entitycore->field['reference'] = [
            "label" => 'Reference',
            "type" => FORMTYPE_TEXT,
            "directive" => ["readonly" => true],
            "value" => $local_content->getReference(),
        ];

        $entitycore->field['content'] = [
            "label" => 'Content',
            "type" => FORMTYPE_TEXTAREA,
            "value" => $local_content->getContent(),
        ];


        $entitycore->addDformjs($button);
        $entitycore->addjs(Local_content::classpath('Ressource/js/local_contentForm'));

        return $entitycore;
    }

    public static function __renderForm($dataform, $button = false)
    {
        return FormFactory::__renderForm(Local_contentForm::formBuilder($dataform, $button));
    }

    public static function getFormData($id = null, $action = "create")
    {
        if (!$id):
            $local_content = new Local_content();

            return [
                'success' => true,
                'local_content' => $local_content,
                'action' => Local_content::classpath("services.php?path=local_content.create"),
            ];
        endif;

        $local_content = Local_content::find($id);
        return [
            'success' => true,
            'local_content' => $local_content,
            'action' => Local_content::classpath("services.php?path=local_content.update&id=" . $id),
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
        Genesis::renderView("local_content.formWidget", self::getFormData($id, $action));
    }

    public static function renderWidgetFront($id = null, $action = "create")
    {
        ob_start();
        Genesis::renderView("local_content.formWidget", self::getFormData($id, $action));
        $form = ob_get_contents();
        ob_end_clean();

        return ["success" => true, "form" => $form];

    }

}
    