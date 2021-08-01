<?php


use Genesis as g;

class AddressForm extends FormManager
{

    public static function formBuilder($dataform, $button = false)
    {
        $address = new \Address();
        extract($dataform);
        $entitycore = new Core($address);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;

        //$entitycore->addcss('csspath');

        $entitycore->field['user'] = [
            "label" => "user",
            "hidden" => true,
            "type" => FORMTYPE_SELECT,
            "value" => $address->user->getId(),
            "options" => [$address->user->getId()=>$address->user->getFirstname()],
        ];
        $entitycore->field['label'] = [
            "label" => 'Libelle',
            "type" => FORMTYPE_TEXT,
            "value" => $address->getLabel(),
        ];

        $entitycore->field['country'] = [
            "label" => t('Pays'),
            "type" => FORMTYPE_SELECT,
            "options" => FormManager::Options_Helper("name", Country::allrows("name")),
            "value" => $address->country->getId(),
        ];
        $entitycore->field['town'] = [
            "label" => t('Ville'),
            "type" => FORMTYPE_TEXT,
            "value" => $address->getTown(),
        ];

        $entitycore->field['postalcode'] = [
            "label" => t('Code postal'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $address->getPostalcode(),
        ];

        $entitycore->field['firstname'] = [
            "label" => t('Nom'),
            "type" => FORMTYPE_TEXT,
            "value" => $address->getFirstname(),
        ];
        $entitycore->field['lastname'] = [
            "label" => t('Prénom'),
            "type" => FORMTYPE_TEXT,
            "value" => $address->getLastname(),
        ];

        $entitycore->field['address'] = [
            "label" => t('Adresse complémentaire'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $address->getAddress(),
        ];

        $entitycore->field['email'] = [
            "label" => 'Email',
            "type" => FORMTYPE_TEXT,
            "value" => $address->getEmail(),
        ];
        $entitycore->field['phonenumber'] = [
            "label" => t('Numéro de téléphone'),
            "type" => FORMTYPE_TEXT,
            "value" => $address->getPhonenumber(),
        ];

        $entitycore->addDformjs($button);
        $entitycore->addjs(webapp . 'addressForm');
        //$entitycore->addjs(Address::classpath('Ressource/js/addressForm'));

        return $entitycore;
    }

    public static function __renderForm($dataform, $button = false)
    {
        return FormFactory::__renderForm(AddressForm::formBuilder($dataform, $button));
    }

    public static function getFormData($id = null, $action = "create")
    {
        if (!$id):
            $user = User::userapp();

            $address = new Address();
            $address->setLabel("Mon Adresse");
            $address->setFirstname($user->getFirstname());
            $address->setLastname($user->getLastname());
            $address->setPhonenumber($user->getPhonenumber());
            $address->setCountry($user->getCountry());
            $address->setUser($user);

            return [
                'success' => true,
                'address' => $address,
                'action' => __env.("api/address.create"),
            ];
        endif;

        $address = Address::find($id);
        return [
            'success' => true,
            'address' => $address,
            'action' => __env.("api/address.update?id=") . $id,
        ];

    }

    public static function render($id = null, $action = "create")
    {

        $dataform = self::getFormData($id, $action);
        $dataform["action"] .= "?tablemodel=front";
        g::json_encode(['success' => true,
            'form' => self::__renderForm($dataform, true),
        ]);
    }

    public static function renderaccount($id = null, $action = "create")
    {

        $dataform = self::getFormData($id, $action);
        $dataform["action"] .= "?tablemodel=front";
        $address = new \Address();
        extract($dataform);
        $entitycore = new Core($address);

        $entitycore->formaction = $action;
        $entitycore->formbutton = true;

        //$entitycore->addcss('csspath');


        $entitycore->field['user'] = [
            "label" => "user",
            "hidden" => true,
            "type" => FORMTYPE_SELECT,
            "value" => $address->user->getId(),
            "options" => [$address->user->getId()=>$address->user->getFirstname()],
        ];
        $entitycore->field['label'] = [
            "label" => 'Libelle',
            "type" => FORMTYPE_TEXT,
            "value" => $address->getLabel(),
        ];

        $entitycore->field['country'] = [
            "label" => t('Pays'),
            "type" => FORMTYPE_SELECT,
            "options" => FormManager::Options_Helper("name", Country::allrows("name")),
            "value" => $address->country->getId(),
        ];
        $entitycore->field['town'] = [
            "label" => t('Ville'),
            "type" => FORMTYPE_TEXT,
            "value" => $address->getTown(),
        ];

        $entitycore->field['postalcode'] = [
            "label" => t('Code postal'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $address->getPostalcode(),
        ];

        $entitycore->field['firstname'] = [
            "label" => t('Nom'),
            "type" => FORMTYPE_TEXT,
            "value" => $address->getFirstname(),
        ];
        $entitycore->field['lastname'] = [
            "label" => t('Prénom'),
            "type" => FORMTYPE_TEXT,
            "value" => $address->getLastname(),
        ];

        $entitycore->field['address'] = [
            "label" => t('Informations complementaires'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $address->getAddress(),
        ];

        $entitycore->field['email'] = [
            "label" => 'Email',
            "type" => FORMTYPE_TEXT,
            "value" => $address->getEmail(),
        ];
        $entitycore->field['phonenumber'] = [
            "label" => t('Numéro de téléphone'),
            "type" => FORMTYPE_TEXT,
            "value" => $address->getPhonenumber(),
        ];

        $entitycore->addDformjs(true);
        //$entitycore->addjs(Address::classpath('Ressource/js/addressForm'));

        g::json_encode(['success' => true,
            // 'form' => self::__renderForm(self::getFormData($id, $action), true),
            'form' => FormFactory::__renderForm($entitycore),
        ]);
    }

    public static function renderadmin($id = null, $action = "create")
    {

        $dataform = self::getFormData($id, $action);
        $address = new \Address();
        extract($dataform);
        $entitycore = new Core($address);

        $entitycore->formaction = $action;
        $entitycore->formbutton = true;

        //$entitycore->addcss('csspath');

        $entitycore->field['label'] = [
            "label" => 'Libelle',
            "type" => FORMTYPE_TEXT,
            "value" => $address->getLabel(),
        ];

        $entitycore->field['country'] = [
            "label" => t('Pays'),
            "type" => FORMTYPE_SELECT,
            "options" => FormManager::Options_Helper("name", Country::allrows("name")),
            "value" => $address->country->getId(),
        ];
        $entitycore->field['firstname'] = [
            "label" => t('Nom complet'),
            "type" => FORMTYPE_TEXT,
            "value" => $address->getFirstname(),
        ];
//        $entitycore->field['_type'] = [
//            "label" => 'Type',
//            "type" => FORMTYPE_RADIO,
//            "value" => 3,
//            "options" => [],
//        ];

        $entitycore->field['address'] = [
            "label" => t('Adresse'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $address->getAddress(),
        ];

        $entitycore->field['postalcode'] = [
            "label" => t('Code postal'),
            FH_REQUIRE => false,
            "type" => FORMTYPE_TEXT,
            "value" => $address->getPostalcode(),
        ];

        $entitycore->field['email'] = [
            "label" => 'Email',
            "type" => FORMTYPE_TEXT,
            "value" => $address->getEmail(),
        ];
        $entitycore->field['phonenumber'] = [
            "label" => t('Numéro de téléphone'),
            "type" => FORMTYPE_TEXT,
            "value" => $address->getPhonenumber(),
        ];

        $entitycore->addDformjs(true);
        //$entitycore->addjs(Address::classpath('Ressource/js/addressForm'));

        g::json_encode(['success' => true,
            // 'form' => self::__renderForm(self::getFormData($id, $action), true),
            'form' => FormFactory::__renderForm($entitycore),
        ]);
    }

    public static function renderWidget($id = null, $action = "create")
    {
        g::json_encode(['success' => true,
            // 'form' => self::__renderForm(self::getFormData($id, $action), true),
            'form' => Genesis::getView("customer._partial.addressForm", self::getFormData($id, $action)),
        ]);
    }

}
    