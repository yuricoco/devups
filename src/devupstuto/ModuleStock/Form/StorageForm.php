<?php 

    class StorageForm extends FormManager{

        public static function formBuilder(\Storage $storage, $action = null, $button = false) {
            $entitycore = new Core($storage);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['name'] = [
                "label" => 'Name', 
			"type" => FORMTYPE_TEXT, 
                "value" => $storage->getName(), 
            ];

            
            $entitycore->addDformjs($action);
            $entitycore->addjs(Storage::classpath('Ressource/js/storageForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm(\Storage $storage, $action = null, $button = false) {
            return FormFactory::__renderForm(StorageForm::formBuilder($storage, $action, $button));
        }
        
        public static function __renderFormWidget(\Storage $storage, $action_form = null) {
            include Storage::classroot("Form/StorageFormWidget.php");
        }

        public static function __renderDetailWidget($id){
            $storage = Storage::find($id);
            include Storage::classroot("Form/StorageDetailWidget.php");
        }

        public static function render($id = null, $action = "create")
        {
            $storage = new Storage();
            if ($id) {
                $action = "update&id=" . $id;
                $storage = Storage::find($id);
                //$storage->collectStorage();
            }

            return ['success' => true,
                'form' => StorageForm::__renderForm($storage, $action, true),
            ];
        }

    }
    