<?php

namespace dclass\devups\Datatable;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use dclass\devups\Datatable\TableRow;
use DClass\lib\Util;
use Request;

/**
 * Description of Datatable
 *
 * @author Aurelien Atemkeng
 */
class Datatable extends Lazyloading
{
    protected $btnedit_class = "btn btn-warning btn-sm";
    protected $btnview_class = "btn btn-info btn-sm";
    protected $btndelete_class = "btn btn-danger btn-sm";
    protected $btnsearch_class = "btn btn-primary";
    protected $table_class = "table table-bordered table-striped table-hover dataTable no-footer";
    //table table-bordered table-hover table-striped
    protected $actionDropdown = true;
    private $filterParam = [];
    protected $base_url = "";
    protected $dynamicpagination = false;
    protected $isFrontEnd = false;

    protected $entity = null;
    protected $class;

    protected $html = "";
    protected $lazyloading = "";
    protected $tablefilter = "";
    public $pagination = 0;
    protected $paginationcustom = [];
    protected $editAction = null;
    protected $datatablemodel = []; // describe the model of the table (available column and metadata of row)
    protected $header = []; // describe the model of the table (available column and metadata of row)
    protected $tablebody = "";

    protected $defaultaction = [
        "edit" => [
            //'type' => 'btn',
            'content' => '<i class="fa fa-edit" ></i> edit',
            'class' => 'edit',
            'action' => '',
            'habit' => 'stateless',
            'modal' => 'data-toggle="modal" ',
        ],
        "show" => [
            //'type' => 'btn',
            'content' => '<i class="fa fa-eye" ></i> show',
            'class' => 'show',
            'action' => '',
            'habit' => 'stateless',
            'modal' => 'data-toggle="modal" ',
        ],
        "delete" => [
            //'type' => 'btn',
            'content' => '<i class="fa fa-close" ></i> delete',
            'class' => 'delete',
            'action' => '',
            'habit' => 'stateless',
            'modal' => 'data-toggle="modal" ',
        ],
    ];
    protected $createaction = [
        //'type' => 'btn',
        'content' => '<i class="fa fa-plus" ></i> create',
        'class' => 'btn btn-success',
        'action' => 'onclick="model._new(this)"',
        'habit' => 'stateless',
        'modal' => 'data-toggle="modal" ',
    ];
    protected $topactions = [];
    const button = [
        //'type' => 'btn',
        'content' => '<i class="fa fa-plus" ></i> create',
        'class' => 'btn btn-success',
        'action' => '',
        'habit' => 'stateless',
        'modal' => 'data-toggle="modal" ',
    ];
    protected $customaction = [];
    protected $customactions = [];
    protected $rowaction = [];
    protected $mainrowaction = "edit";
    protected $mainrowactionbtn = "";
    protected $groupaction = true;
    protected $groupactioncore = [];
    protected $searchaction = true;
    protected $openform = "";
    protected $closeform = "";
    protected $defaultgroupaction = '<button id="deletegroup" class="btn btn-danger btn-block">delete</button>';

    protected $qbcustom = null;
    protected $order_by = "";

    //public $base_url = "";

    protected $pagejump = 10;
    public $per_page = 10;
    protected $per_pageEnabled = true;

    protected $additionnalrow = [];
    protected $enablepagination = true;
    protected $enabletopaction = true;
    protected $enablecolumnaction = true;
    protected $responsive = "";
    protected $isRadio = false;
    protected $defaulttopaction = true;

    public function __construct($entity = null, $datatablemodel = [])
    {

        if ($entity) {
            $this->entity = $entity;
            $this->class = strtolower(get_class($this->entity));

            $dentity = \Dvups_entity::getbyattribut("this.name", $this->class);
            $this->base_url = $dentity->dvups_module->route();

        }
        $this->createaction = [
            //'type' => 'btn',
            'content' => '<i class="fa fa-plus" ></i> create',
            'class' => 'btn btn-success',
            'action' => 'onclick="model._new(this, \''.$this->class.'\')"',
            'habit' => 'stateless',
            'modal' => 'data-toggle="modal" ',
        ];
        // $this->entity = $lazyloading["classname"];
//        $this->listentity = $lazyloading["listEntity"];
//        $this->nb_element = $lazyloading["nb_element"];
//        $this->per_page = $lazyloading["per_page"];
//        $this->pagination = $lazyloading["pagination"];
//        $this->paginationcustom = $lazyloading["paginationcustom"];
//        $this->current_page = $lazyloading["current_page"];
//        $this->next = $lazyloading["next"];
//        $this->previous = $lazyloading["previous"];
//        $this->remain = $lazyloading["remain"];

        // todo: free memory used by $lazyloading
        //unset($lazyloading);


    }

    /*public static function buildtable($lazyloading, $header)
    {

        $datatable = new Datatable($lazyloading, $header);
        return $datatable;

    }*/

    public function Qb(\QueryBuilder $qb)
    {
        $this->qbcustom = $qb;
        return $this;
    }

