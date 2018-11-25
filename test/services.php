<?php
            //ModuleTest
		
        require '../../../admin/header.php';
        
        use Genesis as g;
        use Request as R;
        
        header("Access-Control-Allow-Origin: *");
                

		$testentityCtrl = new TestentityController();
		
     (new Request('hello'));

     switch (R::get('path')) {
                
        case 'testentity._new':
                g::json_encode(TestentityController::renderForm());
                break;
        case 'testentity.create':
                g::json_encode($testentityCtrl->createAction());
                break;
        case 'testentity._edit':
                g::json_encode(TestentityController::renderForm(R::get("id")));
                break;
        case 'testentity.update':
                g::json_encode($testentityCtrl->updateAction(R::get("id")));
                break;
        case 'testentity._show':
                TestentityController::renderDetail(R::get("id"));
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
            echo json_encode(['error' => "404 : page note found", 'route' => R::get('path')]);
            break;
     }

