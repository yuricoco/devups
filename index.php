<?php
//

require 'header.php';

(new Request('hello'));


switch (Request::get('path')) {

    case 'hello':
        Genesis::render("hello", []);
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
    
    