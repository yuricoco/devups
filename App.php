<?php

use Genesis as g;

/**
 * this class refer to the front pages. each method represent a page. where we can add js css and some other parameter
 * such as meta titel, title and so on
 *
 * Class App
 */
class App extends \dclass\devups\Controller\FrontController
{

    protected $layout = "layout.app";

    public function __construct()
    {

        self::$jsfiles[] = CLASSJS . "devups.js";
        self::$jsfiles[] = CLASSJS . "model.js";
        self::$jsfiles[] = CLASSJS . "ddatatable.js";
        self::$jsfiles[] = CLASSJS . "dform.js";
        self::$cssfiles[] = assets . "css/dv_style.css";
        self::$cssfiles[] = assets . "css/stylesheet.css";

        (new Request('hello'));
        Request::Route($this, Request::get('path'));

//        self::$jsfiles["jsimport"] = [];
//        self::$cssfiles["cssimport"] = [];

    }

    public function helloView(){
        Genesis::render("hello", []);
    }

}