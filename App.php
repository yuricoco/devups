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
    public static $user;

    public function __construct()
    {

        // self::$user = User::find(userapp()->getId());

        self::$jsfiles[] = CLASSJS . "devups.js";
        self::$jsfiles[] = CLASSJS . "model.js";
        self::$jsfiles[] = CLASSJS . "ddatatable.js";
        self::$jsfiles[] = CLASSJS . "dform.js";
        self::$cssfiles[] = assets . "css/dv_style.css";
        self::$cssfiles[] = assets . "css/stylesheet.css";

        (new Request('hello'));
        Request::Route($this, Request::get('path'));


    }

    public static function isGuest(){
        return is_null(self::$user->getId());
    }

    public static function needsession($message = "")
    {
        if (!self::$user->getId()) {
            redirect(route("login?message=" . $message));
            die;
        }

        return true;

    }

    public static function noneedsession()
    {
        if (self::$user->getId()) {
            redirect(route("home"));
            die;
        }

    }

    public function helloView(){
//        $Storage = Storage::firstOrCreate(
//            ['name' => 'Tokyo'],
//            ['open' => 1, 'open_at' => '11:30']
//        );
        $storage = Storage::delete();
        // $storage->__delete();
        dv_dump($storage);
// Retrieve Storage by name or create it with the name, delayed, and arrival_time attributes...
        $Storage = Storage::firstOrCreate(
            ['name' => 'London to Paris'],
            ['open' => 1, 'open_at' => '11:30']
        );
        dump($Storage);
// Retrieve Storage by name or instantiate a new Storage instance...
        $Storage = Storage::firstOrNew([
            'name' => 'London to Paris'
        ]);
        dump($Storage);

// Retrieve Storage by name or instantiate with the name, delayed, and arrival_time attributes...
        $Storage = Storage::firstOrNew(
            ['name' => 'Tokyo to Sydney'],
            ['open' => 1, 'open_at' => '11:30']
        );
        dump($Storage);

        //Genesis::render("hello", []);
    }

    public function tableView(){
        $datatable = ProductTable::init(new Product())->buildindextable();
        Genesis::render("table", compact("datatable"));
    }

}