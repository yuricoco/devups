<?php
//

require 'header.php';

$storage = new Storage();
$test = [];
$text2 = [];
$storages = Storage::all();
var_dump($storage->entityKey($test, $text2));
die;

$productCtrl =  new ProductController();

(new Request('hello'));


switch (Request::get('path')) {

    case 'hello':
        echo base64_encode('acmercurepmprod:bdtuNpNjioEyD9qyrwRJvAMMxszS4OB5vfknV96EEmTq6vgJkA');
        Genesis::render("hello", ["lazyloading"=> $productCtrl->lazyloading(new Product(), 1, 10) ]);
        break;

    case 'home':
        Genesis::render("layout", ["lazyloading"=> $productCtrl->lazyloading(new Product(), 1, 10) ]);
        break;

    default:
        Genesis::render('404', ['page' => Request::get('path')]);
        break;
}
    
    