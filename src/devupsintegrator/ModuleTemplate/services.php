<?php
            //ModuleTemplate
		
        require '../../../admin/header.php';
        
// verification token
//

        use Genesis as g;
        use Request as R;
        
        header("Access-Control-Allow-Origin: *");
                

		$templateCtrl = new TemplateController();
		$pageCtrl = new PageController();
		$hooksCtrl = new HooksController();
		$blockCtrl = new BlockController();
		
     (new Request('hello'));

     switch (R::get('path')) {
                
        case 'template._new':
                TemplateForm::render();
                break;
        case 'template.create':
                g::json_encode($templateCtrl->createAction());
                break;
        case 'template.form':
                TemplateForm::render(R::get("id"));
                break;
        case 'template.update':
                g::json_encode($templateCtrl->updateAction(R::get("id")));
                break;
        case 'template._show':
                $templateCtrl->detailView(R::get("id"));
                break;
        case 'template._delete':
                g::json_encode($templateCtrl->deleteAction(R::get("id")));
                break;
        case 'template._deletegroup':
                g::json_encode($templateCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'template.datatable':
                g::json_encode($templateCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'page._new':
                PageForm::render();
                break;
        case 'page.create':
                g::json_encode($pageCtrl->createAction());
                break;
        case 'page.form':
                PageForm::render(R::get("id"));
                break;
        case 'page.update':
                g::json_encode($pageCtrl->updateAction(R::get("id")));
                break;
        case 'page._show':
                $pageCtrl->detailView(R::get("id"));
                break;
        case 'page._delete':
                g::json_encode($pageCtrl->deleteAction(R::get("id")));
                break;
        case 'page._deletegroup':
                g::json_encode($pageCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'page.datatable':
                g::json_encode($pageCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'hooks._new':
                HooksForm::render();
                break;
        case 'hooks.create':
                g::json_encode($hooksCtrl->createAction());
                break;
        case 'hooks.form':
                HooksForm::render(R::get("id"));
                break;
        case 'hooks.update':
                g::json_encode($hooksCtrl->updateAction(R::get("id")));
                break;
        case 'hooks._show':
                $hooksCtrl->detailView(R::get("id"));
                break;
        case 'hooks._delete':
                g::json_encode($hooksCtrl->deleteAction(R::get("id")));
                break;
        case 'hooks._deletegroup':
                g::json_encode($hooksCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'hooks.datatable':
                g::json_encode($hooksCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'block._new':
                BlockForm::render();
                break;
        case 'block.create':
                g::json_encode($blockCtrl->createAction());
                break;
        case 'block.form':
                BlockForm::render(R::get("id"));
                break;
        case 'block.update':
                g::json_encode($blockCtrl->updateAction(R::get("id")));
                break;
        case 'block._show':
                $blockCtrl->detailView(R::get("id"));
                break;
        case 'block._delete':
                g::json_encode($blockCtrl->deleteAction(R::get("id")));
                break;
        case 'block._deletegroup':
                g::json_encode($blockCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'block.datatable':
                g::json_encode($blockCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

	
        default:
            g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
            break;
     }

