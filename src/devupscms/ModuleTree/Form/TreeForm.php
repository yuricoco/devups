<?php


use Genesis as g;

class TreeForm extends FormManager
{

    public static function formBuilder($dataform, $button = false)
    {
        $tree = new \Tree();
        extract($dataform);
        $entitycore = new Core($tree);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;

        //$entitycore->addcss('csspath');


        $entitycore->field['name'] = [
            "label" => t('tree.name'),
            "type" => FORMTYPE_TEXT,
            "value" => $tree->getName(),
        ];

        $entitycore->field['description'] = [
            "label" => t('tree.description'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $tree->getDescription(),
        ];


        $entitycore->addDformjs($button);
        $entitycore->addjs(Tree::classpath('Ressource/js/treeForm'));

        return $entitycore;
    }

    public static function __renderForm($dataform, $button = false)
    {
        return FormFactory::__renderForm(TreeForm::formBuilder($dataform, $button));
    }

    public static function getFormData($id = null, $action = "create")
    {
        if (!$id):
            $tree = new Tree();

            return [
                'success' => true,
                'tree' => $tree,
                'action' => "create",
            ];
        endif;

        $tree = Tree::find($id);
        return [
            'success' => true,
            'tree' => $tree,
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
        Genesis::renderView("tree.formWidget", self::getFormData($id, $action));
    }

}
    