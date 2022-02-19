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

    protected $btnsearch_class = "btn btn-primary";
    protected $table_class = "table table-bordered table-striped table-hover dataTable no-footer";
    protected $actionDropdown = true;
    private $filterParam = [];
    protected $base_url = "";
    protected $isFrontEnd = false;

    protected $entity = null;
    protected $class;

    protected $html = "";
    protected $lazyloading = "";
    protected $tablefilter = "";
    public $pagination = 0;
    public $paginationcustom = [];
    protected $editAction = null;
    protected $datatablemodel = []; // describe the model of the table (available column and metadata of row)
    protected $header = []; // describe the model of the table (available column and metadata of row)
    protected $tablebody = "";

    public $trattribut_callback = null;

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
    protected $groupactions = [];
    protected $customactions = [];
    protected $rowaction = [];
    protected $mainrowaction = "edit";
    protected $mainrowactionbtn = "";

    protected $groupaction = true;
    protected $searchaction = true;
    protected $enablepagination = true;
    protected $enabletopaction = true;
    protected $enablecolumnaction = true;
    protected $per_pageEnabled = true;
    protected $defaulttopaction = true;
    protected $defaultgroupaction = "";

    protected $openform = "";
    protected $closeform = "";

    protected $qbcustom = null;

    protected $pagejump = 10;
    public $per_page = 10;
    protected $order_by = "";

    protected $additionnalrow = [];
    protected $responsive = "";
    protected $isRadio = false;

    public function __construct($entity = null, $datatablemodel = [])
    {

        if ($entity) {
            $this->entity = $entity;
            $this->class = strtolower(get_class($this->entity));

            $dentity = \Dvups_entity::getbyattribut("this.name", $this->class);
            $this->base_url = $dentity->dvups_module->hydrate()->route();

            $this->defaultgroupaction = '<button id="deletegroup" onclick="ddatatable.groupdelete(this, \'' . $this->class . '\')" class="btn btn-danger btn-block">delete</button>'
                . '<button data-entity="' . $this->class . '"  onclick="ddatatable._export(this, \'' . $this->class . '\')" type="button" class="btn btn-default btn-block" >
            <i class="fa fa-arrow-down"></i> Export csv
        </button>';

            $this->qbcustom = new \QueryBuilder($entity);
        }
        $this->id_lang = \Dvups_lang::defaultLang()->id;
        $this->createaction = [
            //'type' => 'btn',
            'content' => '<i class="fa fa-plus" ></i> ' . t('create'),
            'class' => 'btn btn-success',
            'action' => 'onclick="model._new(this, \'' . $this->class . '\')"',
            'habit' => 'stateless',
            'modal' => 'data-toggle="modal" ',
        ];


    }


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
        /*
         *
         */
        if (getadmin()->getId()) {
            $top_action .= \AdminTemplateGenerator::optionImport($this->class);
            /*$top_action .= '<div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false" >
      <i class="fa fa-angle-down"></i> options
    </button>
    <div class="dropdown-menu text-left" aria-labelledby="btnGroupDrop1">
    
        <button data-entity="' . $this->class . '" type="button" onclick="ddatatable._import(this, \'' . $this->class . '\')" class="  btn btn-default btn-block" >
            <i class="fa fa-arrow-up"></i> Import csv
        </button>
    </div>
  </div>';*/
        }

        return $top_action;

    }

    public function setDefaultAction($action, $callback)
    {
        if (!in_array($action, ["edit", "show", "delete"]))
            dv_dump("available action key are edit , show, delete");

        $this->defaultaction[$action] = $callback;
    }

    private function getaction($entity, $actionkey, $method, $entityrigths)
    {
        if (isset($this->defaultaction[$actionkey]) && in_array($method, $entityrigths)) {
            if (in_array($method, $_SESSION[dv_role_permission])) {
                $method = $actionkey . 'Action';
                if (method_exists($entity, $method)) {
                    $result = call_user_func(array($entity, $method), $this->defaultaction[$actionkey]);
                    if (!is_null($result))
                        $this->defaultaction[$actionkey] = $result;
                    else
                        $this->defaultaction[$actionkey]['action'] = 'onclick="model._' . $actionkey . '(' . $entity->getId() . ', \'' . $this->classname . '\', this)"';
                } else if (is_callable($this->defaultaction[$actionkey])) {
                    $this->defaultaction[$actionkey] = $this->defaultaction[$actionkey]($entity);
                } else
                    $this->defaultaction[$actionkey]['action'] = 'onclick="model._' . $actionkey . '(' . $entity->getId() . ', \'' . $this->classname . '\', this)"';

                return $this->defaultaction[$actionkey];

            }
        }
    }

    public function actionListView($entity)
    {

        if ($this->isFrontEnd) {
            /*$method = 'editFrontAction';
            if (method_exists($entity, $method) && $result = call_user_func(array($entity, $method), $this->defaultaction["edit"])) {
                $this->defaultaction["edit"] = $result;
            } else {
                $this->defaultaction["edit"]['action'] = 'onclick="model._edit(' . $entity->getId() . ', \'' . $this->classname . '\')"';
            }
            $method = 'showFrontAction';
            if (method_exists($entity, $method) && $result = call_user_func(array($entity, $method), $this->defaultaction["show"])) {
                $this->defaultaction["show"] = $result;
            }
            $method = 'deleteFrontAction';
            if (method_exists($entity, $method) && $result = call_user_func(array($entity, $method), $this->defaultaction["delete"])) {
                $this->defaultaction["delete"] = $result;
            } else {
                $this->defaultaction["delete"]['action'] = 'onclick="model._delete(this, ' . $entity->getId() . ', \'' . $this->classname . '\')"';
            }

            if (isset($this->defaultaction[$this->mainrowaction]))
                $this->mainrowactionbtn = $this->defaultaction[$this->mainrowaction];*/

            return 1;
        }

        if (!isset($_SESSION[dv_role_permission]))
            return false;

        //$rigths = getadmin()->availableentityright($path);
        $entityrigths = \Dvups_entity::getRigthOf($this->class);
        if ($entityrigths) {
            $this->rowaction[] = $this->getaction($entity, "edit", 'update', $entityrigths);
            $this->rowaction[] = $this->getaction($entity, "show", 'read', $entityrigths);
            $this->rowaction[] = $this->getaction($entity, "delete", 'delete', $entityrigths);


            if (isset($this->defaultaction[$this->mainrowaction]))
                $this->mainrowactionbtn = $this->defaultaction[$this->mainrowaction];
            else
                $this->mainrowactionbtn = $this->defaultaction["edit"];

            return true;

        } elseif (isset($_SESSION[dv_role_permission])) {
            $entityrigths = $_SESSION[dv_role_permission];

            $this->rowaction[] = $this->getaction($entity, "edit", 'update', $entityrigths);
            $this->rowaction[] = $this->getaction($entity, "show", 'read', $entityrigths);
            $this->rowaction[] = $this->getaction($entity, "delete", 'delete', $entityrigths);

            if (isset($this->defaultaction[$this->mainrowaction]))
                $this->mainrowactionbtn = $this->defaultaction[$this->mainrowaction];
            else
                $this->mainrowactionbtn = $this->defaultaction["edit"];

            return true;
            //}
        } else {
            return false;
        }

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
<div class="d-sm-flex justify-content-between align-items-start">
                                
                                
<div class="col-lg-8 col-md-12">
                                    $groupaction
                                 </div>
<div class="col-lg-4 col-md-12 text-right">
                                    $headaction
                               </div>
                             
                        </div> 
EOF;

        $html .= ' ';//.$this->openform;

        return $html;

    }

    public function render()
    {

        //Lazyloading::$colunms = array_keys($this->datatablemodel);

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
            $dentity = \Dvups_entity::select()->where("this.name", $this->class)->getInstance();
            $this->base_url = path('src/' . strtolower($dentity->dvups_module->project) . '/' . $dentity->dvups_module->name . '/');
        }
        if ($this->entity->dvtranslate)
            $lang = "data-lang='&lang=" . \Dvups_lang::getattribut("iso_code", $this->id_lang) . "'";
        else
            $lang = "";
        $html .= '<div class="  ' . $this->responsive . '">
        <table id="dv_table" ' . $lang . ' data-perpage="' . $this->per_page . '" data-filterparam="' . $filterParam . '" data-route="' . $this->base_url . '" data-entity="' . $this->class . '"  class="dv_datatable ' . $this->table_class . '" >'
            . '<thead>' . $theader['th'] . $theader['thf'] . '</thead>'
            . '<tbody>' . $tbody . '</tbody>'
            . '<tfoot>' . $newrows . '</tfoot>'
            . '</table></div>';

        //$this->html .= self::renderListViewUI($this->lazyloading['listEntity'], $header, $action, $defaultaction, $searchaction);
        if ($this->enablepagination)
            $html .= '<div class="card-footer">' . $this->paginationbuilder() . '</div>';

        $html .= "";//</div> $this->closeform.

        return '<div id="dv_' . $this->class . '_table" class="dv_datatable_container dt-bootstrap4 card card-rounded" >' . $html . '</div>
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
        $this->groupactions[] = $action;

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

        if ($this->isRadio)
            return "";

        $customaction = [];
        foreach ($this->groupactions as $action) {
            //$customaction[] = "<span id='".$action["id"]."' class=\"btn btn-info\" >".$action["label"]."</span>";
            if (is_callable($action))
                $customaction[] = $action(); //, $param)
            else if (is_string($action))
                $customaction[] = $action; //, $param)
            else
                $customaction[] = call_user_func(array($this->class, $action . "Groupaction")); //, $param)
        }

        return '

