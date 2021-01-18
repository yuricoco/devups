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

    public function ll($next = 1, $per_page = 10){

        $ll = new Lazyloading();
        $ll->lazyloading(new Local_content());
        return $ll;

    }

    public function createAction($local_content_form = null){
        $rawdata = \Request::raw();
        $local_content = $this->hydrateWithJson(new Local_content(), $rawdata["local_content"]);

        $id = $local_content->__insert();
        return 	array(	'success' => true,
                        'local_content' => $local_content,
                        'detail' => '');

    }

    public function updateAction($id, $local_content_form = null){
        $rawdata = \Request::raw();
            
        $local_content = $this->hydrateWithJson(new Local_content($id), $rawdata["local_content"]);

                  
        
        $local_content->__update();
        return 	array(	'success' => true,
                        'local_content' => $local_content,
                        'detail' => '');
                        
    }
    

    public function detailAction($id)
    {

        $local_content = Local_content::find($id);

        return 	array(	'success' => true,
                        'local_content' => $local_content,
                        'detail' => '');
          
}       


}
