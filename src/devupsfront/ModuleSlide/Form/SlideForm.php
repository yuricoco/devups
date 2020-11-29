<?php 

        
use Genesis as g;

    class SlideForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $slide = new \Slide();
            extract($dataform);
            $entitycore = new Core($slide);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['activated'] = [
                "label" => t('slide.activated'), 
			FH_REQUIRE => false,
 			"type" => FORMTYPE_TEXT, 
                "value" => $slide->getActivated(), 
            ];

            $entitycore->field['width_size'] = [
                "label" => t('slide.width_size'), 
			FH_REQUIRE => false,
 			"type" => FORMTYPE_TEXT, 
                "value" => $slide->getWidth_size(), 
            ];

            $entitycore->field['height_size'] = [
                "label" => t('slide.height_size'), 
			FH_REQUIRE => false,
 			"type" => FORMTYPE_TEXT, 
                "value" => $slide->getHeight_size(), 
            ];

            $entitycore->field['title'] = [
                "label" => t('slide.title'), 
			FH_REQUIRE => false,
 			"type" => FORMTYPE_TEXT, 
                "value" => $slide->getTitle(), 
            ];

            $entitycore->field['content'] = [
                "label" => t('slide.content'), 
			FH_REQUIRE => false,
 			"type" => FORMTYPE_TEXT, 
                "value" => $slide->getContent(), 
            ];

            $entitycore->field['image'] = [
                "label" => t('slide.image'), 
			"type" => FORMTYPE_FILE,
                "filetype" => FILETYPE_IMAGE, 
                "value" => $slide->getImage(),
                "src" => $slide->showImage(), 
            ];

            $entitycore->field['path'] = [
                "label" => t('slide.path'), 
			FH_REQUIRE => false,
 			"type" => FORMTYPE_TEXT, 
                "value" => $slide->getPath(), 
            ];

            $entitycore->field['targeturl'] = [
                "label" => t('slide.targeturl'), 
			FH_REQUIRE => false,
 			"type" => FORMTYPE_TEXT, 
                "value" => $slide->getTargeturl(), 
            ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Slide::classpath('Ressource/js/slideForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(SlideForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $slide = new Slide();
                
                return [
                    'success' => true,
                    'slide' => $slide,
                    'action' => "create",
                ];
            endif;
            
            $slide = Slide::find($id);
            return [
                'success' => true,
                'slide' => $slide,
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
            Genesis::renderView("slide.formWidget", self::getFormData($id, $action));
        }
        
    }
    