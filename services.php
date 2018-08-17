<?php

require '/header.php';

use Genesis as g;

header("Access-Control-Allow-Origin: *");

//instanciation des controllers
$storageCtrl = new StorageController();
$categoryCtrl = new CategoryController();
$subcategoryCtrl = new SubcategoryController();
$productCtrl = new ProductController();
$imageCtrl = new ImageController();

(new Request('hello'));

switch (Request::get('path')) {
    case 'hello':
        g::json_encode(["success" => true, "message" => "Hello Devups. Services are available :)"]);
        break;

// ...

    default :
        echo json_encode("404 : page note found");
        break;
}
                        
	