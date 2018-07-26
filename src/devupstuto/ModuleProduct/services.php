<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 6/5/2018
 * Time: 9:49 PM
 */

require '../../../admin/header.php';

use Genesis as g;
use Request as R;

header("Access-Control-Allow-Origin: *");

$productCtrl = new ProductController();

(new Request('hello'));

switch (Request::get('path')) {
    case 'product._new':
        g::json_encode(ProductController::renderForm());
        break;
    case 'product._edit':
        g::json_encode(ProductController::renderForm(R::get("id")));
        break;
    case 'product._show':
        g::json_encode(ProductController::renderDetail(R::get("id")));
        break;
    case 'product._delete':
        g::json_encode($productCtrl->deleteAction(R::get("id")));
        break;
    case 'product._deletegroup':
        g::json_encode($productCtrl->deletegroupAction(R::get("ids")));
        break;
    case 'product.datatable':
        g::json_encode($productCtrl->datatable(R::get('next'), R::get('per_page')));
        break;

    default :
        echo json_encode("404 : page note found");
        break;
}