<?php
            //ModuleTest
		
        require '../../../admin/header.php';
        
        use Genesis as g;
        use Request as R;
        
        header("Access-Control-Allow-Origin: *");
                

		$testentityCtrl = new TestentityController();
		
     (new Request('hello'));

     switch (Request::get('path')) {
                
        case 'testentity._new':
                g::json_encode(TestentityController::renderForm());
                break;

        case 'testentity._edit':
                g::json_encode(TestentityController::renderForm(R::get("id")));
                break;

        case 'testentity._show':
                g::json_encode(TestentityController::renderDetail(R::get("id")));
                break;

        case 'testentity._delete':
                g::json_encode($testentityCtrl->deleteAction(R::get("id")));
                break;

        case 'testentity._deletegroup':
                g::json_encode($testentityCtrl->deletegroupAction(R::get("ids")));
                break;

        case 'testentity.datatable':
                g::json_encode($testentityCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

	
        default:
            echo json_encode("404 : route '".Request::get('path')."' note found");
            break;
     }

