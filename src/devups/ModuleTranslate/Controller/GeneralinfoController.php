<?php

use dclass\devups\Controller\Controller;

/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 13/03/2019
 * Time: 5:38 PM
 */
class GeneralinfoController extends Controller
{

    private static $path = ROOT . "config/generalinfo.json";
    const pathmodule = ROOT . "web/app3/frontend1/src/devupsjs/";

    public static function parsedatalangphparraytojson()
    {
        global $lang;

        $contenu = json_encode($lang, 1024);

        $entityrooting = fopen(self::$path, 'w');
        fputs($entityrooting, $contenu);
        fclose($entityrooting);

        return ["success" => true];

    }

    public static function newdatafromentitycorecollection()
    {

        if (!isset($_SESSION[dv_lang_collection]) || !count($_SESSION[dv_lang_collection]))
            return ["success" => false, "message" => "no data to collect"];

        $content = file_get_contents(self::$path);
        $info = json_decode($content, true);
    }

    public static function newdatafromsessioncollection()
    {

        if (!isset($_SESSION[dv_lang_collection]) || !count($_SESSION[dv_lang_collection]))
            return ["success" => false, "message" => "no data to collect"];

        $content = file_get_contents(self::$path);
        $info = json_decode($content, true);

        foreach ($_SESSION[dv_lang_collection] as $ref => $default) {
            $info[$ref] = ["en" => $default, "fr" => $default];
        }


        if ($info) {
            $contenu = json_encode($info, 1024);

            $entityrooting = fopen(self::$path, 'w');
            fputs($entityrooting, $contenu);
            fclose($entityrooting);

            // $_SESSION[LANG."_collection"] = [];

            return ["success" => true, "data" => $info];
        }

        return ["success" => false, "data" => $info];

    }

    public static function getdata()
    {

        $content = file_get_contents(self::$path);
        $info = json_decode($content, true);

        return [
            "admin" => getadmin(),
            "info" => $info
        ];
    }

    public static function getdataView()
    {

        self::$jsfiles[] = Generalinfo::classpath('Ressource/js/generalinfoCtrl.js');
        return self::getdata();

    }

    public static function savedata()
    {
//        foreach ($_POST as $key => $value){
//            $content[$key] = $value;
//        }
        $contenu = $_POST["content"];
        $entityrooting = fopen(self::$path, 'w');
        fputs($entityrooting, $contenu);
        fclose($entityrooting);

        return ["success" => true];
    }

    public static function savenodemoduledata()
    {
        $content = file_get_contents(self::$path);
        $lang = json_decode($content, true);

        $collection = [];

        $keyfamilly = [];
        $contentcollection = [];
        foreach ($lang as $ref => $translate) {
            $familly = explode('.', $ref);

            if (!in_array($familly[0], $keyfamilly)) {
                $keyfamilly[] = $familly[0];
                $collection["en"][$familly[0]] = [];
                $collection["fr"][$familly[0]] = [];
            }
//            $keyfamilly[] = explode('.', $ref);
            //if (preg_match_all("/$familly[0]"."./", $ref)){
            if (!isset($familly[1])) { //&& !isset($collection["en"][$familly[0]])
                $collection["en"][$familly[0]] = $translate["en"];
                $collection["fr"][$familly[0]] = $translate["fr"];
            } else {
                $collection["en"][$familly[0]][$familly[1]] = $translate["en"];
                $collection["fr"][$familly[0]][$familly[1]] = $translate["fr"];
            }
            //}

            unset($lang[$ref]);
            //$collection["en"][$familly[0]] = $translate["en"];
        }
        //$collection["en"] = $contentcollection;
//        $entityrooting = fopen(self::pathmodule."en.json", 'w');
//        fputs($entityrooting, json_encode($contentcollection));
//        fclose($entityrooting);

//        $contentcollection = [];
//        foreach ($lang as $ref => $translate){
//            $contentcollection[str_replace(".", "_", $ref)] = $translate["fr"];
//        }

        $entityrooting = fopen(self::pathmodule . "lang.js", 'w');
        //fputs($entityrooting, json_encode($collection));
        fputs($entityrooting, "export default " . json_encode($collection));
        fclose($entityrooting);

        return ["success" => true];
    }

    public function listView($next = 1, $per_page = 10)
    {
        // TODO: Implement listView() method.
    }
}