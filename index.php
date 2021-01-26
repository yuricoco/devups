<?php
//

require 'header.php';
require 'App.php';

$app = new App();
die;

switch (Request::get('path')) {

    case 'hello':
        $datatable = Dv_imageTable::init(new Dv_image())
            ->buildfrontcustom()
            ->setModel("frontcustom");
        Genesis::render("hello", compact("datatable"));
        break;

    case 'changelang':
        Local_contentFrontController::changeLang();
        break;
    case 'translatedebug':
        Local_contentFrontController::localcontentHandler();
        break;

    case 'documentation':
        CmstextFrontController::documentView();
        break;
    default:
        Genesis::render('404', ['page' => Request::get('path')]);
        break;
}
    
    