    public function top_action()
    {

        $top_action = '';
        foreach ($this->topactions as $topaction) {

            if (method_exists($this->class, $topaction . "Action") && $result = call_user_func(array($this->class, $topaction . "Action"))) {
                if (is_array($result))
                    $top_action .= implode('', $result);
                else
                    $top_action .= $result;
            } else
                $top_action .= $topaction;

        }

        if (getadmin()->getId()) {
            if (!$this->defaulttopaction)
                return $top_action;

            $entityrigths = \Dvups_entity::getRigthOf($this->class);

            if ($entityrigths) {
                // first we check if create action is available for the entity
                if (in_array('create', $entityrigths)) {

                    $top_action .= '<button type="button" class="' . $this->createaction["class"] . '" ' . $this->createaction["action"] . ' >' . $this->createaction["content"] . '</button>';

                }
            } elseif (isset($_SESSION[dv_role_permission])) {
                if (in_array('create', $_SESSION[dv_role_permission])) {
                    if (is_string($this->createaction))
                        $top_action .= $this->createaction;
                    else
                        $top_action .= '<button type="button" class="' . $this->createaction["class"] . '" ' . $this->createaction["action"] . ' >' . $this->createaction["content"] . '</button>';
                } else {
                    $top_action .= "<span class='alert alert-info' ></span>";
                }
            }
        }

//        $top_action .= ' <button type="button" onclick="ddatatable._reload()"  class="btn btn-primary" >
// <i class="fa fa-retweet"></i> Reload</button>
// ';

        if (getadmin()->getId()) {
            $top_action .= '<div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fa fa-angle-down"></i> options
    </button>
    <div class="dropdown-menu text-left" aria-labelledby="btnGroupDrop1">
        <button data-entity="'.$this->class.'" type="button" class="dv_export_csv btn btn-default btn-block" >
            <i class="fa fa-arrow-down"></i> Export csv
        </button>
        <button data-entity="'.$this->class.'" type="button" class="dv_import_csv btn btn-default btn-block" >
            <i class="fa fa-arrow-up"></i> Import csv
        </button>
    </div>
  </div>';
        }

        return $top_action;

    }

    public function actionListView($entity)
    {

        if ($this->isFrontEnd) {
            $method = 'editFrontAction';
            if (method_exists($entity, $method) && $result = call_user_func(array($entity, $method), $this->defaultaction["edit"])) {
                $this->defaultaction["edit"] = $result;
            } else {
                $this->defaultaction["edit"]['action'] = 'onclick="model._edit(' . $entity->getId() . ', \''.$this->classname.'\')"';
            }
            $method = 'showFrontAction';
            if (method_exists($entity, $method) && $result = call_user_func(array($entity, $method), $this->defaultaction["show"])) {
                $this->defaultaction["show"] = $result;
            }
            $method = 'deleteFrontAction';
            if (method_exists($entity, $method) && $result = call_user_func(array($entity, $method), $this->defaultaction["delete"])) {
                $this->defaultaction["delete"] = $result;
            } else {
                $this->defaultaction["delete"]['action'] = 'onclick="model._delete(this, ' . $entity->getId() . ', \''.$this->classname.'\')"';
            }

            if (isset($this->defaultaction[$this->mainrowaction]))
                $this->mainrowactionbtn = $this->defaultaction[$this->mainrowaction];

            return 1;
        }

        if (!isset($_SESSION[dv_role_permission]))
            return false;

        //$rigths = getadmin()->availableentityright($path);
        $entityrigths = \Dvups_entity::getRigthOf($this->class);
        if ($entityrigths) {
            if (in_array('update', $entityrigths)) {
                if (in_array('update', $_SESSION[dv_role_permission])) {
                    $method = 'editAction';
                    if (method_exists($entity, $method)) {
                        $result = call_user_func(array($entity, $method), $this->defaultaction["edit"]);
                        if (!is_null($result))
                            $this->defaultaction["edit"] = $result;
                        else
                            $this->defaultaction["edit"]['action'] = 'onclick="model._edit(' . $entity->getId() . ', \''.$this->classname.'\')"';
                    } else
                        $this->defaultaction["edit"]['action'] = 'onclick="model._edit(' . $entity->getId() . ', \''.$this->classname.'\')"';

                    $this->rowaction[] = $this->defaultaction["edit"];

                }
            }

            if (in_array('read', $entityrigths)) {
                if (in_array('read', $_SESSION[dv_role_permission])) {

                    $method = 'showAction';
                    if (method_exists($entity, $method) && $result = call_user_func(array($entity, $method), $this->defaultaction["show"]))
                        $this->defaultaction["show"] = $result;
                    else
                        $this->defaultaction["show"]['action'] = 'onclick="model._show(' . $entity->getId() . ', \''.$this->classname.'\')"';

                    $this->rowaction[] = $this->defaultaction["show"];
                }
            }
            if (in_array('delete', $entityrigths)) {
                if (in_array('delete', $_SESSION[dv_role_permission])) {

                    $method = 'deleteAction';
                    if (method_exists($entity, $method) && $result = call_user_func(array($entity, $method), $this->defaultaction["delete"]))
                        $this->defaultaction["delete"] = $result;
                    else
                        $this->defaultaction["delete"]['action'] = 'onclick="model._delete(this, ' . $entity->getId() . ', \''.$this->classname.'\')"';

                    $this->rowaction[] = $this->defaultaction["delete"];
                }

            }

            if (isset($this->defaultaction[$this->mainrowaction]))
                $this->mainrowactionbtn = $this->defaultaction[$this->mainrowaction];

            return true;

        } elseif (isset($_SESSION[dv_role_permission])) {
            if (in_array('update', $_SESSION[dv_role_permission]) or
                in_array('read', $_SESSION[dv_role_permission]) or
                in_array('delete', $_SESSION[dv_role_permission])) {

                if (in_array('update', $_SESSION[dv_role_permission])) {
                    $method = 'editAction';
                    if (method_exists($entity, $method)) {
                        $result = call_user_func(array($entity, $method), $this->defaultaction["edit"]);
                        if (!is_null($result))
                            $this->defaultaction["edit"] = $result;
                        else
                            $this->defaultaction["edit"]['action'] = 'onclick="model._edit(' . $entity->getId() . ', \''.$this->classname.'\')"';
                    } else
                        $this->defaultaction["edit"]['action'] = 'onclick="model._edit(' . $entity->getId() . ', \''.$this->classname.'\')"';

                    $this->rowaction[] = $this->defaultaction["edit"];
                }

                if (in_array('read', $_SESSION[dv_role_permission])) {
                    $method = 'showAction';
                    if (method_exists($entity, $method) && $result = call_user_func(array($entity, $method), $this->defaultaction["show"]))
                        $this->defaultaction["show"] = $result;
                    else
                        $this->defaultaction["show"]['action'] = 'onclick="model._show(' . $entity->getId() . ', \''.$this->classname.'\')"';

                    $this->rowaction[] = $this->defaultaction["show"];
                }

                if (in_array('delete', $_SESSION[dv_role_permission])) {
                    $method = 'deleteAction';
                    if (method_exists($entity, $method)) {
                        $result = call_user_func(array($entity, $method), $this->defaultaction["delete"]);
                        if (!is_null($result))
                            $this->defaultaction["delete"] = $result;
                        else
                            $this->defaultaction["delete"]['action'] = 'onclick="model._delete(this, ' . $entity->getId() . ', \''.$this->classname.'\')"';
                    } else
                        $this->defaultaction["delete"]['action'] = 'onclick="model._delete(this, ' . $entity->getId() . ', \''.$this->classname.'\')"';

                    $this->rowaction[] = $this->defaultaction["delete"];
                }

                if (isset($this->defaultaction[$this->mainrowaction]))
                    $this->mainrowactionbtn = $this->defaultaction[$this->mainrowaction];

                return true;
            } else {
                return false;
            }
        }

    }

