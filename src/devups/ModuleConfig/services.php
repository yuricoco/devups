<?php
            //ModuleConfig
		
        require '../../../admin/header.php';
        
// verification token
//

        use Genesis as g;
        use Request as R;
        
        header("Access-Control-Allow-Origin: *");
                

		$dvups_componentCtrl = new Dvups_componentController();
		$dvups_entityCtrl = new Dvups_entityController();
		$dvups_moduleCtrl = new Dvups_moduleController();
		$configurationCtrl = new ConfigurationController();
		
     (new Request('hello'));

     switch (R::get('path')) {
                
        case 'dvups_component._new':
                Dvups_componentForm::render();
                break;
        case 'dvups_component.create':
                g::json_encode($dvups_componentCtrl->createAction());
                break;
        case 'dvups_component.form':
                Dvups_componentForm::render(R::get("id"));
                break;
        case 'dvups_component.update':
                g::json_encode($dvups_componentCtrl->updateAction(R::get("id")));
                break;
        case 'dvups_component._show':
                $dvups_componentCtrl->detailView(R::get("id"));
                break;
        case 'dvups_component._delete':
                g::json_encode($dvups_componentCtrl->deleteAction(R::get("id")));
                break;
        case 'dvups_component._deletegroup':
                g::json_encode($dvups_componentCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'dvups_component.datatable':
                g::json_encode($dvups_componentCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'dvups_entity._new':
                Dvups_entityForm::render();
                break;
        case 'dvups_entity.create':
                g::json_encode($dvups_entityCtrl->createAction());
                break;
        case 'dvups_entity.form':
                Dvups_entityForm::render(R::get("id"));
                break;
        case 'dvups_entity.update':
                g::json_encode($dvups_entityCtrl->updateAction(R::get("id")));
                break;
        case 'dvups_entity._show':
                $dvups_entityCtrl->detailView(R::get("id"));
                break;
        case 'dvups_entity._delete':
                g::json_encode($dvups_entityCtrl->deleteAction(R::get("id")));
                break;
        case 'dvups_entity._deletegroup':
                g::json_encode($dvups_entityCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'dvups_entity.datatable':
                g::json_encode($dvups_entityCtrl->datatable(R::get('next'), R::get('per_page')));
                break;
        case 'dvups-entity.truncate':
                g::json_encode($dvups_entityCtrl->truncateAction(R::get('id')));
                break;

        case 'dvups_module._new':
                Dvups_moduleForm::render();
                break;
        case 'dvups_module.create':
                g::json_encode($dvups_moduleCtrl->createAction());
                break;
        case 'dvups_module.form':
                Dvups_moduleForm::render(R::get("id"));
                break;
        case 'dvups_module.update':
                g::json_encode($dvups_moduleCtrl->updateAction(R::get("id")));
                break;
        case 'dvups_module._show':
                $dvups_moduleCtrl->detailView(R::get("id"));
                break;
        case 'dvups_module._delete':
                g::json_encode($dvups_moduleCtrl->deleteAction(R::get("id")));
                break;
        case 'dvups_module._deletegroup':
                g::json_encode($dvups_moduleCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'dvups_module.datatable':
                g::json_encode($dvups_moduleCtrl->datatable(R::get('next'), R::get('per_page')));
                break;

        case 'configuration._new':
                ConfigurationForm::render();
                break;
        case 'configuration.create':
                g::json_encode($configurationCtrl->createAction());
                break;
        case 'configuration.form':
                ConfigurationForm::render(R::get("id"));
                break;
        case 'configuration.update':
                g::json_encode($configurationCtrl->updateAction(R::get("id")));
                break;
        case 'configuration._show':
                $configurationCtrl->detailView(R::get("id"));
                break;
        case 'configuration._delete':
                g::json_encode($configurationCtrl->deleteAction(R::get("id")));
                break;
        case 'configuration._deletegroup':
                g::json_encode($configurationCtrl->deletegroupAction(R::get("ids")));
                break;
        case 'configuration.datatable':
                g::json_encode($configurationCtrl->datatable(R::get('next'), R::get('per_page')));
                break;
        case 'configuration.build':
                g::json_encode($configurationCtrl->buildAction());
                break;

	
        default:
            g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
            break;
     }

