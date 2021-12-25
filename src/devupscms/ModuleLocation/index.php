<?php
//ModuleLocation

require '../../../admin/header.php';

// move comment scope to enable authentication
if (!isset($_SESSION[ADMIN]) and $_GET['path'] != 'connexion') {
    header("location: " . __env . 'admin/login.php');
}

global $viewdir, $moduledata;
$viewdir[] = __DIR__ . '/Resource/views';

$moduledata = Dvups_module::init('ModuleLocation');


$countryCtrl = new CountryController();
$departmentCtrl = new DepartmentController();
$districtCtrl = new DistrictController();
$regionCtrl = new RegionController();
$townCtrl = new TownController();


(new Request('layout'));

switch (Request::get('path')) {

    case 'layout':
        Genesis::renderView("admin.overview");
        break;

    case 'country/index':
        $countryCtrl->listView();
        break;
    case 'continent/index':
        (new ContinentController())->listView();
        break;

    case 'department/index':
        $departmentCtrl->listView();
        break;

    case 'district/index':
        $districtCtrl->listView();
        break;

    case 'region/index':
        $regionCtrl->listView();
        break;

    case 'town/index':
        $townCtrl->listView();
        break;


    default:
        Genesis::renderView('404', ['page' => Request::get('path')]);
        break;
}
    
    