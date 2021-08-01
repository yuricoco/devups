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
            "label" => 'Firstname',
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $user->getFirstname(),
        ];

        $entitycore->field['lastname'] = [
            "label" => 'Lastname',
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $user->getLastname(),
        ];

        $entitycore->field['email'] = [
            "label" => 'Email',
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $user->getEmail(),
        ];

        $entitycore->field['sexe'] = [
            "label" => 'Sexe',
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $user->getSexe(),
        ];

        $entitycore->field['phonenumber'] = [
            "label" => 'Phonenumber',
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $user->getPhonenumber(),
        ];

        $entitycore->field['professional'] = [
            "label" => 'Is professional',
            FH_REQUIRE => false,
            "type" => FORMTYPE_RADIO,
            "options" => ["No", 'Yes'],
            "value" => $user->getProfessional(),
        ];

        $entitycore->field['updatePassword'] = [
            "label" => 'Password',
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => "",
        ];
        $entitycore->field['country'] = [
            "label" => 'Country',
            FH_REQUIRE => false,
            "type" => FORMTYPE_SELECT,
            "value" => $user->country->getId(),
            "options" => FormManager::Options_Helper("name", Country::allrows()),
        ];

        $entitycore->field['is_activated'] = [
            "label" => 'Is_activated',
            FH_REQUIRE => false,
            "type" => FORMTYPE_RADIO,
            "options" => ["No", 'Yes'],
            "value" => $user->getIs_activated(),
        ];


        $entitycore->field['lang'] = [
            "label" => 'Lang',
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $user->getLang(),
        ];

        $entitycore->field['username'] = [
            "label" => 'Username',
            "type" => FORMTYPE_TEXT,
            "value" => $user->getUsername(),
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
                'action' => User::classpath("services.php?path=user.create"),
            ];
        endif;

        $user = User::find($id);
        return [
            'success' => true,
            'user' => $user,
            'action' => User::classpath("services.php?path=user.update&id=" . $id),
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
    