<?php


use Genesis as g;

class Dvups_entityForm extends FormManager
{

    public static function formBuilder($dataform, $button = false)
    {
        $dvups_entity = new \Dvups_entity();
        extract($dataform);
        $entitycore = new Core($dvups_entity);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;

        //$entitycore->addcss('csspath');


        $entitycore->field['name'] = [
            "label" => t('dvups_entity.name'),
            "type" => FORMTYPE_TEXT,
            "value" => $dvups_entity->getName(),
        ];

        $entitycore->field['url'] = [
            "label" => t('dvups_entity.url'),
            "type" => FORMTYPE_TEXT,
            "value" => $dvups_entity->getUrl(),
        ];

        $entitycore->field['label'] = [
            "label" => t('dvups_entity.label'),
            "type" => FORMTYPE_TEXT,
            "value" => $dvups_entity->getLabel(),
        ];
//        $entitycore->field['enablenotification'] = [
//            "label" => t('Activer les notifications'),
//            "type" => FORMTYPE_RADIO,
//            "options" => ["no", "yes"],
//            "value" => $dvups_entity->getEnablenotification(),
//        ];

        $entitycore->field['dvups_module.id'] = [
            "type" => FORMTYPE_SELECT,
            "value" => $dvups_entity->getDvups_module()->getId(),
            "label" => t('entity.dvups_module'),
            "options" => FormManager::Options_Helper('name', Dvups_module::allrows()),
        ];

        $entitycore->field['dvups_right::values'] = [
            "type" => FORMTYPE_CHECKBOX,
            "values" => $dvups_entity->inCollectionOf('Dvups_right'),
            "label" => t('entity.dvups_right'),
            "options" => FormManager::Options_Helper('name', Dvups_right::allrows()),
        ];


        $entitycore->addDformjs($button);
        $entitycore->addjs(Dvups_entity::classpath('Ressource/js/dvups_entityForm'));

        return $entitycore;
    }

    public static function __renderForm($dataform, $button = false)
    {
        return FormFactory::__renderForm(Dvups_entityForm::formBuilder($dataform, $button));
    }

    public static function getFormData($id = null, $action = "create")
    {
        if (!$id):
            $dvups_entity = new Dvups_entity();

            return [
                'success' => true,
                'dvups_entity' => $dvups_entity,
                'action' => Dvups_entity::classpath("services.php?path=dvups_entity.create"),
            ];
        endif;

        $dvups_entity = Dvups_entity::find($id);
        return [
            'success' => true,
            'dvups_entity' => $dvups_entity,
            'action' => Dvups_entity::classpath("services.php?path=dvups_entity.update&id=".$id),
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
        Genesis::renderView("dvups_entity.formWidget", self::getFormData($id, $action));
    }
    public static function renderExportWidget($id = null, $action = "create")
    {
        return Genesis::getView("admin.dvups_entity.formExportWidget", Request::$uri_get_param+Request::$uri_post_param);
    }

}
    