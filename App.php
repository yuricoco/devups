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

        //$tree = new Tree();
        //$tree = new \dclass\devups\Datatable\Lazyloading(new Tree_item());
        //$tree = $tree->lazyloading();
        $tree = Tree_item::findrow(1);
        /*$tree = (new Dvups_role(1))->__hasmany('dvups_entity', false)
            ->where("dvups_entity.dvups_module_id", 1)
            ->__getAll()
        ;*/
        //$tree->slug = "update !";
        //$tree->name = ["fr"=>"en FR", "en"=>"en EN"];
        //$tree->name = "just FR";
        //$tree->__update();
        //var_dump($tree );
        var_dump($tree);
        //var_dump($tree );
//        var_dump($tree->tree->created_at );

        die;
        Genesis::render("hello", []);
    }

    public function tableView(){
        $datatable = ProductTable::init(new Product())->buildindextable();
        Genesis::render("table", compact("datatable"));
    }

}