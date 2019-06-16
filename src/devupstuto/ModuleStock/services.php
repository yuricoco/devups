<?php
            //ModuleStock
		
        require '../../../admin/header.php';
        
        use Genesis as g;
        use Request as R;
        
        header("Access-Control-Allow-Origin: *");
                

		$storageCtrl = new StorageController();
		
     (new Request('hello'));

     switch (R::get('path')) {
                
        case 'storage._new':
                g::json_encode(StorageForm::render());
                break;
        case 'storage.create':
                g::json_encode($storageCtrl->createAction());
                break;
        case 'storage._edit':
                g::json_encode(StorageForm::render(R::get("id")));
                break;
        case 'storage.update':
                g::json_encode($storageCtrl->updateAction(R::get("id")));
                break;
        case 'storage._show':
                StorageForm::__renderDetailWidget(R::get("id"));
                break;
        case 'storage._delete':
                g::json_encode($storageCtrl->deleteAction(R::get("id")));
                break;
        case 'storage._deletegroup':
                g::json_encode($storageCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'storage.datatable':
                g::json_encode($storageCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

	
        default:
            echo json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
            break;
     }

