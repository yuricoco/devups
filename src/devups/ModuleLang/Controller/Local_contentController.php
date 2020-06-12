<?php


use dclass\devups\Controller\Controller;

class Local_contentController extends Controller
{

    private static $path = ROOT . "cache/local/";
    const pathmodule = ROOT . "web/app3/frontend1/src/devupsjs/";

    public function listView($next = 1, $per_page = 25)
    {

        $lazyloading = $this->lazyloading(new Local_content(), $next, $per_page);

        self::$jsfiles[] = Local_content::classpath('Ressource/js/local_contentCtrl.js');

        $this->entitytarget = 'Local_content';
        $this->title = "Manage Local_content";

        $this->renderListView(Local_contentTable::init($lazyloading)->buildindextable()->render());

    }

    public function datatable($next, $per_page)
    {
        $lazyloading = $this->lazyloading(new Local_content(), $next, $per_page);
        return ['success' => true,
            'datatable' => Local_contentTable::init($lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($local_content_form = null)
    {
        extract($_POST);

        $local_content = $this->form_fillingentity(new Local_content(), $local_content_form);


        if ($this->error) {
            return array('success' => false,
                'local_content' => $local_content,
                'action' => 'create',
                'error' => $this->error);
        }

        $id = $local_content->__insert();
        return array('success' => true,
            'local_content' => $local_content,
            'tablerow' => Local_contentTable::init()->buildindextable()->getSingleRowRest($local_content),
            'detail' => '');

    }

    public function updateAction($id, $local_content_form = null)
    {
        extract($_POST);

        $local_content = $this->form_fillingentity(new Local_content($id), $local_content_form);


        if ($this->error) {
            return array('success' => false,
                'local_content' => $local_content,
                'action_form' => 'update&id=' . $id,
                'error' => $this->error);
        }

        $local_content->__update();
        return array('success' => true,
            'local_content' => $local_content,
            'tablerow' => Local_contentTable::init()->buildindextable()->getSingleRowRest($local_content),
            'detail' => '');

    }


    public function detailView($id)
    {

        $this->entitytarget = 'Local_content';
        $this->title = "Detail Local_content";

        $local_content = Local_content::find($id);

        $this->renderDetailView(
            Local_contentTable::init()
                ->builddetailtable()
                ->renderentitydata($local_content)
        );

    }

    public function deleteAction($id)
    {

        Local_content::delete($id);
        return array('success' => true,
            'detail' => '');
    }


    public function deletegroupAction($ids)
    {

        Local_content::delete()->where("id")->in($ids)->exec();

        return array('success' => true,
            'detail' => '');

    }

    public static function buildlocalcachesinglelang($lang)
    {

        $lcs = Local_content::where("lang", $lang)->__getAllRow();

        $info = [];

        foreach ($lcs as $lc) {
            $info[$lc->getReference()] = $lc->getContent();
        }

        if ($info) {
            $contenu = json_encode($info, 1024);

            $entityrooting = fopen(self::$path . $lang . ".json", 'w');
            fputs($entityrooting, $contenu);
            fclose($entityrooting);

        }

    }
    public static function buildlocalcache()
    {

        foreach (["en", "fr"] as $lang) {

            $lcs = Local_content::where("lang", $lang)->__getAllRow();

            $info = [];

            foreach ($lcs as $lc) {
                $info[$lc->getReference()] = $lc->getContent();
            }

            if ($info) {
                $contenu = json_encode($info, 1024);

                $entityrooting = fopen(self::$path . $lang . ".json", 'w');
                fputs($entityrooting, $contenu);
                fclose($entityrooting);

            }

        }
    }

    public static function newdatacollection($ref, $default)
    {

        $lck = new Local_content_key();
        $lck->setReference($ref);
        $lck->__insert();

        foreach (["en", "fr"] as $lang) {

            $lc = new Local_content();
            $lc->setLang($lang);
            $lc->setReference($ref);
            $lc->setContent($default);
            $lc->local_content_key = $lck;
            $lc->__insert();

        }

        self::buildlocalcache();

        return ["success" => true];

    }

    public static function getdata()
    {

        $lang = DClass\lib\Util::local();

        if (!file_exists(self::$path . $lang . ".json")) {
            self::buildlocalcache();
        }

        $content = file_get_contents(self::$path . $lang . ".json");
        return json_decode($content, true);

    }

}