    public function renderentitydata($entity, $callback = null)//, $header
    {
//        $dt = new Datatable();
//        $dt->class = get_class($entity);

        if (!$this->datatablemodel) {
            $tb = [];
        } else
            $tb = self::getTableEntityBody($entity, $this->datatablemodel, $callback);

        if ($callback)
            return "";

        $newrows = "";
        if (!empty($this->additionnalrow)) {
            $newrows = $this->rowbuilder();
        }

        return '<table data-entity="' . $this->class . '"  class="table table-bordered table-hover table-striped" >'
            //. '<thead><tr>' . implode(" ", $theader['th']) . '</tr><tr>' . implode(" ", $theader['thf']) . '</tr></thead>'
            . '<tbody>' . implode(" ", $tb) . '</tbody>'
            . '<tfoot>' . $newrows . '</tfoot>'
            . '</table>';

    }

    private static function getTableEntityBody($entity, $header, $callback = null)
    {

        foreach ($header as $valuetd) {
            // will call the default get[Value] of the attribut
            $value = $valuetd["value"];
            // but if dev set get the will call custom get[Get]
            if (isset($valuetd["get"]))
                $value = $valuetd["get"];

            $join = explode(".", $value);
            if (isset($join[1])) {

                $collection = explode("::", $join[0]);
                $src = explode(":", $join[0]);

                if (isset($src[1]) and $src[0] = 'src') {

                    $entityjoin = call_user_func(array($entity, 'get' . ucfirst($src[1])));
                    $file = call_user_func(array($entityjoin, 'show' . ucfirst($join[1])));

                    $td = "" . $file . "";
                } elseif (isset($collection[1])) {
                    $td = [];
                    $entitycollection = call_user_func(array($entity, 'get' . ucfirst($collection[1])));
                    foreach ($entitycollection as $entity) {
                        $entityjoin = call_user_func(array($entity, 'get' . ucfirst($join[0])));
                        $td = '' . call_user_func(array($entityjoin, 'get' . ucfirst($join[1]))) . '';
                    }
                    $td = '' . call_user_func(array($entityjoin, 'get' . ucfirst($join[1]))) . '';
                } else {
                    $entityjoin = call_user_func(array($entity, 'get' . ucfirst($join[0])));
                    $td = '' . call_user_func(array($entityjoin, 'get' . ucfirst($join[1]))) . '';
                }
            } else {

                $src = explode(":", $join[0]);

                if (isset($src[1]) and $src[0] = 'src') {

                    $file = call_user_func(array($entity, 'show' . ucfirst($src[1])));
                    $td = "" . $file . "";
                } else {
                    if (is_object(call_user_func(array($entity, 'get' . ucfirst($value)))) && get_class(call_user_func(array($entity, 'get' . ucfirst($value)))) == "DateTime") {
                        $td = '' . call_user_func(array($entity, 'get' . ucfirst($value)))->format('d M Y') . '';
                    } else {
                        $td = '' . call_user_func(array($entity, 'get' . ucfirst($value))) . '';
                    }
                }
            }

            if ($callback)
                $callback($valuetd["label"], $td);
            else
                $tr[] = '<tr ><td> ' . $valuetd["label"] . ' </td><td>' . $td . '</td></tr>';

        }

        if ($callback)
            return true;

        return $tr;
    }

    public function setpagination($enable = true)
    {
        $this->paginationenabled = $enable;
        return $this;
    }

    public function disableColumnAction()
    {
        $this->columnaction = false;
        $this->enablecolumnaction = false;
        return $this;
    }

    public function renderTopaction()
    {
        $headaction = "";
        if ($this->enabletopaction)
            $headaction = $this->top_action();

        return "<div class='dv-top-action' data-entity='" . $this->class . "' data-route='" . $this->base_url . "' >" . $headaction . "</div>";
    }

    public function renderOption()
    {

        $headaction = "";
        if ($this->enabletopaction)
            $headaction = $this->top_action();

        $groupaction = "";
        if ($this->groupaction) {
            $groupaction = $this->groupactionbuilder();
        }

        $html = <<<EOF

<div class="card-header-tab card-header">
                        <div class="card-header-title">
                            <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                            $groupaction
                        </div>
                        <div class="btn-actions-pane-right">
                            <div class="nav">
                            $headaction
                            </div>
                        </div>
                    </div>
EOF;

        $html .= ' ';//.$this->openform;

        return $html;

    }

