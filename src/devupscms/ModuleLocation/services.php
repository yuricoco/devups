<?php
//ModuleLocation

require '../../../admin/header.php';

// verification token
//

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");


$countryCtrl = new CountryController();
$departmentCtrl = new DepartmentController();
$districtCtrl = new DistrictController();
$regionCtrl = new RegionController();
$townCtrl = new TownController();

(new Request('hello'));

switch (R::get('path')) {

    case 'country._new':
        g::json_encode($countryCtrl->formView());
        break;
    case 'country.create':
        g::json_encode($countryCtrl->createAction());
        break;
    case 'country.form':
        g::json_encode($countryCtrl->formView(R::get("id")));
        break;
    case 'country.update':
        g::json_encode($countryCtrl->updateAction(R::get("id")));
        break;
    case 'country._show':
        $countryCtrl->detailView(R::get("id"));
        break;
    case 'country._delete':
        g::json_encode($countryCtrl->deleteAction(R::get("id")));
        break;
    case 'country._deletegroup':
        g::json_encode($countryCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'country.datatable':
        g::json_encode($countryCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'department._new':
        g::json_encode($departmentCtrl->formView());
        break;
    case 'department.create':
        g::json_encode($departmentCtrl->createAction());
        break;
    case 'department.form':
        g::json_encode($departmentCtrl->formView(R::get("id")));
        break;
    case 'department.update':
        g::json_encode($departmentCtrl->updateAction(R::get("id")));
        break;
    case 'department._show':
        $departmentCtrl->detailView(R::get("id"));
        break;
    case 'department._delete':
        g::json_encode($departmentCtrl->deleteAction(R::get("id")));
        break;
    case 'department._deletegroup':
        g::json_encode($departmentCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'department.datatable':
        g::json_encode($departmentCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'district._new':
        g::json_encode($districtCtrl->formView());
        break;
    case 'district.create':
        g::json_encode($districtCtrl->createAction());
        break;
    case 'district.form':
        g::json_encode($districtCtrl->formView(R::get("id")));
        break;
    case 'district.update':
        g::json_encode($districtCtrl->updateAction(R::get("id")));
        break;
    case 'district._show':
        $districtCtrl->detailView(R::get("id"));
        break;
    case 'district._delete':
        g::json_encode($districtCtrl->deleteAction(R::get("id")));
        break;
    case 'district._deletegroup':
        g::json_encode($districtCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'district.datatable':
        g::json_encode($districtCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'region._new':
        g::json_encode($regionCtrl->formView());
        break;
    case 'region.create':
        g::json_encode($regionCtrl->createAction());
        break;
    case 'region.form':
        g::json_encode($regionCtrl->formView(R::get("id")));
        break;
    case 'region.update':
        g::json_encode($regionCtrl->updateAction(R::get("id")));
        break;
    case 'region._show':
        $regionCtrl->detailView(R::get("id"));
        break;
    case 'region._delete':
        g::json_encode($regionCtrl->deleteAction(R::get("id")));
        break;
    case 'region._deletegroup':
        g::json_encode($regionCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'region.datatable':
        g::json_encode($regionCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'town._new':
        g::json_encode($townCtrl->formView());
        break;
    case 'town.create':
        g::json_encode($townCtrl->createAction());
        break;
    case 'town.form':
        g::json_encode($townCtrl->formView(R::get("id")));
        break;
    case 'town.update':
        g::json_encode($townCtrl->updateAction(R::get("id")));
        break;
    case 'town._show':
        $townCtrl->detailView(R::get("id"));
        break;
    case 'town._delete':
        g::json_encode($townCtrl->deleteAction(R::get("id")));
        break;
    case 'town._deletegroup':
        g::json_encode($townCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'town.datatable':
        g::json_encode($townCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    case 'continent._new':
        g::json_encode((new ContinentController())->formView());
        break;
    case 'continent.create':
        g::json_encode((new ContinentController())->createAction());
        break;
    case 'continent.form':
        g::json_encode((new ContinentController())->formView(R::get("id")));
        break;
    case 'continent.update':
        g::json_encode((new ContinentController())->updateAction(R::get("id")));
        break;
    case 'continent._show':
        (new ContinentController())->detailView(R::get("id"));
        break;
    case 'continent._delete':
        g::json_encode((new ContinentController())->deleteAction(R::get("id")));
        break;
    case 'continent._deletegroup':
        g::json_encode((new ContinentController())->deletegroupAction(R::get("ids")));
        break;
    case 'continent.datatable':
        g::json_encode((new ContinentController())->datatable(R::get('next'), R::get('per_page')));
        break;


    default:
        g::json_encode(['success' => false, 'error' => ['message' => "404 : action note found", 'route' => R::get('path')]]);
        break;
}

