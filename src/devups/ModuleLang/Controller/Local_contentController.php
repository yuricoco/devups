<?php


use dclass\devups\Controller\Controller;

class Local_contentController extends Controller
{

    private static $path = ROOT . "cache/local/";
    const pathmodule = ROOT . "web/app3/frontend1/src/devupsjs/";

    public function listView($next = 1, $per_page = 10){

        $this->datatable = Local_contentTable::init(new Local_content())->buildindextable();

        self::$jsfiles[] = Local_content::classpath('Resource/js/local_contentCtrl.js');

        $this->entitytarget = 'Local_content';
        $this->title = "Manage Local_content";

        $this->renderListView();

    }

    public function datatable($next, $per_page) {
        return ['success' => true,
            'datatable' => Local_contentTable::init(new Local_content())->buildindextable()->getTableRest(),
           // 'datatable' => Local_contentTable::init(new Local_content())->router()->getTableRest(),
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

    public function regeneratecacheAction(){
        self::buildlocalcache();

        Response::success()
            ->message(t("local cache regenerated with success"))
            ->json();

    }

    public static function buildlocalcache()
    {

        $lans = Dvups_lang::all();
        foreach ($lans as $lang) {
            $lang = $lang->getIso_code();

            $lcs = Local_content::where("lang", $lang)->__getAllRow();

            $info = [];

            foreach ($lcs as $lc) {
                $info[$lc->getReference()] = $lc->getContent();
            }

            if ($info) {
                // todo - fix issue on php warning during the first call of the function translate t().
                if(file_exists(self::$path . $lang . ".json"))
                    unlink(self::$path . $lang . ".json");

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

        $lans = Dvups_lang::all();
        foreach ($lans as $lang) {
            $lang = $lang->getIso_code();

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
            \DClass\lib\Util::writein(self::$path . $lang . ".json", "");
            self::buildlocalcache();
        }

        $content = file_get_contents(self::$path . $lang . ".json");
        return json_decode($content, true);

    }

    public static function getdatajs()
    {

        $lang = DClass\lib\Util::local();

        if (!file_exists(self::$path . $lang . ".json")) {
            self::buildlocalcache();
        }

        return file_get_contents(self::$path . $lang . ".json");

    }

}