    public function render()
    {

        $this->lazyloading($this->entity, $this->qbcustom, $this->order_by);

        $this->rowaction = [];
        if ($this->searchaction) {
            $this->openform = '<form id="datatable-form" action="#" method="get" >';
            $this->closeform = '</form>';
        }

        $headaction = $this->renderOption();

        $html = <<<EOF

        $headaction
EOF;

        $html .= ' ';//.$this->openform;

        //$html .= $this->tableoption();

        $theader = $this->headerbuilder();

        if (!$this->listentity) {
            $tbody = "";
        } else
            $tbody = $this->tablebodybuilder();

        $newrows = "";
        if (!empty($this->additionnalrow)) {
            $newrows = $this->rowbuilder();
        }

        $filterParam = "";
        if (!empty($this->filterParam)) {
            foreach ($this->filterParam as $key => $value)
                $filterParam .= "&$key=$value";
            //$filterParam = "&" . implode("&", $this->filterParam);
        }

        if (!$this->base_url) {
            $dentity = \Dvups_entity::select()->where("this.name", $this->class)->__getOne();
            $this->base_url = path('src/' . strtolower($dentity->dvups_module->getProject()) . '/' . $dentity->dvups_module->getName() . '/');
        }

        // data-route="' . $route . '" data-entityurl="' . str_replace("_", "-", $this->class) . '"
        $html .= '<div class="  ' . $this->responsive . '">
        <table id="dv_table" data-perpage="' . $this->per_page . '" data-filterparam="' . $filterParam . '" data-route="' . $this->base_url . '" data-entity="' . $this->class . '"  class="dv_datatable ' . $this->table_class . '" >'
            . '<thead>' . $theader['th'] . $theader['thf'] . '</thead>'
            . '<tbody>' . $tbody . '</tbody>'
            . '<tfoot>' . $newrows . '</tfoot>'
            . '</table></div>';

        //$this->html .= self::renderListViewUI($this->lazyloading['listEntity'], $header, $action, $defaultaction, $searchaction);
        if ($this->enablepagination)
            $html .= '<div class="card-footer">' . $this->paginationbuilder() . '</div>';

        $html .= "";//</div> $this->closeform.

        return '<div id="dv_' . $this->class . '_table" class="dv_datatable_container dataTables_wrapper dt-bootstrap4" >' . $html . '</div>
' . $this->dialogBox();

    }

    public function dialogBox()
    {
        return ' <div id="' . $this->class . 'box" class="swal2-container swal2-fade swal2-shown" style="display:none; overflow-y: auto;">
                    <div role="dialog" aria-labelledby="swal2-title" aria-describedby="swal2-content" class="swal2-modal swal2-show dv_modal" tabindex="1"
                         style="">
                        <div class="main-card mb-3 card  box-container">
                            <div class="card-header">.
            
                                <button onclick="model._dismissmodal()" type="button" class="swal2-close" aria-label="Close this dialog" style="display: block;">×</button>
                            </div>
                            <div class="card-body"></div>
                        </div>
            
                    </div>
                </div>';
    }

    public function addFilterParam($param, $value = null)
    {
        if (is_object($param))
            $this->filterParam[strtolower(get_class($param)) . ".id:eq"] = $param->getId();
        elseif (is_array($param)) {
            foreach ($param as $key => $value)
                $this->filterParam[$key] = $value;
        } else
            $this->filterParam[$param] = $value;

        return $this;
    }

    public function setModel($name)
    {
        $this->filterParam["tablemodel"] = $name;

        return $this;
    }

    private function tableoption()
    {

        $html = '<div class="col-lg-12 col-md-12">';

        $html .= $this->perpagebuilder();

        $html .= "</div>";

        return $html;
    }

    /**
     * @param bool $sure
     */
    public function addgroupaction($action)
    {
        $this->groupaction = true;
        $this->groupactioncore[] = $action;

        return $this;
    }

    public function enablegroupaction($enable = true)
    {
        $this->groupaction = $enable;
        return $this;
    }

    public function addrow(TableRow $row)
    {
        $this->additionnalrow[] = $row;
        return $this;
    }

    private function rowbuilder()
    {
        $tr = [];
        foreach ($this->additionnalrow as $row) {
            $tr[] = $row->getHtml($this->groupaction);
        }

        return implode("", $tr);
    }

    public function disabledefaultgroupaction()
    {
        $this->defaultgroupaction = "";
        return $this;
    }

    private function groupactionbuilder()
    {

        $customaction = [];
        foreach ($this->groupactioncore as $action) {
            //$customaction[] = "<span id='".$action["id"]."' class=\"btn btn-info\" >".$action["label"]."</span>";
            if (is_callable($action))
                $customaction[] = $action(); //, $param)
            else
                $customaction[] = call_user_func(array($this->class, $action . "Groupaction")); //, $param)
        }

        return '

<div class="col-lg-8 col-md-12">
<div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Action groupe
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
      ' . implode("", $customaction) . '
      ' . $this->defaultgroupaction . '
    </div>
  </div>
                    </div>';

    }

    public function setjumppage($jump = 10)
    {
        $this->pagejump = $jump;
        return $this;
    }


    public function setperpage($nbjump = 10)
    {
        $this->per_page = $nbjump;
        return $this;
    }

    public function disablepagination()
    {
        $this->enablepagination = false;
        //$this->per_page = "all";
        return $this;
    }

    public function enablefilter($val = true)
    {
        $this->searchaction = $val;
        return $this;
    }

