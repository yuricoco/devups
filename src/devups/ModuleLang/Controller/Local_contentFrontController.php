<?php 

use \dclass\devups\Datatable\Lazyloading;

class Local_contentFrontController extends Local_contentController{

    public static function renderSetting()
    {
        self::$cssfiles[] = Local_content::classpath()."Ressource/css/bootstrap.css";
        global $viewdir;
        $viewdir[] = Local_content::classroot("Ressource/views");
        Genesis::renderView("front.setting", []);
    }

    public static function localcontentHandler()
    {
        if (!isset($_SESSION["debuglang"]) || $_SESSION["debuglang"] == 0)
            $_SESSION["debuglang"] = 1;
        else
            $_SESSION["debuglang"] = 0;

        redirect(__env);
    }
    public static function changeLang()
    {
        $lang = Request::get("lang");
        if ($lang === 'fr' || $lang == "en")
            $_SESSION[LANG] = Request::get("lang");
        else
            $_SESSION[LANG] = "en";

        redirect( __env);
    }


}
