<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 6/5/2018
 * Time: 9:49 PM
 */

require '../../../admin/header.php';

use Genesis as g;

header("Access-Control-Allow-Origin: *");


(new Request('hello'));

switch (Request::get('path')) {
    case 'dvups_entity.updatelabel':
        g::json_encode(Dvups_entityController::updatelabel($_GET['id'], $_GET['label']));
        break;

    case 'dvups_module.updatelabel':
        g::json_encode(Dvups_moduleController::updatelabel($_GET['id'], $_GET['label']));
        break;

    default :
        echo json_encode("404 : page note found");
        break;
}