    private function perpagebuilder()
    {

        if (!$this->per_pageEnabled)
            return "";

        $html = '                    
            <div class="col-lg-3 col-md-12 ">

        <label class=" col-lg-7" >Line to show </label>';

        $html .= '<select id="dt_nbrow" class="form-control" style="width:100px; display: inline-block" onchange="ddatatable.setperpage(this.options[this.selectedIndex].value)" >';
        //$html .= '<option value="&next=' . $current_page . '&per_page=10" >10</option>';

        for ($i = 1; $i <= $this->per_page; $i++) {
            $html .= '<option value="' . $i * $this->per_page . '" >' . $i * $this->per_page . '</option>';
        }
        $html .= '<option value="all" >All</option>';
        $html .= " </select>
    </div>";

        return $html;
    }

    public function paginationbuilder()
    {

        if (!$this->listentity) {
            return '<div id="dv_pagination" class="alert alert-info" > no item founded</div>';
        }

//        if (!is_numeric($this->paginationnav))
//            return "<div id=\"dv_pagination\" class=\"col-lg-12\"></div>";

        $html = '
<div id="dv_pagination"  data-entity="' . $this->class . '" data-route="' . $this->base_url . '" style="width: 100%" class="row">
            <div id="pagination-notice" data-notice="' . $this->pagination . '" class="col-lg-2 col-md-4">
            Showing ' . (($this->current_page - 1) * $this->per_page + 1) . ' to ' . $this->per_page * $this->current_page . ' of ' . $this->nb_element . '
            </div>
            
            ';


        $html .= '<div class="col-lg-6 col-md-8">
                <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                    <ul class="pagination">';
        if ($this->previous > 0) {
            $html .= '<li class="paginate_button page-item previous"><a class="page-link" href="javascript:ddatatable.firstpage(this)" ><i class="fa fa-angle-double-left" ></i></a></li>';
            $html .= '<li class="paginate_button page-item previous"><a class="page-link" href="javascript:ddatatable.previous(this)" ><i class="fa fa-angle-left" ></i></a></li>';
        }//' . $url . '&next=' . $previous . '&per_page=' . $per_page . '
        else {
            $html .= '<li class="paginate_button page-item previous disabled"><a class="page-link" href="#" ><i class="fa fa-angle-double-left" ></i></a></li>';
            $html .= '<li class="paginate_button page-item previous disabled"><a class="page-link" href="#" ><i class="fa fa-angle-left" ></i></a></li>';

        }

        if ($this->pagination > 10 && !$this->dynamicpagination) {
            $options = "";
            for ($page = 1; $page <= $this->pagination; $page++) {
                if ($page == $this->current_page) {
                    $options .= '<option selected value="' . $page . '" >' . $page . '</option>';
                } else {
                    $options .= '<option value="' . $page . '" >' . $page . '</option>';
                }
            }
            $html .= '<select class=" paginate_button page-item" onchange="ddatatable.pagination(this, this.value)">' . $options . '</select>';
        } else
            if ($this->dynamicpagination) {

                //dv_dump($this->paginationcustom);
                foreach ($this->paginationcustom['firsts'] as $key => $page) {
                    if ($page == $this->current_page) {
                        $html .= '<li class="paginate_button page-item  active "><a class="page-link" href="javascript:ddatatable.pagination(this, ' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                    } else {
                        $html .= '<li class="paginate_button page-item "><a class="page-link" href="javascript:ddatatable.pagination(this, ' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                    }
                }

                if ($this->current_page < 3 || $this->current_page >= 7)
                    $html .= '<li class="paginate_button page-item "><a class="page-link" href="javascript:ddatatable.pagination(this, ' . $this->paginationcustom['middleleft'] . ');" data-next="' . $this->paginationcustom['middleleft'] . '" >...</a></li>';

                foreach ($this->paginationcustom['middles'] as $key => $page) {
                    //for ($page = 1; $page <= count($this->paginationcustom['middles']); $page++) {
                    if ($page == $this->current_page) {
                        $html .= '<li class="paginate_button page-item active "><a class="page-link" href="javascript:ddatatable.pagination(this, ' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                    } else {
                        $html .= '<li class="paginate_button page-item "><a class="page-link" href="javascript:ddatatable.pagination(this, ' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                    }
                }

                if ($this->paginationcustom['lasts']) {

                    $html .= '<li class="paginate_button page-item "><a class="page-link" href="javascript:ddatatable.pagination(this, ' . $this->paginationcustom['middleright'] . ');" data-next="' . $this->paginationcustom['middleright'] . '" >...</a></li>';

                    foreach ($this->paginationcustom['lasts'] as $key => $page) {
                        //for ($page = 1; $page <= count($this->paginationcustom['lasts']); $page++) {
                        if ($page == $this->current_page) {
                            $html .= '<li class="paginate_button page-item active "><a class="page-link" href="javascript:ddatatable.pagination(this, ' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                        } else {
                            $html .= '<li class="paginate_button page-item "><a class="page-link" href="javascript:ddatatable.pagination(this, ' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                        }
                    }

                }

            } else
                for ($page = 1; $page <= $this->pagination; $page++) {
                    if ($page == $this->current_page) {
                        $html .= '<li class="paginate_button page-item active "><a class="page-link" href="javascript:ddatatable.pagination(this, ' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                    } else {
                        $html .= '<li class="paginate_button page-item "><a class="page-link" href="javascript:ddatatable.pagination(this, ' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                    }
                }

        if ($this->remain) {
            $html .= '<li class="paginate_button page-item next"><a class="page-link" href="javascript:ddatatable.next();" ><i class="fa fa-angle-right" ></i></a></li>';
            $html .= '<li class="paginate_button page-item next"><a class="page-link" href="javascript:ddatatable.lastpage(this, ' . $this->pagination . ');" ><i class="fa fa-angle-double-right" ></i></a></li>';
        } else {
            $html .= '<li class="paginate_button page-item next disabled"><a class="page-link" href="#" ><i class="fa fa-angle-right" ></i></a></li>';
            $html .= '<li class="paginate_button page-item next disabled"><a class="page-link" href="#" ><i class="fa fa-angle-double-right" ></i></a></li>';
        }

        $html .= " </ul>
                </div>
            </div>";

        $perpage = $this->perpagebuilder();

        $html .= " 
 $perpage
            </div> 
           ";

        return $html;
    }

