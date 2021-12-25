<?php 

        
use Genesis as g;

    class DistrictForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $district = new \District();
            extract($dataform);
            $entitycore = new Core($district);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $district->getName(), 
            ];

                $entitycore->field['town'] = [
                    "type" => FORMTYPE_SELECT, 
                    "value" => $district->getTown()->getId(),
                    "label" => 'Town',
                    "options" => FormManager::Options_Helper('name', Town::allrows()),
                ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(District::classpath('Ressource/js/districtForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(DistrictForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $district = new District();
                
                return [
                    'success' => true,
                    'district' => $district,
                    'action' => "create",
                ];
            endif;
            
            $district = District::find($id);
            return [
                'success' => true,
                'district' => $district,
                'action' => "update&id=" . $id,
            ];

        }
        
        public static function render($id = null, $action = "create")
        {
            g::json_encode(['success' => true,
                'form' => self::__renderForm(self::getFormData($id, $action),true),
            ]);
        }

        public static function renderWidget($id = null, $action = "create")
        {
            Genesis::renderView("district.formWidget", self::getFormData($id, $action));
        }
        
    }
    