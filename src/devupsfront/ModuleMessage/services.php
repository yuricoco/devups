<?php
            //ModuleMessage
		
        require '../../../admin/header.php';
        
// verification token
//

        use Genesis as g;
        use Request as R;
        
        header("Access-Control-Allow-Origin: *");
                

		$messageCtrl = new MessageController();
		$newsletterCtrl = new NewsletterController();
		
     (new Request('hello'));

     switch (R::get('path')) {
                
        case 'message._new':
                g::json_encode($messageCtrl->formView());
                break;
        case 'message.create':
                g::json_encode($messageCtrl->createAction());
                break;
        case 'message.form':
                g::json_encode($messageCtrl->formView(R::get("id")));
                break;
        case 'message.update':
                g::json_encode($messageCtrl->updateAction(R::get("id")));
                break;
        case 'message._show':
                $messageCtrl->detailView(R::get("id"));
                break;
        case 'message._delete':
                g::json_encode($messageCtrl->deleteAction(R::get("id")));
                break;
        case 'message._deletegroup':
                g::json_encode($messageCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'message.datatable':
                g::json_encode($messageCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'newsletter._new':
                g::json_encode($newsletterCtrl->formView());
                break;
        case 'newsletter.create':
                g::json_encode($newsletterCtrl->createAction());
                break;
        case 'newsletter.form':
                g::json_encode($newsletterCtrl->formView(R::get("id")));
                break;
        case 'newsletter.update':
                g::json_encode($newsletterCtrl->updateAction(R::get("id")));
                break;
        case 'newsletter._show':
                $newsletterCtrl->detailView(R::get("id"));
                break;
        case 'newsletter._delete':
                g::json_encode($newsletterCtrl->deleteAction(R::get("id")));
                break;
        case 'newsletter._deletegroup':
                g::json_encode($newsletterCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'newsletter.datatable':
                g::json_encode($newsletterCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

	
        default:
            g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
            break;
     }

