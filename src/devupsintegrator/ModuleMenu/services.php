<?php
            //ModuleMenu
		
        require '../../../admin/header.php';
        
// verification token
//

        use Genesis as g;
        use Request as R;
        
        header("Access-Control-Allow-Origin: *");
                

		$menuCtrl = new MenuController();
		$encreCtrl = new EncreController();
		$menuencreCtrl = new MenuencreController();
		
     (new Request('hello'));

     switch (R::get('path')) {
                
        case 'menu._new':
                MenuForm::render();
                break;
        case 'menu.create':
                g::json_encode($menuCtrl->createAction());
                break;
        case 'menu._edit':
                MenuForm::render(R::get("id"));
                break;
        case 'menu.update':
                g::json_encode($menuCtrl->updateAction(R::get("id")));
                break;
        case 'menu._show':
                $menuCtrl->detailView(R::get("id"));
                break;
        case 'menu._delete':
                g::json_encode($menuCtrl->deleteAction(R::get("id")));
                break;
        case 'menu._deletegroup':
                g::json_encode($menuCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'menu.datatable':
                g::json_encode($menuCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'encre._new':
                EncreForm::render();
                break;
        case 'encre.create':
                g::json_encode($encreCtrl->createAction());
                break;
        case 'encre._edit':
                EncreForm::render(R::get("id"));
                break;
        case 'encre.update':
                g::json_encode($encreCtrl->updateAction(R::get("id")));
                break;
        case 'encre._show':
                $encreCtrl->detailView(R::get("id"));
                break;
        case 'encre._delete':
                g::json_encode($encreCtrl->deleteAction(R::get("id")));
                break;
        case 'encre._deletegroup':
                g::json_encode($encreCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'encre.datatable':
                g::json_encode($encreCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'menuencre._new':
                MenuencreForm::render();
                break;
        case 'menuencre.create':
                g::json_encode($menuencreCtrl->createAction());
                break;
        case 'menuencre._edit':
                MenuencreForm::render(R::get("id"));
                break;
        case 'menuencre.update':
                g::json_encode($menuencreCtrl->updateAction(R::get("id")));
                break;
        case 'menuencre._show':
                $menuencreCtrl->detailView(R::get("id"));
                break;
        case 'menuencre._delete':
                g::json_encode($menuencreCtrl->deleteAction(R::get("id")));
                break;
        case 'menuencre._deletegroup':
                g::json_encode($menuencreCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'menuencre.datatable':
                g::json_encode($menuencreCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

	
        default:
            g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
            break;
     }

