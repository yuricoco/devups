<?php
            //ModuleStock
		
        require '../../../admin/header.php';
        
        use Genesis as g;
        use Request as R;
        
        header("Access-Control-Allow-Origin: *");
                

		$storageCtrl = new StorageController();
		
     (new Request('hello'));

     switch (Request::get('path')) {
                
        case 'storage._new':
                g::json_encode(StorageController::renderForm());
                break;
        case 'storage._edit':
                g::json_encode(StorageController::renderForm(R::get("id")));
                break;
        case 'storage._show':
                g::json_encode(StorageController::renderDetail(R::get("id")));
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
            echo json_encode("404 : page note found");
            break;
     }

