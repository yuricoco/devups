<?php
            //ModuleMessage
		
        require '../../../admin/header.php';
        
// verification token
//

        use Genesis as g;
        use Request as R;
        
        header("Access-Control-Allow-Origin: *");
                

		$emailmodelCtrl = new EmailmodelController();
		$messageCtrl = new MessageController();
		$newsletterCtrl = new NewsletterController();
		
     (new Request('hello'));

     switch (R::get('path')) {
                
        case 'emailmodel._new':
                EmailmodelForm::render();
                break;
        case 'emailmodel.create':
                g::json_encode($emailmodelCtrl->createAction());
                break;
        case 'emailmodel._edit':
                EmailmodelForm::render(R::get("id"));
                break;
        case 'emailmodel.update':
                g::json_encode($emailmodelCtrl->updateAction(R::get("id")));
                break;
        case 'emailmodel._show':
                $emailmodelCtrl->detailView(R::get("id"));
                break;
        case 'emailmodel._delete':
                g::json_encode($emailmodelCtrl->deleteAction(R::get("id")));
                break;
        case 'emailmodel._deletegroup':
                g::json_encode($emailmodelCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'emailmodel.datatable':
                g::json_encode($emailmodelCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'message._new':
                MessageForm::render();
                break;
        case 'message.create':
                g::json_encode($messageCtrl->createAction());
                break;
        case 'message._edit':
                MessageForm::render(R::get("id"));
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
                NewsletterForm::render();
                break;
        case 'newsletter.create':
                g::json_encode($newsletterCtrl->createAction());
                break;
        case 'newsletter._edit':
                NewsletterForm::render(R::get("id"));
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