<div class="btn-group d-inline-block dropdown" role="group">
    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn-shadow dropdown-toggle btn btn-light">
        Action group  
    </button>
    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-131px, 33px, 0px);">
      ' . implode("", $customaction) . '
      ' . $this->defaultgroupaction . '
    </div>
  </div>
           ';

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
            <div data-notice="' . $this->pagination . '" class="col-lg-3 col-md-12 ">

        <label class=" " >' . t("Line to show") . '</label>';

        $html .= '<select id="dt_nbrow" class="form-control" style="width:100px; display: inline-block" onchange="ddatatable.setperpage(this.options[this.selectedIndex].value)" >';
        //$html .= '<option value="&next=' . $current_page . '&per_page=10" >10</option>';

        for ($i = 1; $i <= 10; $i++) {
            $html .= '<option value="' . $i * 10 . '" >' . $i * 10 . '</option>';
        }
        $html .= '<option selected value="' . $this->per_page . '" >' . $this->per_page . '</option>';
        $html .= '<option value="all" >All</option>';
        $html .= " </select>
    </div>";

        return $html;
    }

    public function paginationbuilder()
    {

        return \Genesis::getView("default.pagination",
            [
                "ll" => (object)$this->paginationData(),
                "entityname" => $this->class,
                "base_url" => $this->base_url,
                "perpage" => $this->perpagebuilder()
            ]);

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
                $th[] = '<th><input onclick="ddatatable.checkall(this, \'' . $this->class . '\')" name="all" type="checkbox" class="checkall" ></th>';
            else
                $th[] = '<th></th>';

            $thf[] = '<th></th>';
        }

        foreach ($this->datatablemodel as $key => $valuetd) {
            $thforder = "";

            if (!isset($valuetd["value"]))
                $valuetd["value"] = $key;

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
                    $thforder = 'orderjoin=' . $value;
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

            if ($valuetd["order"])
                $th[] = '<th  onclick="ddatatable.toggleorder(\'' . $this->class . '\', \'' . $thforder . '\')" >' . $valuetd['header'] . ' <i class="mdi mdi-debug-step-out" ></i><i class="mdi mdi-debug-step-into" ></i></th>';
            else
                $th[] = '<th >' . $valuetd['header'] . ' </th>';

        }

        if ($this->enablecolumnaction)
            $th[] = '<th>Action</th>';

        if ($this->searchaction) {
            if ($this->enablecolumnaction)
                $thf[] = '<th>'
                    . '<input name="dfilters" value="on" hidden >'
                    . '<button onclick="ddatatable.search(\'' . $this->classname . '\', this)" class="' . $this->btnsearch_class . '" >' . t("search") . '</button> <button id="dcancel-search" onclick="ddatatable.cancelsearch()" type="reset" class="btn btn-light hidden" hidden >cancel</button></th>';

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
            ] + $this->viewdata);
    }

    public function renderCustomBody($el = "", $directive = [], $column = null)
