<?php


use Genesis as g;

class CountryForm extends FormManager
{

    public static function formBuilder($dataform, $button = false)
    {
        $country = new \Country();
        extract($dataform);
        $entitycore = new Core($country);

        $entitycore->formaction = $action;
        $entitycore->formbutton = $button;

        //$entitycore->addcss('csspath');


        $entitycore->field['name'] = [
            "label" => 'Name',
            "type" => FORMTYPE_TEXT,
            "value" => $country->getName(),
        ];

        $entitycore->field['phonecode'] = [
            "label" => 'Phonecode',
            "type" => FORMTYPE_TEXT,
            "value" => $country->getPhonecode(),
        ];

        $entitycore->field['status'] = [
            "label" => 'Status',
            "type" => FORMTYPE_RADIO,
            "options" => FormManager::key_as_value(["active", "inactive"]),
            "value" => $country->getStatus(),
        ];

//        $entitycore->field['currency'] = [
//            "type" => FORMTYPE_CHECKBOX,
//            "values" => FormManager::Options_Helper('name', $country->getCurrency()),
//            "label" => 'Available currency',
//            "options" => FormManager::Options_ToCollect_Helper('name', new Dvups_right(), $country->getDvups_right()),
//        ];


        $entitycore->addDformjs($button);
        $entitycore->addjs(Country::classpath('Ressource/js/countryForm'));

        return $entitycore;
    }

    public static function __renderForm($dataform, $button = false)
    {
        return FormFactory::__renderForm(CountryForm::formBuilder($dataform, $button));
    }

    public static function getFormData($id = null, $action = "create")
    {
        if (!$id):
            $country = new Country();

            return [
                'success' => true,
                'country' => $country,
                'action' => "create",
            ];
        endif;

        $country = Country::find($id);
        return [
            'success' => true,
            'country' => $country,
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
        Genesis::renderView("country.formWidget", self::getFormData($id, $action));
    }

}
    