    public function getSingleRowRest($entity)
    {
        $this->entity = $entity;
        $this->class = get_class($entity);
        $this->listentity = [$entity];
        if ($this->template) {
            $this->classname = strtolower(get_class($entity));
            return $this->buildCustomView($entity);
        }

        return [
            'row' => $this->tablebodybuilder(),
            'tablepagination' => $this->paginationbuilder()
        ];
        //return $this->tablebodybuilder();

    }

    public function getTableRest($datatablemodel = [])
    {

        $this->lazyloading($this->entity, $this->qbcustom, $this->order_by);

        if (!$this->listentity) {

            return [
                'tablebody' => '<div id="dv_table" data-entity="' . $this->class . '" class="text-center">la liste est vide</div>',
                'tablepagination' => '<div id="dv_pagination" class="col-lg-12"> no page</div>'
            ];

        }

        if ($datatablemodel)
            $this->datatablemodel = $datatablemodel;

        if ($this->template) {
            $column = null;
            $view = "";
            $this->classname = strtolower(get_class($this->entity));
            foreach ($this->listentity as $i => $entity) {
                $view .= $this->buildCustomView($entity);
                if (!$column) {
                    continue;
                }
                /*$cvlot[] = $view;
                if (count($cvlot) == $column) {
                    //$collection[] = "<div class='row'>". $cvlot ."</div>";
                    echo "<div class='row'>" . implode("", $cvlot) . "</div>";
                    $cvlot = [];
                }*/

            }
            return [
                'tablebody' => $view,
                'tablepagination' => $this->paginationbuilder()
            ];
            //return $this->buildCustomView($entity);
        }

        return [
            'tablebody' => $this->tablebodybuilder(),
            'tablepagination' => $this->paginationbuilder()
        ];

    }

    private function headerbuilder()
    {
        $thf = [];
        $th = [];
        $fields = [];
        if ($this->groupaction) {
            if (!$this->isRadio)
                $th[] = '<th><input id="checkall" name="all" type="checkbox" class="" ></th>';
            else
                $th[] = '<th></th>';

            $thf[] = '<th></th>';
        }

        foreach ($this->datatablemodel as $key => $valuetd) {
            $thforder = "";

            $value = $valuetd["value"];
            if (is_callable($value)) {

                $thf[] = '<th > </th>';

                $th[] = '<th>' . $valuetd['header'] . $thforder . '</th>';
                continue;
            }
            if (!isset($valuetd["order"]))
                $valuetd["order"] = false;

            $thfvalue = '';
            $join = explode(".", $value);
            if (isset($join[1])) {
                //$thisfield = str_replace(".", "-", $value) . ":opt";
                $thisfield = $value . ":opt";
                if (!$this->searchaction) {
                } elseif (!isset($valuetd["search"])) {
                    $thfvalue = '<input name="' . $thisfield . '" value="" placeholder="' . $valuetd['header'] . '" class="form-control" >';
                } elseif (is_string($valuetd["search"])) {
                    $thfvalue = call_user_func(array($this->class, $valuetd["search"] . 'Search'), $thisfield);
                } elseif ($valuetd["search"]) {
                    $thfvalue = '<input name="' . $thisfield . '" value="" placeholder="' . $valuetd['header'] . '" class="form-control" >';
                }
//                else {
//                }

                if ($valuetd["order"]) {
                    $thforder = 'orderjoin=' . $value ;
                    //$thforder = '<div class="torder"><i onclick="ddatatable.orderasc(\'orderjoin=' . $value . '\')" class="fa fa-angle-up"></i> <i onclick="ddatatable.orderdesc(\'orderjoin=' . $value . '\')" class="fa fa-angle-down"></i></div>';
                }
                //$fields[] = str_replace(".", "-", $value) . ":join";
            } else {
                $thisfield = $value . ":opt";
                if (!$this->searchaction) {
                } elseif (!isset($valuetd["search"])) {
                    $thfvalue = '<input name="' . $thisfield . '" placeholder="' . $valuetd['header'] . '" value="" class="search-field form-control" >';

                } elseif (is_string($valuetd["search"])) {
                    $thfvalue = call_user_func(array($this->class, $valuetd["search"] . 'Search'), $thisfield);
                } else if ($valuetd["search"])
                    $thfvalue = '<input name="' . $thisfield . '" placeholder="' . $valuetd['header'] . '" value="" class="search-field form-control" >';

                if ($valuetd["order"])
                    $thforder = 'order=' . $value;
                //$thforder = '<div class="torder"><i onclick="ddatatable.orderasc(\'order=' . $value . '\')" class="fa fa-angle-up"></i> <i onclick="ddatatable.orderdesc(\'order=' . $value . '\')" class="fa fa-angle-down"></i></div>';

                //$fields[] = $value . ":attr";
            }
            $thf[] = '<th >' . $thfvalue . '</th>';

            if($valuetd["order"])
                $th[] = '<th  onclick="ddatatable.toggleorder(\'' . $this->class . '\', \'' . $thforder . '\')" >' . $valuetd['header'] . ' <i class="fa fa-arrow-up" ></i><i class="fa fa-arrow-down" ></i></th>';
            else
                $th[] = '<th >' . $valuetd['header'] . ' </th>';

        }

        if ($this->enablecolumnaction)
            $th[] = '<th>Action</th>';

        if ($this->searchaction) {
            if ($this->enablecolumnaction)
                $thf[] = '<th>'//<input name="path" value="' . $_GET['path'] . '" hidden >
                    . '<input name="dfilters" value="on" hidden >' //' . implode(",", $fields) . '
                    . '<button onclick="ddatatable.search(\''.$this->classname.'\', this)" class="' . $this->btnsearch_class . '" >search</button> <button id="dcancel-search" onclick="ddatatable.cancelsearch()" type="reset" class="btn btn-light hidden" hidden >cancel</button></th>';

            return ["th" => '<tr>' . implode(" ", $th) . '</tr>',
                "thf" => '<tr class="th-filter">' . implode(" ", $thf) . '</tr>'];
        } else {
            return ["th" => '<tr>' . implode(" ", $th) . '</tr>', "thf" => ''];
        }

    }

