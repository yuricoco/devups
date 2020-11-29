<?php


use Genesis as g;

class UserForm extends FormManager
{

    public static function formBuilder($dataform, $button = false)
    {
        $user = new \User();
        extract($dataform);
        $entitycore = new Core($user);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;

        //$entitycore->addcss('csspath');


        $entitycore->field['firstname'] = [
            "label" => t('user.firstname'),
            "type" => FORMTYPE_TEXT,
            "value" => $user->getFirstname(),
        ];

        $entitycore->field['lastname'] = [
            "label" => t('user.lastname'),
            "type" => FORMTYPE_TEXT,
            "value" => $user->getLastname(),
        ];

        $entitycore->field['email'] = [
            "label" => t('user.email'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_EMAIL,
            "value" => $user->getEmail(),
        ];

        $entitycore->field['sex'] = [
            "label" => t('user.sex'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $user->getSex(),
        ];

        $entitycore->field['phonenumber'] = [
            "label" => t('user.phonenumber'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $user->getPhonenumber(),
        ];

        $entitycore->field['password'] = [
            "label" => t('user.password'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $user->getPassword(),
        ];

        $entitycore->field['username'] = [
            "label" => t('user.username'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $user->getUsername(),
        ];

        $entitycore->field['country'] = [
            "type" => FORMTYPE_SELECT,
            "value" => $user->getCountry()->getId(),
            "label" => t('entity.country'),
            "options" => FormManager::Options_Helper('name', Country::allrows()),
        ];

        $entitycore->addDformjs($button);
        $entitycore->addjs(User::classpath('Ressource/js/userForm'));

        return $entitycore;
    }

    public static function __renderForm($dataform, $button = false)
    {
        return FormFactory::__renderForm(UserForm::formBuilder($dataform, $button));
    }

    public static function getFormData($id = null, $action = "create")
    {
        if (!$id):
            $user = new User();

            return [
                'success' => true,
                'user' => $user,
                'action' => "create",
            ];
        endif;

        $user = User::find($id);
        return [
            'success' => true,
            'user' => $user,
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
        Genesis::renderView("user.formWidget", self::getFormData($id, $action));
    }

}
    