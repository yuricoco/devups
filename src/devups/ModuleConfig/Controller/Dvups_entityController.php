<?php


use dclass\devups\Controller\Controller;
use dclass\devups\Datatable\Datatable;
use Illuminate\Support\Facades\DB;
use Shuchkin\SimpleXLSX;

class Dvups_entityController extends Controller
{

    /**
     * retourne l'instance de l'entité ou un json pour les requete asynchrone (ajax)
     *
     * @param type $id
     * @return \Array
     */
    public static function updatelabel($id, $label)
    {


        $dvups_entity = new Dvups_entity($id);
        $dvups_entity->__update("dvups_entity.label", $label)->exec();

        return array('success' => true,
            'dvups_entity' => $dvups_entity,
            'detail' => 'detail de l\'action.');
    }

    public static function renderDetail($id)
    {
        Dvups_entityForm::__renderDetailWidget(Dvups_entity::find($id));
    }

    public function formView($id = null)
    {
        $dvups_entity = new Dvups_entity();
        $action = Dvups_entity::classpath("services.php?path=dvups_entity.create");
        if ($id) {
            $action = Dvups_entity::classpath("services.php?path=dvups_entity.update&id=" . $id);
            $dvups_entity = Dvups_entity::find($id);
        }

        return ['success' => true,
            'form' => Dvups_entityForm::init($dvups_entity, $action)
                ->buildForm()
                ->addDformjs()
                ->renderForm(),
        ];

    }

    public function formExportView()
    {
        return ['success' => true,
            'form' => Dvups_entityForm::renderExportWidget(),
        ];
    }
    public function formImportView()
    {
        return ['success' => true,
            'form' => Genesis::getView("admin.dvups_entity.formImportWidget", Request::$uri_get_param),
        ];
    }

    public function datatable($next, $per_page)
    {
        return ['success' => true,
            'datatable' => Dvups_entityTable::init(new Dvups_entity())->buildindextable()->getTableRest(),
        ];
    }

    public function listView($next = 1, $per_page = 10)
    {

        self::$jsfiles[] = Dvups_entity::classpath('Ressource/js/dvups_entityCtrl.js');

        $this->entitytarget = 'dvups_entity';
        $this->title = "Manage Entity";

        $this->datatable = Dvups_entityTable::init()->buildindextable();

        $this->renderListView();

    }

    public function createAction()
    {
        extract($_POST);
        $this->err = array();

        $dvups_entity = $this->form_generat(new Dvups_entity(), $dvups_entity_form);


        if ($id = $dvups_entity->__insert()) {
            return array('success' => true, // pour le restservice
                'dvups_entity' => $dvups_entity,
                'tablerow' => Dvups_entityTable::init()
                    ->buildindextable()
                    ->getSingleRowRest($dvups_entity),
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'dvups_entity' => $dvups_entity,
                'action_form' => 'create', // pour le web service
                'detail' => 'error data not persisted'); //Detail de l'action ou message d'erreur ou de succes
        }

    }