    public $template = "";
    public $viewdata = [];

    private function buildCustomView($entity)
    {

// todo: handle default action to send to the view
        $actionbutton = self::actionListView($entity);
        $customrowaction = $this->buildCustomAction($entity);

        return \Genesis::getView($this->template, [
                $this->classname => $entity,
                "defaultactions" => $this->defaultaction,
                "customactions" => $this->customactions,
            ]+$this->viewdata);
    }

    public function renderCustomBody($el = "", $directive = [], $column = null)
//    public function renderCustomBody($template = "", $column = null)
    {
        $collection = [];
//        if ($template)
//            $this->template = $template;

        if (!$this->template) {
            echo "you must specify a custom template!!";
            return;
        }

        $this->lazyloading($this->entity, $this->qbcustom, $this->order_by);

        $filterParam = "";
        if (!empty($this->filterParam)) {
            foreach ($this->filterParam as $key => $value)
                $filterParam .= "&$key=$value";
            //$filterParam = "&" . implode("&", $this->filterParam);
        }

        $dentity = \Dvups_entity::select()->where("this.name", $this->class)->__getOne();
        if ($this->base_url)
            $route = $this->base_url;
        else
            $route = $dentity->dvups_module->route();

        $directive = \Form::serialysedirective($directive);
        // data-perpage="' . $this->per_page . '" data-filterparam="' . $filterParam . '" data-route="' . $route . '" data-entity="' . $this->class . '"  class="dv_datatable ' . $this->table_class . '"
        echo '<div id="dv_' . $this->class . '_table" class="dv_datatable_container dataTables_wrapper dt-bootstrap4"  >';
        echo "<div id='dv_table' data-perpage=\"" . $this->per_page . "\" data-filterparam=\"" . $filterParam . "\" data-route=\"" . $route . "\" data-entity=\"" . $this->class . "\"  class=\"dv_datatable " . $this->table_class . "\" >";
        echo "<$el $directive >";
        $cvlot = [];
        foreach ($this->listentity as $i => $entity) {
            $view = $this->buildCustomView($entity);

            if (!$column) {
                echo $view;
                continue;
            }
            $cvlot[] = $view;
            if (count($cvlot) == $column) {
                //$collection[] = "<div class='row'>". $cvlot ."</div>";
                echo "<div class='row'>" . implode("", $cvlot) . "</div>";
                $cvlot = [];
            }

        }
        //return $cvlot;
        //if (!$column) {
        echo "</$el>";
        //return;
        //}

        if (count($cvlot) != 0 && count($cvlot) < $column) {
            //$collection[] = $cvlot;
            echo "<div class='row'>" . implode("", $cvlot) . "</div>";
        }
        echo "</div></div>";

    }

