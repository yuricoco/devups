<?php
/**
 * Created by PhpStorm.
 * User: Aurelien Atemkeng
 * Date: 13/03/2019
 * Time: 5:38 PM
 */

class GeneralinfoController
{

    private static $path = ROOT."config/generalinfo.json";

    public static function parsedatalangphparraytojson()
    {
        global $lang;

        $contenu = json_encode($lang, 512);

        $entityrooting = fopen(self::$path, 'w');
        fputs($entityrooting, $contenu);
        fclose($entityrooting);

        return ["success" => true];

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
}