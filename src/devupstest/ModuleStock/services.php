<?php
            //ModuleStock
		
        require '../../../admin/header.php';
        
// verification token
//

        use Genesis as g;
        use Request as R;
        
        header("Access-Control-Allow-Origin: *");
                

		$stockCtrl = new StockController();
		
     (new Request('hello'));

     switch (R::get('path')) {
                
        case 'stock._new':
                StockForm::render();
                break;
        case 'stock.create':
                g::json_encode($stockCtrl->createAction());
                break;
        case 'stock._edit':
                StockForm::render(R::get("id"));
                break;
        case 'stock.update':
                g::json_encode($stockCtrl->updateAction(R::get("id")));
                break;
        case 'stock._show':
                StockForm::__renderDetailWidget(R::get("id"));
                break;
        case 'stock._delete':
                g::json_encode($stockCtrl->deleteAction(R::get("id")));
                break;
        case 'stock._deletegroup':
                g::json_encode($stockCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'stock.datatable':
                g::json_encode($stockCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

	
        default:
            echo json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
            break;
     }

