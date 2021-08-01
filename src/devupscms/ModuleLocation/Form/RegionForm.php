<?php 

        
use Genesis as g;

    class RegionForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $region = new \Region();
            extract($dataform);
            $entitycore = new Core($region);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $region->getName(), 
            ];

                $entitycore->field['country'] = [
                    "type" => FORMTYPE_SELECT, 
                    "value" => $region->getCountry()->getId(),
                    "label" => 'Country',
                    "options" => FormManager::Options_Helper('name', Country::allrows()),
                ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Region::classpath('Ressource/js/regionForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(RegionForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $region = new Region();
                
                return [
                    'success' => true,
                    'region' => $region,
                    'action' => "create",
                ];
            endif;
            
            $region = Region::find($id);
            return [
                'success' => true,
                'region' => $region,
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
            Genesis::renderView("region.formWidget", self::getFormData($id, $action));
        }
        
    }
    