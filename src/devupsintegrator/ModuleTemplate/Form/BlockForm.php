<?php 

        
use Genesis as g;

    class BlockForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $block = new \Block();
            extract($dataform);
            $entitycore = new Core($block);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['label'] = [
                "label" => t('block.label'), 
			"type" => FORMTYPE_TEXT, 
                "value" => $block->getLabel(), 
            ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Block::classpath('Ressource/js/blockForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(BlockForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $block = new Block();
                
                return [
                    'success' => true,
                    'block' => $block,
                    'action' => "create",
                ];
            endif;
            
            $block = Block::find($id);
            return [
                'success' => true,
                'block' => $block,
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
            Genesis::renderView("block.formWidget", self::getFormData($id, $action));
        }
        
    }
    