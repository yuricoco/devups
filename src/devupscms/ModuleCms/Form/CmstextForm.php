<?php


use Genesis as g;

class CmstextForm extends FormManager
{

    public static function formBuilder($dataform, $button = false)
    {
        $cmstext = new \Cmstext();
        extract($dataform);
        $entitycore = new Core($cmstext);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;

        //$entitycore->addcss('csspath');


        $entitycore->field['lang'] = [
            "label" => 'Lang',
            FH_REQUIRE => false,
            "type" => FORMTYPE_RADIO,
            "value" => $cmstext->getLang(),
            "options" => FormManager::key_as_value(["fr", "en"]),
        ];

        $entitycore->field['title'] = [
            "label" => 'Titre',
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $cmstext->getTitle(),
        ];

        $entitycore->field['reference'] = [
            "label" => 'Reference',
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $cmstext->getReference(),
        ];

        $entitycore->field['content'] = [
            "label" => 'Content',
            "type" => FORMTYPE_TEXTAREA,
            "directive" => ["id" => "editor"],
            "value" => $cmstext->getContent(),
        ];

        // $entitycore->addDformjs($button);
        $entitycore->addjs(commun('plugins/tinymce.min'));
        $entitycore->addjs(Cmstext::classpath('Ressource/js/cmstextForm'));

        return $entitycore;
    }

    public static function __renderForm($dataform, $button = false)
    {
        return FormFactory::__renderForm(CmstextForm::formBuilder($dataform, $button));
    }

    public static function getFormData($id = null, $action = "create")
    {
        if ($complet = Request::get("tree_item"))
            $tree_item = Tree_item::find($complet);
        else
            $tree_item = new Tree_item();

        if (!$id):
            $cmstext = new Cmstext();
            $cmstext->setTitle($tree_item->getName());
            $cmstext->setReference($tree_item->getSlug());
            return [
                'success' => true,
                'cmstext' => $cmstext,
                'tree_item' => $tree_item,
                'api' => Cmstext::classpath("services.php?path=cmstext.create"),
                'action' => Cmstext::classpath("cmstext/create"),
            ];
        endif;

        $cmstext = Cmstext::find($id);
        return [
            'success' => true,
            'tree_item' => $tree_item,
            'cmstext' => $cmstext,
            'api' => Cmstext::classpath("services.php?path=cmstext.update&id=".$cmstext->getId()),
            'action' => Cmstext::classpath("cmstext/update?id=") . $id,
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
        Genesis::renderView("cmstext.form", self::getFormData($id, $action));
    }

}
    