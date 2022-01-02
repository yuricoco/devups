<?php
            //ModuleTree
		
        require '../../../admin/header.php';
        
// verification token
//

        use Genesis as g;
        use Request as R;
        
        header("Access-Control-Allow-Origin: *");
                

		$treeCtrl = new TreeController();
		$tree_itemCtrl = new Tree_itemController();
		$tree_item_langCtrl = new Tree_item_langController();
		$tree_item_imageCtrl = new Tree_item_imageController();
		
     (new Request('hello'));

     switch (R::get('path')) {
                
        case 'tree._new':
                g::json_encode($treeCtrl->formView());
                break;
        case 'tree.create':
                g::json_encode($treeCtrl->createAction());
                break;
        case 'tree.form':
                g::json_encode($treeCtrl->formView(R::get("id")));
                break;
        case 'tree.update':
                g::json_encode($treeCtrl->updateAction(R::get("id")));
                break;
        case 'tree._show':
                $treeCtrl->detailView(R::get("id"));
                break;
        case 'tree._delete':
                g::json_encode($treeCtrl->deleteAction(R::get("id")));
                break;
        case 'tree._deletegroup':
                g::json_encode($treeCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'tree.datatable':
                g::json_encode($treeCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'tree_item._new':
                g::json_encode($tree_itemCtrl->formView());
                break;
        case 'tree_item.create':
                g::json_encode($tree_itemCtrl->createAction());
                break;
        case 'tree_item.form':
                g::json_encode($tree_itemCtrl->formView(R::get("id")));
                break;
        case 'tree_item.update':
                g::json_encode($tree_itemCtrl->updateAction(R::get("id")));
                break;
        case 'tree_item._show':
                $tree_itemCtrl->detailView(R::get("id"));
                break;
        case 'tree_item._delete':
                g::json_encode($tree_itemCtrl->deleteAction(R::get("id")));
                break;
        case 'tree_item._deletegroup':
                g::json_encode($tree_itemCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'tree_item.datatable':
                g::json_encode($tree_itemCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'tree_item_lang._new':
                g::json_encode($tree_item_langCtrl->formView());
                break;
        case 'tree_item_lang.create':
                g::json_encode($tree_item_langCtrl->createAction());
                break;
        case 'tree_item_lang.form':
                g::json_encode($tree_item_langCtrl->formView(R::get("id")));
                break;
        case 'tree_item_lang.update':
                g::json_encode($tree_item_langCtrl->updateAction(R::get("id")));
                break;
        case 'tree_item_lang._show':
                $tree_item_langCtrl->detailView(R::get("id"));
                break;
        case 'tree_item_lang._delete':
                g::json_encode($tree_item_langCtrl->deleteAction(R::get("id")));
                break;
        case 'tree_item_lang._deletegroup':
                g::json_encode($tree_item_langCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'tree_item_lang.datatable':
                g::json_encode($tree_item_langCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'tree_item_image._new':
                g::json_encode($tree_item_imageCtrl->formView());
                break;
        case 'tree_item_image.create':
                g::json_encode($tree_item_imageCtrl->createAction());
                break;
        case 'tree_item_image.form':
                g::json_encode($tree_item_imageCtrl->formView(R::get("id")));
                break;
        case 'tree_item_image.update':
                g::json_encode($tree_item_imageCtrl->updateAction(R::get("id")));
                break;
        case 'tree_item_image._show':
                $tree_item_imageCtrl->detailView(R::get("id"));
                break;
        case 'tree_item_image._delete':
                g::json_encode($tree_item_imageCtrl->deleteAction(R::get("id")));
                break;
        case 'tree_item_image._deletegroup':
                g::json_encode($tree_item_imageCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'tree_item_image.datatable':
                g::json_encode($tree_item_imageCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

	
        default:
            g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
            break;
     }

