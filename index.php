<?php
//

require 'header.php';

$productCtrl =  new ProductController();

(new Request('hello'));

dv_dump($_SERVER);

switch (Request::get('path')) {

    case 'hello':
        Genesis::render("hello", ["lazyloading"=> $productCtrl->lazyloading(new Product(), 1, 10) ]);
        break;

    case 'home':
        Genesis::render("layout", ["lazyloading"=> $productCtrl->lazyloading(new Product(), 1, 10) ]);
        break;

    default:
        Genesis::render('404', ['page' => Request::get('path')]);
        break;
}
    
    