    public function updateAction($id)
    {
        extract($_POST);

        $dvups_entity = $this->form_generat(new Dvups_entity($id), $dvups_entity_form);

        if ($dvups_entity->__update()) {
            return array('success' => true, // pour le restservice
                'dvups_entity' => $dvups_entity,
                'tablerow' => Dvups_entityTable::init()
                    ->buildindextable()
                    ->getSingleRowRest($dvups_entity),
                'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
        } else {
            return array('success' => false, // pour le restservice
                'dvups_entity' => $dvups_entity,
                'action_form' => 'update&id=' . $id, // pour le web service
                'detail' => 'error data not updated'); //Detail de l'action ou message d'erreur ou de succes
        }
    }


    public function deleteAction($id)
    {

//        Dvups_right_dvups_entity::delete()->where("dvups_entity_id", $id)->exec();
//        Dvups_role_dvups_entity::delete()->where("dvups_entity_id", $id)->exec();
        Dvups_entity::delete($id);

        return array('success' => true, // pour le restservice
            //'redirect' => 'index', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes
    }


    public function deletegroupAction($ids)
    {

        Dvups_right_dvups_entity::delete()->where("dvups_entity_id")->in($ids)->exec();
        Dvups_role_dvups_entity::delete()->where("dvups_entity_id")->in($ids)->exec();
        Dvups_entity::delete()->where("id")->in($ids)->exec();

        return array('success' => true, // pour le restservice
            'redirect' => 'index', // pour le web service
            'detail' => ''); //Detail de l'action ou message d'erreur ou de succes

    }

    public function truncateAction($id)
    {
        $dvups_entity = Dvups_entity::find($id);
        $dvups_entity->truncate();

        return 	array(	'success' => true,
            'dvups_entity' => $dvups_entity,
            'tablerow' => Dvups_entityTable::init()->buildindextable()->getSingleRowRest($dvups_entity),
            'detail' => '');
    }

    public function exportCsv()
    {

        function filterData(&$str)
        {
            $str = preg_replace("/\t/", "\\t", $str);
            $str = preg_replace("/\r?\n/", "\\n", $str);
            if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        }

        $classname = ucfirst(Request::get("classname"));
        $entity = new $classname;

        if(Request::post("allcolumns")) {
            $keys = explode(',', Request::post("fields"));
            $columns = "*";
        }else {
            $keys = Request::post("columns");
            $columns = implode(',', $keys);
        }

        /*foreach ($this as $key => $val) {
            self::$dvkeys[] = 'id';
            if (in_array($key, self::$dvkeys) || is_array($val))
                continue;
            if (is_object($val)) {
                $keys[] = $key . '_id';
            } else
                $keys[] = $key;
        }*/

        $exportat = date("YmdHis");
        //$classname = get_class($this);
        $filename = $classname . "-" . $exportat . ".csv";

        $dataexport = implode("\t", $keys) . "\n";
        (new \dclass\devups\Datatable\Lazyloading())->lazyloading($entity, null, "", Request::post("idlang"), true)
            ->getRows($columns, function ($row, $classname) use (&$dataexport) {

                $dataexport .= implode("\t", array_values($row)) . "\n";

            });

        //$download = __env . "database/fixtures/" . $classname . "/" . $filename;
        //return compact('keys', "download");
        //$message = $classname . ": CSV generated with success";

        $fileName = $classname."_" . date('Y-m-d_H-i') . ".csv";
//        $excelData = file_get_contents(__DIR__ . "/../import/datalang.csv");

        header('Content-Type: text/html; charset=windows-1252');
        //header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");

// Render excel data
        echo $dataexport;

        exit;
    }

    const split = ";";

    public function importCsv($classname)
    {
        if (!isset($_FILES["fixture"]) || $_FILES["fixture"]['error'] != 0)
            return [
                "success" => false,
                "message" => "no file founded",
            ];


        $handle = file($_FILES["fixture"]["tmp_name"], FILE_IGNORE_NEW_LINES);

        if ($handle) {

            $values = [];
            $i = 0;
            //while (($line = fgets($handle)) !== false) {
            foreach ($handle as $line) {
                // process the line read.
                $references = [];
                if ($line) {
                    $line = (trim($line));
                    if ($i >= 1) {
                        // we verify if the current line is not empty. due to sometime EOF are just \n code
                        $reference = str_replace(self::split, "", $line);
                        if (!trim($reference))
                            continue;

                        // there are some file that has ;;; at the end of a line, programmatically it represent column
                        // therefore we have to remove those by user array_filter fonction
                        // we finaly combine value with column key
                        //try {
                        $valuetobind = explode(self::split, $line);
                        if (count($columns) != count($valuetobind))
                            return [
                                "content" => $line,
                                "index" => $i,
                                "columns" => $columns,
                                "nbc" => count($columns),
                                "valuetobind" => $valuetobind,
                                "nbv" => count($valuetobind),
                            ];

                        $keyvalue = array_combine($columns, explode(self::split, $line));

                        foreach ($this as $key => $val) {
                            if (in_array($key, self::$dvkeys))
                                continue;
                            if (is_object($val)) {
                                if (isset($keyvalue[$key . '_id']) && in_array(strtolower($keyvalue[$key . '_id']), ['', 'null']))
                                    $keyvalue[$key . '_id'] = null;
                            }
                        }
                        // dv_dump($keyvalue);

//                        }catch (Exception $exception){
//                            die(var_dump($exception));
//                        }

                        if (!$keyvalue) {
                            // and if event so we get a false
                            // we catch error to optimize the exception
                            $allerrors[] = [
                                "content" => $line,
                                "index" => $i,
                                "combinaison_column" => $columns,
                                "keyvalue" => $keyvalue,
                            ];
                            return $allerrors;
                        } else
                            DBAL::_createDbal(strtolower($classname), $keyvalue);

                    } else {
                        // we collect all headers and with the array_filter fonction we sanitize the array to avoid double value
                        $columns = array_filter(explode(self::split,
                            str_replace("\"", "", ($line))
                        ));
                    }
                    $i++;
                }
            }

        }

        return ["success" => true, "message" => "all went well"];

    }


    public static function importXlsx()
    {
        require ROOT . "/dclass/lib/SimpleXLSX.php";
        $file = null;
        if (!file_exists(UPLOAD_DIR . "/importlang"))
            mkdir(UPLOAD_DIR . "/importlang", 0777, true);

        if (isset($_FILES['filelang'])) {
            if (move_uploaded_file($_FILES['filelang']['tmp_name'], UPLOAD_DIR . "/importdata/data.xlsx")) {

                return [
                    "success" => true,
                    "detail" => "le fichier a bien ete uploade",
                ];

            } else {
                return array("success" => false, 'detail' => 'Problème lors de l\'uploadage !');
            }
        }

        $file = UPLOAD_DIR . "/importdata/data.xlsx";
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

            $row = array_combine($head, $fields);

            $id = $row["id"];
            unset($row['id']);
            $sql = "  select COUNT(*) from " . $row["table"]
                . " where id = $id";
            $exist = (new DBAL())->executeDbal($sql);

            if ($exist) {
                DBAL::_updateDbal($row["table"] . "_lang",
                    $row,
                    " id = " . $id);
            } else
                Db::getInstance()->insert($row["table"], $row);


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
