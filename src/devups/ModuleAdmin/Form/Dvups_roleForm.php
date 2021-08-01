<?php


use Genesis as g;

class Dvups_roleForm extends FormManager
{

    public static function formBuilder($dataform, $button = false)
    {
        $dvups_role = new \Dvups_role();
        extract($dataform);
        $entitycore = new Core($dvups_role);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;

        //$entitycore->addcss('csspath');
        //dv_dump($dvups_role->inCollectionOf("dvups_right"), $dvups_role);

        $entitycore->field['name'] = [
            "label" => t('Name role'),
            "type" => FORMTYPE_TEXT,
            "value" => $dvups_role->getName(),
        ];

        $entitycore->field['alias'] = [
            "label" => t('Alias for commun name'),
            "type" => FORMTYPE_TEXT,
            "value" => $dvups_role->getAlias(),
        ];

        $entitycore->field['dvups_right::values'] = [
            "type" => FORMTYPE_CHECKBOX,
            //"values" => FormManager::Options_Helper('name', $dvups_role->getDvups_right()),
            "values" => $dvups_role->inCollectionOf("dvups_right"),
            "label" => 'Dvups_right',
            "options" => FormManager::Options_Helper('name', Dvups_right::all()),
        ];

        $entitycore->field['dvups_module::values'] = [
            "type" => FORMTYPE_CHECKBOX,
            "values" => $dvups_role->inCollectionOf("dvups_module"),
            //"values" => FormManager::Options_Helper('name', $dvups_role->getDvups_module()),
            "label" => 'Dvups_module',
            "options" => FormManager::Options_Helper('name', Dvups_module::all()),
        ];

        $entitycore->field['dvups_entity::values'] = [
            "type" => FORMTYPE_CHECKBOX,
            "values" => $dvups_role->inCollectionOf("dvups_entity"),
            //"values" => FormManager::Options_Helper('name', $dvups_role->getDvups_entity()),
            "label" => 'Dvups_entity',
            "options" => FormManager::Options_Helper('name', Dvups_entity::all()),
        ];

        $entitycore->addDformjs($button);
        $entitycore->addjs(Dvups_role::classpath('Ressource/js/dvups_roleForm'));

        return $entitycore;
    }

    public static function __renderForm($dataform, $button = false)
    {
        return FormFactory::__renderForm(Dvups_roleForm::formBuilder($dataform, $button));
    }

    public static function getFormData($id = null, $action = "create")
    {
        if (!$id):
            $dvups_role = new Dvups_role();

            return [
                'success' => true,
                'dvups_role' => $dvups_role,
                'action' => "create",
            ];
        endif;

        $dvups_role = Dvups_role::find($id);
        return [
            'success' => true,
            'dvups_role' => $dvups_role,
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

        $data = self::getFormData($id, $action);
        $data["rights"] = Dvups_right::all();
        $data["components"] = Dvups_component::all();

        $data["value_rights"] = $data["dvups_role"]->inCollectionOf("dvups_right");
        $data["value_components"] = $data["dvups_role"]->inCollectionOf("dvups_component");
        $data["value_modules"] = $data["dvups_role"]->inCollectionOf("dvups_module");
        $data["value_entities"] = $data["dvups_role"]->inCollectionOf("dvups_entity");

        $form = Genesis::getView("admin.dvups_role.formWidgetGroup", $data);
        return [
            "success" => true,
            "form" => $form,
        ];

        //Genesis::renderView("dvups_role.formWidgetGroup", $data);
        //Genesis::renderView("dvups_role.formWidget", self::getFormData($id, $action));
    }

}
    