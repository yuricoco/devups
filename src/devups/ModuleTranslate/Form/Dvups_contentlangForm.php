<?php


use Genesis as g;

class Dvups_contentlangForm extends FormManager
{

    public static function formBuilder($dataform, $button = false)
    {
        $dvups_contentlang = new \Dvups_contentlang();
        extract($dataform);
        $entitycore = new Core($dvups_contentlang);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;

        //$entitycore->addcss('csspath');


        $entitycore->field['content'] = [
            "label" => 'Content',
            "type" => FORMTYPE_TEXT,
            "value" => $dvups_contentlang->getContent(),
        ];

        $entitycore->field['lang'] = [
            "label" => 'Lang',
            "type" => FORMTYPE_TEXT,
            "directive" => ["readonly"=>true],
            "value" => $dvups_contentlang->getLang(),
        ];

//        $entitycore->field['dvups_lang'] = [
//            "type" => FORMTYPE_SELECT,
//            "value" => $dvups_contentlang->getDvups_lang()->getId(),
//            "label" => 'Dvups_lang',
//            "options" => FormManager::Options_Helper('ref', Dvups_lang::allrows()),
//        ];


        $entitycore->addDformjs($button);
        $entitycore->addjs(Dvups_contentlang::classpath('Ressource/js/dvups_contentlangForm'));

        return $entitycore;
    }

    public static function __renderForm($dataform, $button = false)
    {
        return FormFactory::__renderForm(Dvups_contentlangForm::formBuilder($dataform, $button));
    }

    public static function getFormData($id = null, $action = "create")
    {
        if (!$id):
            $dvups_contentlang = new Dvups_contentlang();

            return [
                'success' => true,
                'dvups_contentlang' => $dvups_contentlang,
                'action' => "create",
            ];
        endif;

        $dvups_contentlang = Dvups_contentlang::find($id);
        return [
            'success' => true,
            'dvups_contentlang' => $dvups_contentlang,
            'action' => "update&id=" . $id,
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
        Genesis::renderView("dvups_contentlang.formWidget", self::getFormData($id, $action));
    }

}
    