//    public function renderCustomBody($template = "", $column = null) 694610808
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

    public $group_field_name = "id";
    public function setGroupFieldName($name){
        $this->group_field_name = $name;
        $this->addFilterParam("group_field_name", $name);
        return $this;
    }

    private function tablebodybuilder()
    {

        \DBAL::$id_lang_static = $this->id_lang;
        $iso_code = \Dvups_lang::getattribut("iso_code", $this->id_lang);
        //}

        foreach ($this->listentity as $entity) {
            $tr = [];
            $entityarray = (array)$entity;

            if ($this->groupaction) {
                $checkmethod = 'isSelectable'; // must return a boolean
                if (method_exists($entity, $checkmethod)) {
                    if (call_user_func(array($entity, $checkmethod)))
                        $tr[] = '<td><input name="' . $this->group_field_name . '[]" value="' . $entity->getId() . '" type="checkbox" class="dcheckbox" ></td>';
                    else
                        $tr[] = '<td></td>';
                } elseif ($this->isRadio)
                    $tr[] = '<td><input name="' . $this->group_field_name . '" value="' . $entity->getId() . '" type="radio" class="dcheckbox" ></td>';
                else
                    $tr[] = '<td><input name="' . $this->group_field_name . '[]" value="' . $entity->getId() . '" type="checkbox" class="dcheckbox" ></td>';

            }

            foreach ($this->datatablemodel as $attrib => $valuetd) {

                /**
                 * it seems at each loop something happen and the \DBAL::$id_lang_static is reseted to null/false value
                 * therefore reset it with the instance of id_land
                 */
                \DBAL::$id_lang_static = $this->id_lang;

                if (!isset($valuetd["value"])) {
                    /**
                     * issue: here I tried to test a value set as null and the isset consider those king of $variable
                     * unset . the  goal is to find how to handle that constraint.
                     * 2 solutions are in mind:
                     * - set a default value directly in the select of the query
                     * - find a good way to bypass that isset constraint!
                     * Nb: at the moment I wrote the comment I defined a getter for the null attribute to avoid notice
                     * while datatable is rendering
                     */
                    if (isset($entity->{$attrib})) {
                        $tr[] = "<td>" . $entity->{$attrib} . "</td>";
                    } else {
                        $attrs = explode(".", $attrib);
                        if (count($attrs) > 1) {
                            $tr[] = "<td>" . $entity->{$attrs[0]}->{$attrs[1]} . "</td>"; // maybe we can activate debug mode so that when we are on this we show a notice!
                        } else
                            $tr[] = "<td>" . $entity->{$attrib} . "</td>"; // maybe we can activate debug mode so that when we are on this we show a notice!
                    }
                    continue;
                }

                if (is_callable($valuetd["value"])) {
                    $tdcontent = $valuetd["value"]($entity);
                    $tr[] = "<td>" . $tdcontent . "</td>";
                    continue;
                }

                /**
                 * we should also test this call maybe it can solve the issue explained early.
                 */
                if (isset($entity->{$valuetd["value"]})) {
                    $tr[] = "<td>" . $entity->{$valuetd["value"]} . "</td>";
                    continue;
                }

                // will call the default get[Value] of the attribut
                $value = $valuetd["value"];


                // detection of pipe
                $pipe = explode("|", $value);
                $format = null;
                if (count($pipe) > 1) {
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
                        //$entityjoin = call_user_func(array($entity, 'get' . ucfirst($join[0])), $param);
                        //dv_dump($join[0]);
                        $entityjoin = $entity->{strtolower($join[0])}->hydrate();
                        // todo: perform this option next time
                        $dventity = \Dvups_entity::getbyattribut("this.name", ucfirst($join[0]));
                        //$tdcontent = $entityjoin->{strtolower($join[1])};
                        $tdcontent = "<a class='" . $join[0] . "' href='" . $dventity->route() . "' target='_blank'>" .
                            call_user_func(array($entityjoin, 'get' . ucfirst($join[1])), $param) . "</a>";

                    }

                } else {
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


                if ($format) {
                    switch ($format) {
                        case "money":
                            $tr[] = "<td class='text-right'>" . Util::money($tdcontent) . "</td>";
                            break;
//                        case "href":
//                            $dventity = \Dvups_entity::getbyattribut("this.name", $join[0]);
//                            $tr[] = "<td><a href='".$dventity->route()."'>" . $tdcontent . "</a></td>";
                            break;
                    }
                } else {
                    if (is_array($tdcontent) && $this->entity->dvtranslate) {
                        $tdcontent = $tdcontent[$iso_code];
                    }
                    $tr[] = "<td>" . $tdcontent . "</td>";
                }
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

                } else {
                    $actionbutton = "<span class='alert alert-info' >not rigth</span>";
                }

                $tr[] = '<td style="padding: .3rem;" >' . $actionbutton . '</td>';

            }
            if (is_callable($this->trattribut_callback)) {
                $callable = $this->trattribut_callback;
                $trattr = $callable($entity);
            } else
                $trattr = "";

            // onclick="ddatatable.rowselect(this, ' . $entity->getId() . ')"
            $tb[] = '<tr id="' . $entity->getId() . '" ' . $trattr . ' >' . implode(" ", $tr) . '</tr>';

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
