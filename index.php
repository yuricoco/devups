<?php

require 'header.php';

use Genesis as g;

//instanciation des controllers


(new Request('hello'));

switch (Request::get('path')) {
    case 'hello':
        g::render('hello');
        break;

    //    case 'view1':
    //        g::render( 'view1', $Ctrl->Action() );
    //        break;
    //    
    //    ...
    //    
    //    case 'view2':
    //        g::render( 'view2', [$Ctrl->Action(), $Ctrl2->Action(), ... , $Ctrln->Action()] );
    //        break;


    default :
        // inclusion du layout du site 
        include 'web/404.html';
        break;
}
                        
