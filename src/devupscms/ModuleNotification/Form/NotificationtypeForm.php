<?php


use Genesis as g;

class NotificationtypeForm extends FormManager
{

    public $notificationtype;

    public static function init(\Notificationtype $notificationtype, $action = "")
    {
        $fb = new NotificationtypeForm($notificationtype, $action);
        $fb->notificationtype = $notificationtype;
        return $fb;
    }

    public function buildForm()
    {

        $this->fields['dvups_entity'] = [
            "label" => t('Entity'),
            "type" => FORMTYPE_SELECT,
            "options" => FormManager::Options_Helper("name", Dvups_entity::allrows(" name ")),
            "value" => $this->notificationtype->dvups_entity->getId(),
        ];

        $this->fields['_key'] = [
            "label" => t('Event i.e: new_message '),
            "type" => FORMTYPE_TEXT,
            "value" => $this->notificationtype->get_key(),
        ];

        $this->fields['redirect'] = [
            "label" => t('Redirect route'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->notificationtype->getRedirect(),
        ];

        $this->fields['content'] = [
            "label" => t('notificationtype.content'),
            "type" => FORMTYPE_TEXTAREA,
            "value" => $this->notificationtype->getContent(),
        ];

        return $this;

    }

    public static function renderWidget($id = null, $action = "create")
    {
        Genesis::renderView("notificationtype.formWidget", self::getFormData($id, $action));
    }

}
    