<?php 

    class ImageForm extends FormManager{

        public static function formBuilder(\Image $image, $action = null, $button = false) {
            $entitycore = $image->scan_entity_core();
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
                
            
            $entitycore->field['image'] = [
                "label" => 'Image', 
			"type" => FORMTYPE_FILE,
                "filetype" => FILETYPE_IMAGE, 
                "value" => $image->getImage(),
                "src" => $image->showImage(), 
            ];


            return $entitycore;
        }
        
        public static function __renderForm(\Image $image, $action = null, $button = false) {
            return FormFactory::__renderForm(ImageForm::formBuilder($image, $action, $button));
        }
        
    }
    