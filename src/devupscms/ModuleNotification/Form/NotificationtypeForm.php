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

        $this->fields['dvups_entity.id'] = [
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


        $this->fields['content'] = [
            "label" => t('Content <br><i>NB: use : to specify a variable i.e: :username</i>'),
            "type" => FORMTYPE_TEXTAREA,
            "value" => $this->notificationtype->getContent(),
        ];

        $this->fields['session'] = [
            "label" => t('Session'),
            "type" => FORMTYPE_RADIO,
            "value" => $this->notificationtype->getSession(),
            "options" => FormManager::key_as_value(["user", "admin"]),
        ];
        $this->fields['redirect'] = [
            "label" => t('Redirect route'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->notificationtype->getRedirect(),
        ];
        $this->fields['emailmodel'] = [
            "label" => t('Email model key / reference'),
            "type" => FORMTYPE_TEXT,
            "value" => $this->notificationtype->getEmailmodel(),
        ];

        return $this;

    }


}
    