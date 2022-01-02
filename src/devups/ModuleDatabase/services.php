<?php
            //ModuleDatabase
		
        require '../../../admin/header.php';
        
// verification token
//

        use Genesis as g;
        use Request as R;
        
        header("Access-Control-Allow-Origin: *");
                

		$request_historyCtrl = new Request_historyController();
		
     (new Request('hello'));

     switch (R::get('path')) {
                
        case 'request_history._new':
                g::json_encode($request_historyCtrl->formView());
                break;
        case 'request_history.create':
                g::json_encode($request_historyCtrl->createAction());
                break;
        case 'request_history.form':
                g::json_encode($request_historyCtrl->formView(R::get("id")));
                break;
        case 'request_history.update':
                g::json_encode($request_historyCtrl->updateAction(R::get("id")));
                break;
        case 'request_history._show':
                $request_historyCtrl->detailView(R::get("id"));
                break;
        case 'request_history._delete':
                g::json_encode($request_historyCtrl->deleteAction(R::get("id")));
                break;
        case 'request_history._deletegroup':
                g::json_encode($request_historyCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'request_history.datatable':
                g::json_encode($request_historyCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

	
        default:
            g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
            break;
     }

