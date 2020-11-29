<?php
            //ModuleSocial
		
        require '../../../admin/header.php';
        
// verification token
//

        use Genesis as g;
        use Request as R;
        
        header("Access-Control-Allow-Origin: *");
                

		$social_networkCtrl = new Social_networkController();
		
     (new Request('hello'));

     switch (R::get('path')) {
                
        case 'social_network._new':
                Social_networkForm::render();
                break;
        case 'social_network.create':
                g::json_encode($social_networkCtrl->createAction());
                break;
        case 'social_network._edit':
                Social_networkForm::render(R::get("id"));
                break;
        case 'social_network.update':
                g::json_encode($social_networkCtrl->updateAction(R::get("id")));
                break;
        case 'social_network._show':
                $social_networkCtrl->detailView(R::get("id"));
                break;
        case 'social_network._delete':
                g::json_encode($social_networkCtrl->deleteAction(R::get("id")));
                break;
        case 'social_network._deletegroup':
                g::json_encode($social_networkCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'social_network.datatable':
                g::json_encode($social_networkCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

	
        default:
            g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
            break;
     }

