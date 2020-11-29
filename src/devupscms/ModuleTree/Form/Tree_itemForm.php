<?php 

        
use Genesis as g;

    class Tree_itemForm extends FormManager{

        public static function formBuilder($dataform, $button = false) {
            $tree_item = new \Tree_item();
            extract($dataform);
            $entitycore = new Core($tree_item);
            
            $entitycore->formaction = $action;
            $entitycore->formbutton = $button;
            
            //$entitycore->addcss('csspath');
                
            
            $entitycore->field['name'] = [
                "label" => t('tree_item.name'), 
"type" => FORMTYPE_TEXT,
                "value" => $tree_item->getName(), 
            ];

            $entitycore->field['description'] = [
                "label" => t('tree_item.description'), 
			FH_REQUIRE => false,
 "type" => FORMTYPE_TEXT,
                "value" => $tree_item->getDescription(), 
            ];

            $entitycore->field['parent_id'] = [
                "label" => t('tree_item.parent_id'), 
			FH_REQUIRE => false,
 "type" => FORMTYPE_TEXT,
                "value" => $tree_item->getParent_id(), 
            ];

            $entitycore->field['main'] = [
                "label" => t('tree_item.main'), 
			FH_REQUIRE => false,
 "type" => FORMTYPE_TEXT,
                "value" => $tree_item->getMain(), 
            ];

                $entitycore->field['tree'] = [
                    "type" => FORMTYPE_SELECT, 
                    "value" => $tree_item->getTree()->getId(),
                    "label" => t('entity.tree'),
                    "options" => FormManager::Options_Helper('name', Tree::allrows()),
                ];

            
            $entitycore->addDformjs($button);
            $entitycore->addjs(Tree_item::classpath('Ressource/js/tree_itemForm'));
            
            return $entitycore;
        }
        
        public static function __renderForm($dataform, $button = false) {
            return FormFactory::__renderForm(Tree_itemForm::formBuilder($dataform,  $button));
        }
        
        public static function getFormData($id = null, $action = "create")
        {
            if (!$id):
                $tree_item = new Tree_item();
                
                return [
                    'success' => true,
                    'tree_item' => $tree_item,
                    'action' => "create",
                ];
            endif;
            
            $tree_item = Tree_item::find($id);
            return [
                'success' => true,
                'tree_item' => $tree_item,
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
            Genesis::renderView("tree_item.formWidget", self::getFormData($id, $action));
        }
        
    }
    