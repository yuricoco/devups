<?php


use Genesis as g;

class Status_entityForm extends FormManager
{

    public $status_entity;

    public static function init(\Status_entity $status_entity, $action = "")
    {
        $fb = new Status_entityForm($status_entity, $action);
        $fb->status_entity = $status_entity;
        return $fb;
    }

    public function buildForm()
    {


        $this->fields['dvups_entity'] = [
            "label" => t('Entity'),
            "type" => FORMTYPE_SELECT,
            "value" => $this->status_entity->dvups_entity->getId(),
            "options" => FormManager::Options_Helper("name", Dvups_entity::allrows("name")),
        ];

        $this->fields['status'] = [
            "type" => FORMTYPE_SELECT,
            "value" => $this->status_entity->getStatus()->getId(),
            "label" => t('entity.status'),
            "options" => FormManager::Options_Helper('label', Status::allrows()),
        ];


        $this->fields['color'] = [
            "label" => t('status_entity.color'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->status_entity->getColor(),
        ];

        $this->fields['position'] = [
            "label" => t('status_entity.position'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->status_entity->getPosition(),
        ];

        return $this;

    }

    public static function renderWidget($id = null, $action = "create")
    {
        Genesis::renderView("status_entity.formWidget", self::getFormData($id, $action));
    }

}
    