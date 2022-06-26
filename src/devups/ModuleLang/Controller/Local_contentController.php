<?php


use dclass\devups\Controller\Controller;
use Shuchkin\SimpleXLSX;

class Local_contentController extends Controller
{

    private static $path = ROOT . "cache/local/";
    const pathmodule = ROOT . "web/app3/frontend1/src/devupsjs/";

    public function listView($next = 1, $per_page = 10)
    {

        $this->datatable = Local_contentTable::init(new Local_content())->buildindextable();

        self::$jsfiles[] = Local_content::classpath('Resource/js/local_contentCtrl.js');

        $this->entitytarget = 'Local_content';
        $this->title = "Manage Local_content";

        $this->renderListView();

    }

    public function datatable($next, $per_page)
    {
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

        $lcs = Local_content::where("lang", $lang)->get();

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

    public function regeneratecacheAction()
    {
        self::buildlocalcache();

        Response::success()
            ->message(t("local cache regenerated with success"))
            ->json();

    }

    public static function buildlocalcache()
    {

        $lans = Dvups_lang::all();
        foreach ($lans as $lang) {
            $iso_code = $lang->getIso_code();

            $lcs = Local_content::select()->setLang($lang->id)->get();

            $info = [];

            foreach ($lcs as $lc) {
                $info[$lc->getReference()] = $lc->content;
            }

            if ($info) {
                // todo - fix issue on php warning during the first call of the function translate t().
                if (file_exists(self::$path . $iso_code . ".json"))
                    unlink(self::$path . $iso_code . ".json");

                $contenu = json_encode($info, 1024);

                $entityrooting = fopen(self::$path . $iso_code . ".json", 'w');
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
        $lc = new Local_content();
        $content = [];
        foreach ($lans as $lang) {
            //$lang = $lang->getIso_code();
            $content[$lang->getIso_code()]=$default;
        }

        //$lc->setLang($lang);
        $lc->setReference($ref);
        $lc->content = $content;
        $lc->local_content_key = $lck;
        $lc->__insert();

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

    public function exportlangView()
    {
        $langs = Dvups_lang::all();
        Genesis::renderView("admin.exportlang", compact("langs"));
    }

    public static function devups($lang_dest, $lang, &$excelData)
    {
        $id_lang_dest = $lang_dest->id;
        $id_lang = $lang->id;
        // Database configuration
        $dbHost = dbhost;
        $dbUsername = dbuser;
        $dbPassword = dbpassword;
        $dbName = dbname;

// Create database connection
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        $entities = Dvups_entity::all();

        foreach ($entities as $table) {

            if (!class_exists($table->name)) continue;

            if (in_array($table->name, ["cmstext"]))
                continue;

            $class = ucfirst($table->name);
            $entity = new $class;
            if (!$entity->dvtranslate)
                continue;

            $attfield = "";
            $attribs = $entity->dvtranslated_columns;

            $table = $table->name;
            foreach ($attribs as $attr) {
                $attfield .= ", dest.$attr AS dest_$attr ";
            }
            $sql = " select t.* $attfield from " . $table . "_lang t,
         (select * from " . $table . "_lang where 1 ) dest
          where t.lang_id = $id_lang AND dest.lang_id = $id_lang_dest AND dest." . $table . "_id = t.$table" . "_id";

            //dv_dump($sql);
            $key = $table;

            $query = $db->query($sql);
            if ($query->num_rows > 0) {
                // Output each row of the data
                while ($row = $query->fetch_assoc()) {
                    foreach ($attribs as $attrib) {
                        if (!$row[$attrib] && !$row["dest_" . $attrib])
                            continue;

                        $lineData = array($table,
                            $row[$key . '_id'], $attrib, $row[$attrib], $row["dest_" . $attrib]);
                        array_walk($lineData, 'filterData');
                        $excelData .= implode("\t", array_values($lineData)) . "\n";
                    }
                }
            } else {
                //$excelData .= 'No records found...' . "\n";
            }

        }


    }

    public function exportlang($iso_code)
    {

//        if (!file_exists(__DIR__ . "/../import"))
//            mkdir(__DIR__ . "/../import", 0777, true);

        function filterData(&$str)
        {
            $str = preg_replace("/\t/", "\\t", $str);
            $str = preg_replace("/\r?\n/", "\\n", $str);
            if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        }

        $dest = Request::get("dest");
        $lang = Dvups_lang::getbyattribut("iso_code", $iso_code);
        $lang_dest = Dvups_lang::getbyattribut("iso_code", $dest);

// Excel file name for download

// Column names
        $excelData = "";
        //unlink(__DIR__ . "/../import/datalang.csv");
        $fields = array('table', 'row', 'attribut', 'content ' . (($iso_code)),);

        $fields[] = "content " . $dest;
        $excelData = implode("\t", array_values($fields)) . "\n";

        self::devups($lang_dest, $lang, $excelData);
//            $moddepend = fopen(__DIR__ . "/../import/datalang.csv", "w");
//            fputs($moddepend, $excelData);
//            fclose($moddepend);
//            return 1;
//        echo $excelData;
//        die;
// Headers for download

        $fileName = "database-lang_" . date('Y-m-d_H-i') . ".csv";
//        $excelData = file_get_contents(__DIR__ . "/../import/datalang.csv");

        header('Content-Type: text/html; charset=windows-1252');
        //header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");

// Render excel data
        echo $excelData;

        exit;
    }

    public static function importlang()
    {
        require ROOT . "/dclass/lib/SimpleXLSX.php";
        $file = null;
        if (!file_exists(UPLOAD_DIR . "/importlang"))
            mkdir(UPLOAD_DIR . "/importlang", 0777, true);

        if (isset($_FILES['filelang'])) {
            if (move_uploaded_file($_FILES['filelang']['tmp_name'], UPLOAD_DIR . "/importlang/translation.xlsx")) {

                return [
                    "success" => true,
                    "detail" => "le fichier a bien ete uploade",
                ];

            } else {
                return array("success" => false, 'detail' => 'Problème lors de l\'uploadage !');
            }
        }

        $file = UPLOAD_DIR . "/importlang/translation.xlsx";
        if (!file_exists($file))
            return [
                "success" => false,
                "detail" => "le fichier est introuvable",
            ];

        //$langs = explode(",", $_GET['langs']);
        $lang = Request::get('lang');
        $iteration = Request::get("iteration");
        $next = Request::get("next");
        $iterator = 0;
        // $xlsx = new SimpleXLSX(__DIR__ . '/../import/database-lang_2022-02-23.xlsx');
        $xlsx = new SimpleXLSX($file);

        foreach ($xlsx->rows() as $i => $fields) {

            if ($i == 0) {
                $head = $fields;
                continue;
            }

            if ($i < $next)
                continue;
            $iterator++;
            if ($i > $next + $iteration)
                break;

            $iso = explode(" ", $head[4])[1];
            $idlangs = [];
            // foreach ($langs as $iso) {
            if ($lang != $iso) {
                return [
                    "success" => false,
                    "created" => $lang,
                    "updated" => $iso,
                    "i" => $i,
                    "remain" => -1,
                    "detail" => "la langue choisi n'est pas la bonne ",
                ];
                //if (!isset($row['content ' . $iso]))
                continue;
            }

            $row = array_combine($head, $fields);
            if (!$row['content ' . $iso])
                continue;

            if (!isset($idlangs[$iso]))
                $idlangs[$iso] = Dvups_lang::getbyattribut("iso_code", $iso)->id;


            $sql = "  select COUNT(*) from " . $row["table"]
                . "_lang where {$row["table"]}_id = {$row["row"]} AND lang_id =  " . $idlangs[$iso];
            $exist = (new DBAL())->executeDbal($sql);

            if ($exist) {
                DBAL::_updateDbal($row["table"] . "_lang",
                    [
                        $row["attribut"] => $row['content ' . $iso],
                    ],
                    "{$row["table"]}_id = {$row["row"]} AND lang_id =  " . $idlangs[$iso]);
            } /*else
                    Db::getInstance()->insert($row["table"],
                        [
                            "id_lang" => $idlangs[$iso],
                            "id_" . $row["table"] => $row["row"],
                            "" . $row["attribut"] => $row['content ' . $iso],
                        ]);*/


            //}

        }

        if ($iterator - $iteration < 0) {
            self::buildlocalcache();
        }

        return [
            "success" => true,
            "created" => true,
            "updated" => true,
            "i" => $i,
            "remain" => $iterator - $iteration,
            "detail" => "le fichier est ok",
        ];
    }

}
