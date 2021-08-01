<?php 

        
use Genesis as g;

    class DepartmentForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $department = new \Department();
            extract($dataform);
            $entitycore = new Core($department);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $department->getName(), 
            ];

                $entitycore->field['region'] = [
                    "type" => FORMTYPE_SELECT, 
                    "value" => $department->getRegion()->getId(),
                    "label" => 'Region',
                    "options" => FormManager::Options_Helper('name', Region::allrows()),
                ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Department::classpath('Ressource/js/departmentForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(DepartmentForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $department = new Department();
                
                return [
                    'success' => true,
                    'department' => $department,
                    'action' => "create",
                ];
            endif;
            
            $department = Department::find($id);
            return [
                'success' => true,
                'department' => $department,
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
            Genesis::renderView("department.formWidget", self::getFormData($id, $action));
        }
        
    }
    