    private function tablebodybuilder()
    {

        foreach ($this->listentity as $entity) {
            $tr = [];

            if ($this->groupaction) {
                $checkmethod = 'isSelectable'; // must return a boolean
                if (method_exists($entity, $checkmethod)) {
                    if (call_user_func(array($entity, $checkmethod)))
                        $tr[] = '<td><input name="id[]" value="' . $entity->getId() . '" type="checkbox" class="dcheckbox" ></td>';
                    else
                        $tr[] = '<td></td>';
                } elseif ($this->isRadio)
                    $tr[] = '<td><input name="id" value="' . $entity->getId() . '" type="radio" class="dcheckbox" ></td>';
                else
                    $tr[] = '<td><input name="id[]" value="' . $entity->getId() . '" type="checkbox" class="dcheckbox" ></td>';

            }

            foreach ($this->datatablemodel as $valuetd) {

                if(is_callable($valuetd["value"])){
                    $tdcontent = $valuetd["value"]($entity);
                    $tr[] = "<td>" . $tdcontent . "</td>";
                    continue;
                }

                // will call the default get[Value] of the attribut
                $value = $valuetd["value"];

                // detection of pipe
                $pipe = explode("|", $value);
                $format = null;
                if(count($pipe) > 1){
                    $value = $pipe[0];
                    $format = $pipe[1];
                }

                $tdcontent = "";
                $param = [];
                // but if dev set get the will call custom get[Get]
                if (isset($valuetd["get"]))
                    $value = $valuetd["get"];

                if (isset($valuetd["param"]))
                    $param = $valuetd["param"];

                if (is_callable($value)) {
                    if ($param)
                        $tdcontent = $value($entity, $param);
                    else
                        $tdcontent = $value($entity);

                    $tr[] = "<td>" . $tdcontent . "</td>";

                    continue;
                }

                $join = explode(".", $value);
                if (isset($join[1])) {

                    $collection = explode("::", $join[0]);
                    $src = explode(":", $join[0]);

                    if (isset($src[1]) and $src[0] = 'src') {

                        $entityjoin = call_user_func(array($entity, 'get' . ucfirst($src[1])), $param);
                        $tdcontent = call_user_func(array($entityjoin, 'show' . ucfirst($join[1])), $param);

                    } elseif (isset($collection[1])) {
                        $td = [];
                        $entitycollection = call_user_func(array($entity, 'get' . ucfirst($collection[1])), $param);
                        foreach ($entitycollection as $entity) {
                            $entityjoin = call_user_func(array($entity, 'get' . ucfirst($join[0])), $param);
                            $tdcontent = call_user_func(array($entityjoin, 'get' . ucfirst($join[1])), $param);
                        }
                        $tdcontent = call_user_func(array($entityjoin, 'get' . ucfirst($join[1])), $param);
                    } else {
                        $entityjoin = call_user_func(array($entity, 'get' . ucfirst($join[0])), $param);

                        // todo: perform this option next time
                        $dventity = \Dvups_entity::getbyattribut("this.name", ucfirst($join[0]));
                        $tdcontent = "<a class='".$join[0]."' href='".$dventity->route()."' target='_blank'>" .
                            call_user_func(array($entityjoin, 'get' . ucfirst($join[1])), $param). "</a>";

                    }

                }
                else {
                    $src = explode(":", $join[0]);

                    if (isset($src[1]) and $src[0] = 'src') {

                        $tdcontent = call_user_func(array($entity, 'show' . ucfirst($src[1])), $param);
                        //$td = "<td>" . $file . "</td>";
                    } elseif (isset($valuetd["param"])) {
                        $param = $valuetd["param"];
                        $tdcontent = call_user_func_array(array($entity, 'get' . ucfirst($value)), $param);
                        //dv_dump($param);
                    } else {
                        if (is_object(call_user_func(array($entity, 'get' . ucfirst($value)))) && get_class(call_user_func(array($entity, 'get' . ucfirst($value)))) == "DateTime") {
                            $tdcontent = call_user_func(array($entity, 'get' . ucfirst($value)), $param)->format('d M Y');
                        } else {
                            $tdcontent = call_user_func(array($entity, 'get' . ucfirst($value)), $param);
                        }
                    }

                }
                if (isset($valuetd["callback"])) {
                    $tdcontent = call_user_func($valuetd["callback"], $tdcontent);
                }

                if($format) {
                    switch ($format){
                        case "money":
                            $tr[] = "<td class='text-right'>" . Util::money($tdcontent) . "</td>";
                            break;
//                        case "href":
//                            $dventity = \Dvups_entity::getbyattribut("this.name", $join[0]);
//                            $tr[] = "<td><a href='".$dventity->route()."'>" . $tdcontent . "</a></td>";
                            break;
                    }
                }else
                    $tr[] = "<td>" . $tdcontent . "</td>";

            }

            $actionbutton = true;
            $act = "";

            $this->rowaction = [];
            $customrowaction = [];
            // the user may write the method in the entity for better code practice

            if ($this->enablecolumnaction) {

                $customrowaction = $this->buildCustomAction($entity);

                if ($this->defaultaction) {

                    $actionbutton = self::actionListView($entity);

                }

                if ($actionbutton) {

                    $actionbutton = \AdminTemplateGenerator::dt_btn_action($this->rowaction, $customrowaction, $this->actionDropdown, $this->mainrowactionbtn);

//                foreach ($this->rowaction as $action)
//                    $act .= '<li>'. $action . '</li>';

//                $actionbutton = <<<EOD
//    <div class="dropdown">
//        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
//            Action<i class="fa fa-caret-down"></i>
//        </a>
//        <ul class="dropdown-menu dropdown-messages">
//            $act
//        </ul>
//        <!-- /.dropdown-messages -->
//    </div>
//EOD;
                } else {
                    $actionbutton = "<span class='alert alert-info' >not rigth</span>";
                }

                $tr[] = '<td style="padding: .3rem;" >' . $actionbutton . '</td>';

            }

            // onclick="ddatatable.rowselect(this, ' . $entity->getId() . ')"
            $tb[] = '<tr id="' . $entity->getId() . '" >' . implode(" ", $tr) . '</tr>';
        }

        return implode(" ", $tb);

    }

    public function buildCustomAction($entity)
    {

        if (!empty($this->customactions)) {
            foreach ($this->customactions as $customaction) {
                if (is_callable($customaction)) {
                    $resactions = $customaction($entity);
                } else
                    $resactions = call_user_func(array($entity, $customaction . 'Action'));

                if (is_array($resactions)) {
                    foreach ($resactions as $action) {
                        if (is_string($action)) {
                            $customrowaction[] = $action;
                        } else
                            $this->rowaction[] = $action;
                    }

                } elseif (is_string($resactions)) {

                    $customrowaction[] = $resactions;
                }

                if (is_string($this->mainrowaction) && $customaction == $this->mainrowaction)
                    $this->mainrowactionbtn = $resactions;

            }
            return $customrowaction;

        }
        return [];
    }

    public function crud_url($read = "", $update = "", $delete = "")
    {
        $this->defaultaction = "customcrud";
        //$this->url_create = $create;
        $this->url_read = $read;
        $this->url_update = $update;
        $this->url_delete = $delete;

        return $this;
    }

    public function disableDefaultaction()
    {
        $this->defaultaction = false;
        return $this;
    }

    public function actionDropdown($param = true)
    {
        $this->actionDropdown = $param;
        return $this;
    }

    public function addcustomaction($action)
    {
        /**
         * $customaction is an instance attribut. it's called while rendering the datatable via ajax
         *
         * but rowaction is a static attribut therefore it's built each time the datatable is rendering and data from
         * customaction are use at that moment.
         */

        if (is_string($action) || is_callable($action))
            $this->customactions[] = $action;

        return $this;
    }

    /**
     * @return false|mixed|Datatable
     */
    public function router()
    {
        $tablemodel = Request::get("tablemodel");
        if (method_exists($this, "build" . $tablemodel . "table") && $result = call_user_func(array($this, "build" . $tablemodel . "table"))) {
            return $result;
        } else
            switch ($tablemodel) {

                default:
                    return $this->buildindextable();
            }

    }

}
