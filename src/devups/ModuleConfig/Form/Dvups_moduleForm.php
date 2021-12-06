<?php 

        
use Genesis as g;

    class Dvups_moduleForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $dvups_module = new \Dvups_module();
            extract($dataform);
            $entitycore = new Core($dvups_module);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');

            $entitycore->field['dvups_component.id'] = [
                "type" => FORMTYPE_SELECT,
                "value" => $dvups_module->dvups_component->getId(),
                "label" => t('entity.dvups_component'),
                "options" => FormManager::Options_Helper('name', Dvups_component::allrows()),
            ];

            if($dvups_module->getId()){

                $entitycore->field['name'] = [
                    "label" => 'Name',
                    "type" => FORMTYPE_TEXT,
                    "directive" => ["readonly"=>true],
                    "value" => $dvups_module->getName(),
                ];

            }else{

                $entitycore->field['name'] = [
                    "label" => 'Name',
                    "type" => FORMTYPE_TEXT,
                    "value" => $dvups_module->getName(),
                ];

            }

            $entitycore->field['label'] = [
                "label" => 'Label',
                "type" => FORMTYPE_TEXT,
                //"lang" => true,
                "value" => $dvups_module->label,
            ];
            $entitycore->field['favicon'] = [
                "label" => 'Favicon',
                "type" => FORMTYPE_TEXT,
                "value" => $dvups_module->getFavicon(),
            ];


            $entitycore->addDformjs($button);
            $entitycore->addjs(Dvups_module::classpath('Ressource/js/dvups_moduleForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(Dvups_moduleForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $dvups_module = new Dvups_module();
                
                return [
                    'success' => true,
                    'dvups_module' => $dvups_module,
                    'action' => Dvups_module::classpath("services.php?path=dvups_module.create"),
                ];
            endif;
            
            $dvups_module = Dvups_module::find($id);
            return [
                'success' => true,
                'dvups_module' => $dvups_module,
                'action' => Dvups_module::classpath("services.php?path=dvups_module.update&id=") . $id,
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
            Genesis::renderView("dvups_module.formWidget", self::getFormData($id, $action));
        }
        
    }
    