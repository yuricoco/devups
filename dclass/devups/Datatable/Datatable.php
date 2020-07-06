<?php

namespace dclass\devups\Datatable;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use dclass\devups\Datatable\TableRow;

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
    protected $filterParam = [];
    protected $defaultroute = "";
    protected $dynamicpagination = false;
    protected $isFrontEnd = false;

    protected $entity = null;
    protected $class;

    protected $html = "";
    protected $lazyloading = "";
    protected $tablefilter = "";
    protected $pagination = 0;
    protected $paginationcustom = [];
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
        'action' => 'onclick="model._new()"',
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
    protected $groupaction = false;
    protected $groupactioncore = [];
    protected $searchaction = false;
    protected $openform = "";
    protected $closeform = "";
    protected $defaultgroupaction = "";// '<button id="deletegroup" class="btn btn-danger">delete</button>';

    protected $qbcustom = null;
    protected $order_by = "";

    public $base_url = "";

    protected $pagejump = 10;
    protected $per_page = 10;
    protected $per_pageEnabled = false;

    protected $additionnalrow = [];
    protected $enablepagination = true;
    protected $enabletopaction = true;
    protected $enablecolumnaction = true;
    protected $responsive = "";
    protected $isRadio = false;

    public function __construct($lazyloading, $datatablemodel = [])
    {
        if(!$lazyloading){
            return;
        }

        if($this->entity)
            $this->class = get_class($this->entity);
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

        if( $datatablemodel )
            $this->datatablemodel = $datatablemodel;

        //$this->columnaction = $action;

    }

    public static function buildtable($lazyloading, $header)
    {

        $datatable = new Datatable($lazyloading, $header);
        return $datatable;

    }

    public function top_action() {

        $top_action = '';
        foreach ($this->topactions as $topaction){

            if (method_exists($this->class, $topaction."Action") && $result = call_user_func(array($this->class, $topaction."Action")))
            {
                if(is_array($result))
                    $top_action .= implode('', $result);
                else
                    $top_action .= $result;
            }
            else
                $top_action .= $topaction;

        }
        //$rigths = getadmin()->availableentityright($action);
        if(!$this->defaultaction)
            return $top_action;

        $entityrigths = \Dvups_entity::getRigthOf($this->class);

        if ($entityrigths) {
            // first we check if create action is available for the entity
            if (in_array('create', $entityrigths)) {
                // next we check if the user has create right for this entity
                //if (in_array('create', $rigths)){
                //if (in_array('create', $_SESSION['action'])){
                $top_action .= '<button type="button" class="' . $this->createaction["class"] . '" ' . $this->createaction["action"] . ' >' . $this->createaction["content"] . '</button>';
//                    if(!$statefull)
//                        $top_action .= '<button data-toggle="modal" data-target="#'.$action.'modal" id="model_new" onclick="model._new()"  class="btn btn-success" ><i class="fa fa-plus"></i> add</button>';
//                    else
//                        $top_action .= '<a href="' . $index_ajouter . '" class="btn btn-success" ><i class="fa fa-plus"></i> add</a>';

                //}
                //$top_action .= '<a id="model_new" href="' . $index_ajouter . '" data-toggle="modal" data-target="#' . $action . 'modal"   class="btn btn-default" ><i class="fa fa-plus"></i> add</a>';
            }
        }elseif (isset($_SESSION[dv_role_permission])) {
            if (in_array('create', $_SESSION[dv_role_permission])){
                if (is_string($this->createaction))
                    $top_action .= $this->createaction;
                else
                    $top_action .= '<button type="button" class="' . $this->createaction["class"] . '" ' . $this->createaction["action"] . ' >' . $this->createaction["content"] . '</button>';
            } else {
                $top_action .= "<span class='alert alert-info' ></span>";
            }
        }

        $top_action .= ' <button type="button" onclick="ddatatable._reload()"  class="btn btn-primary" ><i class="fa fa-retweet"></i> Reload</button>';

        return $top_action;

    }

    public function actionListView($entity)
    {

        if ($this->isFrontEnd) {
            $method = 'editFrontAction';
            if (method_exists($entity, $method) && $result = call_user_func(array($entity, $method), $this->defaultaction["edit"])) {
                $this->defaultaction["edit"] = $result;
            }
            $method = 'showFrontAction';
            if (method_exists($entity, $method) && $result = call_user_func(array($entity, $method), $this->defaultaction["show"])) {
                $this->defaultaction["show"] = $result;
            }
            $method = 'deleteFrontAction';
            if (method_exists($entity, $method) && $result = call_user_func(array($entity, $method), $this->defaultaction["delete"])) {
                $this->defaultaction["delete"] = $result;
            }

            if(isset($this->defaultaction[$this->mainrowaction]))
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
                    if (method_exists($entity, $method)){
                        $result = call_user_func(array($entity, $method), $this->defaultaction["edit"]);
                        if (!is_null($result))
                            $this->defaultaction["edit"] = $result;
                        else
                            $this->defaultaction["edit"]['action'] = 'onclick="model._edit(' . $entity->getId() . ')"';
                    }
                    else
                        $this->defaultaction["edit"]['action'] = 'onclick="model._edit(' . $entity->getId() . ')"';

                    $this->rowaction[] = $this->defaultaction["edit"];

                }
            }

            if (in_array('read', $entityrigths)) {
                if (in_array('read', $_SESSION[dv_role_permission])) {

                    $method = 'showAction';
                    if (method_exists($entity, $method) && $result = call_user_func(array($entity, $method), $this->defaultaction["show"]))
                        $this->defaultaction["show"] = $result;
                    else
                        $this->defaultaction["show"]['action'] = 'onclick="model._show(' . $entity->getId() . ')"';

                    $this->rowaction[] = $this->defaultaction["show"];
                }
            }
            if (in_array('delete', $entityrigths)) {
                if (in_array('delete', $_SESSION[dv_role_permission])){

                    $method = 'deleteAction';
                    if (method_exists($entity, $method) && $result = call_user_func(array($entity, $method), $this->defaultaction["delete"]))
                        $this->defaultaction["delete"] = $result;
                    else
                        $this->defaultaction["delete"]['action'] = 'onclick="model._delete(this, ' . $entity->getId() . ')"';

                    $this->rowaction[] = $this->defaultaction["delete"];
                }

            }

            if(isset($this->defaultaction[$this->mainrowaction]))
                $this->mainrowactionbtn = $this->defaultaction[$this->mainrowaction];

            return true;

        } elseif (isset($_SESSION[dv_role_permission])) {
            if (in_array('update', $_SESSION[dv_role_permission]) or
                in_array('read', $_SESSION[dv_role_permission]) or
                in_array('delete', $_SESSION[dv_role_permission])) {

                if (in_array('update', $_SESSION[dv_role_permission])) {
                    $method = 'editAction';
                    if (method_exists($entity, $method)){
                        $result = call_user_func(array($entity, $method), $this->defaultaction["edit"]);
                        if (!is_null($result))
                            $this->defaultaction["edit"] = $result;
                        else
                            $this->defaultaction["edit"]['action'] = 'onclick="model._edit(' . $entity->getId() . ')"';
                    }
                    else
                        $this->defaultaction["edit"]['action'] = 'onclick="model._edit(' . $entity->getId() . ')"';

                    $this->rowaction[] = $this->defaultaction["edit"];
                }

                if (in_array('read', $_SESSION[dv_role_permission])) {
                    $method = 'showAction';
                    if (method_exists($entity, $method) && $result = call_user_func(array($entity, $method), $this->defaultaction["show"]))
                        $this->defaultaction["show"] = $result;
                    else
                        $this->defaultaction["show"]['action'] = 'onclick="model._show(' . $entity->getId() . ')"';

                    $this->rowaction[] = $this->defaultaction["show"];
                }

                if (in_array('delete', $_SESSION[dv_role_permission])){
                    $method = 'deleteAction';
                    if (method_exists($entity, $method)){
                        $result = call_user_func(array($entity, $method), $this->defaultaction["delete"]);
                        if (!is_null($result))
                            $this->defaultaction["delete"] = $result;
                        else
                            $this->defaultaction["delete"]['action'] = 'onclick="model._delete(this, ' . $entity->getId() . ')"';
                    }
                    else
                        $this->defaultaction["delete"]['action'] = 'onclick="model._delete(this, ' . $entity->getId() . ')"';

                    $this->rowaction[] = $this->defaultaction["delete"];
                }

                if(isset($this->defaultaction[$this->mainrowaction]))
                    $this->mainrowactionbtn = $this->defaultaction[$this->mainrowaction];

                return true;
            } else {
                return false;
            }
        }

    }

    public function renderentitydata($entity)//, $header
    {
//        $dt = new Datatable();
//        $dt->class = get_class($entity);

        if (!$this->datatablemodel) {
            $tb = [];
        } else
            $tb = self::getTableEntityBody($entity, $this->datatablemodel);


        $newrows = "";
        if (!empty($this->additionnalrow)) {
            $newrows = $this->rowbuilder();
        }

        return '<table data-entity="' . $this->class . '"  class="table table-bordered table-hover table-striped" >'
            //. '<thead><tr>' . implode(" ", $theader['th']) . '</tr><tr>' . implode(" ", $theader['thf']) . '</tr></thead>'
            . '<tbody>' . implode(" ", $tb) . '</tbody>'
            . '<tfoot>' . $newrows. '</tfoot>'
            . '</table>';

    }

    private static function getTableEntityBody($entity, $header)
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

                    $td = "<td>" . $file . "</td>";
                } elseif (isset($collection[1])) {
                    $td = [];
                    $entitycollection = call_user_func(array($entity, 'get' . ucfirst($collection[1])));
                    foreach ($entitycollection as $entity) {
                        $entityjoin = call_user_func(array($entity, 'get' . ucfirst($join[0])));
                        $td = '<td>' . call_user_func(array($entityjoin, 'get' . ucfirst($join[1]))) . '</td>';
                    }
                    $td = '<td>' . call_user_func(array($entityjoin, 'get' . ucfirst($join[1]))) . '</td>';
                } else {
                    $entityjoin = call_user_func(array($entity, 'get' . ucfirst($join[0])));
                    $td = '<td>' . call_user_func(array($entityjoin, 'get' . ucfirst($join[1]))) . '</td>';
                }
            } else {

                $src = explode(":", $join[0]);

                if (isset($src[1]) and $src[0] = 'src') {

                    $file = call_user_func(array($entity, 'show' . ucfirst($src[1])));
                    $td = "<td>" . $file . "</td>";
                } else {
                    if (is_object(call_user_func(array($entity, 'get' . ucfirst($value)))) && get_class(call_user_func(array($entity, 'get' . ucfirst($value)))) == "DateTime") {
                        $td = '<td>' . call_user_func(array($entity, 'get' . ucfirst($value)))->format('d M Y') . '</td>';
                    } else {
                        $td = '<td>' . call_user_func(array($entity, 'get' . ucfirst($value))) . '</td>';
                    }
                }
            }

            $tr[] = '<tr ><td><b>' . $valuetd["label"] . '</b></td>' . $td . '</tr>';

        }

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

    public function render()
    {

        $this->lazyloading($this->entity, $this->qbcustom, $this->order_by);

        $this->rowaction = [];
        if ($this->searchaction) {
            $this->openform = '<form id="datatable-form" action="#" method="get" >';
            $this->closeform = '</form>';
        }

        $headaction = "";
        if($this->enabletopaction)
            $headaction = $this->top_action();

        $html = <<<EOF
 <div class="">
<div class="card-header-tab card-header">
                        <div class="card-header-title">
                            <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                            
                        </div>
                        <div class="btn-actions-pane-right">
                            <div class="nav">
                            $headaction
                            </div>
                        </div>
                    </div>
EOF;

        $html .= ' ';//.$this->openform;

        $html .= $this->tableoption();

        $theader = $this->headerbuilder();

        if (!$this->listentity) {
            $tb = "";
        } else
            $tb = $this->tablebodybuilder();

        $newrows = "";
        if (!empty($this->additionnalrow)) {
            $newrows = $this->rowbuilder();
        }

        $filterParam = "";
        if (!empty($this->filterParam)) {
            $filterParam = "&". implode("&", $this->filterParam);
        }

        $dentity = \Dvups_entity::select()->where("this.name", $this->class)->__getOne();
        if($this->defaultroute)
            $route = $this->defaultroute;
        else
            $route = path('src/' . strtolower($dentity->dvups_module->getProject()) . '/' . $dentity->dvups_module->getName() . '/') ;

        // data-route="' . $route . '" data-entityurl="' . str_replace("_", "-", $this->class) . '"
        $html .= '<div class="  ' . $this->responsive . '">
        <table id="dv_table" data-perpage="' . $this->per_page . '" data-filterparam="' . $filterParam . '" data-route="' . $route . '" data-entity="' . $this->class . '"  class="dv_datatable ' . $this->table_class . '" >'
            . '<thead>' . $theader['th'] . $theader['thf'] . '</thead>'
            . '<tbody>' . $tb . '</tbody>'
            . '<tfoot>' . $newrows . '</tfoot>'
            . '</table></div>';

        //$this->html .= self::renderListViewUI($this->lazyloading['listEntity'], $header, $action, $defaultaction, $searchaction);
        if ($this->enablepagination)
            $html .= '<div class="card-footer">'.$this->paginationbuilder(). '</div>';

        $html .= "";//</div> $this->closeform.

        return '<div id="dv_' . $this->class . '_table" class="dv_datatable_container dataTables_wrapper dt-bootstrap4" >' . $html . '</div>';
    }

    public function addFilterParam($param, $value)
    {
        $this->filterParam[] = $param."=".$value;
        return $this;
    }

    private function tableoption()
    {

        $html = '<div class="col-lg-12 col-md-12">';

        if ($this->groupaction) {
            $html .= $this->groupactionbuilder();
        }

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

    public function enablegroupaction()
    {
        $this->groupaction = true;
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
            $customaction[] = call_user_func(array($this->class, $action . "Groupaction")); //, $param)
        }

        return '
<div class="col-lg-8 col-md-12">
<label class="" >Action groupe:</label> ' . implode("", $customaction) . '
' . $this->defaultgroupaction . '
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

    public function enablefilter()
    {
        $this->searchaction = true;
        return $this;
    }

    private function perpagebuilder()
    {

        if (!$this->per_pageEnabled)
            return "";

        $html = '                    
            <div class="col-lg-4 col-md-12 ">

        <label class=" col-lg-7" >Line to show </label>';

        $html .= '<select id="dt_nbrow" class="form-control" style="width:100px;" onchange="ddatatable.setperpage(this.options[this.selectedIndex].value)" >';
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
            return '<div id="dv_pagination" > no page</div>';
        }

//        if (!is_numeric($this->paginationnav))
//            return "<div id=\"dv_pagination\" class=\"col-lg-12\"></div>";

        $html = '<div id="dv_pagination" >
<div class="row">
            <div id="pagination-notice" data-notice="' . $this->pagination . '" class="col-lg-4 col-md-4">Showing ' . (($this->current_page - 1) * $this->per_page + 1) . ' to ' . $this->per_page * $this->current_page . ' of ' . $this->nb_element . '</div>
            ';


        $html .= '<div class="col-lg-8 col-md-8">
                <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                    <ul class="pagination">';
        if ($this->previous > 0) {
            $html .= '<li class="paginate_button page-item previous"><a class="page-link" href="javascript:ddatatable.firstpage()" ><i class="fa fa-angle-double-left" ></i></a></li>';
            $html .= '<li class="paginate_button page-item previous"><a class="page-link" href="javascript:ddatatable.previous()" ><i class="fa fa-angle-left" ></i></a></li>';
        }//' . $url . '&next=' . $previous . '&per_page=' . $per_page . '
        else {
            $html .= '<li class="paginate_button page-item previous disabled"><a class="page-link" href="#" ><i class="fa fa-angle-double-left" ></i></a></li>';
            $html .= '<li class="paginate_button page-item previous disabled"><a class="page-link" href="#" ><i class="fa fa-angle-left" ></i></a></li>';

        }

        if ($this->pagination > 10 && !$this->dynamicpagination){
            $options = "";
            for ($page = 1; $page <= $this->pagination; $page++) {
                if ($page == $this->current_page) {
                    $options .= '<option selected value="' . $page . '" >' . $page . '</option>';
                } else {
                    $options .= '<option value="' . $page . '" >' . $page . '</option>';
                }
            }
            $html .= '<select class=" paginate_button page-item" onchange="ddatatable.pagination(this.value)">'.$options.'</select>';
        }
        else
            if ($this->dynamicpagination)
            {

                //dv_dump($this->paginationcustom);
                foreach ($this->paginationcustom['firsts'] as $key => $page) {
                    if ($page == $this->current_page) {
                        $html .= '<li class="paginate_button page-item  active "><a class="page-link" href="javascript:ddatatable.pagination(' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                    } else {
                        $html .= '<li class="paginate_button page-item "><a class="page-link" href="javascript:ddatatable.pagination(' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                    }
                }

                if ($this->current_page < 3 || $this->current_page >= 7)
                    $html .= '<li class="paginate_button page-item "><a class="page-link" href="javascript:ddatatable.pagination(' . $this->paginationcustom['middleleft'] . ');" data-next="' . $this->paginationcustom['middleleft'] . '" >...</a></li>';

                foreach ($this->paginationcustom['middles'] as $key => $page) {
                    //for ($page = 1; $page <= count($this->paginationcustom['middles']); $page++) {
                    if ($page == $this->current_page) {
                        $html .= '<li class="paginate_button page-item active "><a class="page-link" href="javascript:ddatatable.pagination(' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                    } else {
                        $html .= '<li class="paginate_button page-item "><a class="page-link" href="javascript:ddatatable.pagination(' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                    }
                }

                if ($this->paginationcustom['lasts']) {

                    $html .= '<li class="paginate_button page-item "><a class="page-link" href="javascript:ddatatable.pagination(' . $this->paginationcustom['middleright'] . ');" data-next="' . $this->paginationcustom['middleright'] . '" >...</a></li>';

                    foreach ($this->paginationcustom['lasts'] as $key => $page) {
                        //for ($page = 1; $page <= count($this->paginationcustom['lasts']); $page++) {
                        if ($page == $this->current_page) {
                            $html .= '<li class="paginate_button page-item active "><a class="page-link" href="javascript:ddatatable.pagination(' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                        } else {
                            $html .= '<li class="paginate_button page-item "><a class="page-link" href="javascript:ddatatable.pagination(' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                        }
                    }

                }

            }

            else
                for ($page = 1; $page <= $this->pagination; $page++) {
                    if ($page == $this->current_page) {
                        $html .= '<li class="paginate_button page-item active "><a class="page-link" href="javascript:ddatatable.pagination(' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                    } else {
                        $html .= '<li class="paginate_button page-item "><a class="page-link" href="javascript:ddatatable.pagination(' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';
                    }
                }

        if ($this->remain) {
            $html .= '<li class="paginate_button page-item next"><a class="page-link" href="javascript:ddatatable.next();" ><i class="fa fa-angle-right" ></i></a></li>';
            $html .= '<li class="paginate_button page-item next"><a class="page-link" href="javascript:ddatatable.lastpage(' . $this->pagination . ');" ><i class="fa fa-angle-double-right" ></i></a></li>';
        } else {
            $html .= '<li class="paginate_button page-item next disabled"><a class="page-link" href="#" ><i class="fa fa-angle-right" ></i></a></li>';
            $html .= '<li class="paginate_button page-item next disabled"><a class="page-link" href="#" ><i class="fa fa-angle-double-right" ></i></a></li>';
        }

        $html .= " </ul>
                </div>
            </div>";

        $html .= " 
            </div>
            </div>";

        return $html;
    }

    public function getSingleRowRest($entity)
    {
        $this->entity = $entity;
        $this->class = get_class($entity);
        $this->listentity = [$entity];
        return $this->tablebodybuilder();

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
            if(!$this->isRadio)
                $th[] = '<th><input id="checkall" name="all" type="checkbox" class="" ></th>';
            else
                $th[] = '<th></th>';

            $thf[] = '<th></th>';
        }

        foreach ($this->datatablemodel as $valuetd) {
            $thforder = "";

            $value = $valuetd["value"];
            if (!isset($valuetd["order"]))
                $valuetd["order"] = false;

            $thfvalue = '';
            $join = explode(".", $value);
            if (isset($join[1])) {
                //$thisfield = str_replace(".", "-", $value) . ":opt";
                $thisfield = $value . ":opt";
                if (!$this->searchaction) {
                } elseif (isset($valuetd["search"])) {
                    if (is_string($valuetd["search"])) {
                        $thfvalue = call_user_func(array($this->class, $valuetd["search"] . 'Search'), $thisfield);
                    } else
                        $thfvalue = '<input name="' . $thisfield . '" value="" placeholder="' . $valuetd['header'] . '" class="form-control" >';
                }
//                else {
//                }

                if ($valuetd["order"]) {
                    $thforder = '<div class="torder"><i onclick="ddatatable.orderasc(\'orderjoin=' . $value . '\')" class="fa fa-angle-up"></i> <i onclick="ddatatable.orderdesc(\'orderjoin=' . $value . '\')" class="fa fa-angle-down"></i></div>';
                }
                //$fields[] = str_replace(".", "-", $value) . ":join";
            } else {
                $thisfield = $value . ":opt";
                if (!$this->searchaction) {
                } elseif (isset($valuetd["search"])) {
                    if (is_string($valuetd["search"])) {
                        $thfvalue = call_user_func(array($this->class, $valuetd["search"] . 'Search'), $thisfield);
                    } else
                        $thfvalue = '<input name="' . $thisfield . '" placeholder="' . $valuetd['header'] . '" value="" class="search-field form-control" >';

                }
                if ($valuetd["order"])
                    $thforder = '<div class="torder"><i onclick="ddatatable.orderasc(\'order=' . $value . '\')" class="fa fa-angle-up"></i> <i onclick="ddatatable.orderdesc(\'order=' . $value . '\')" class="fa fa-angle-down"></i></div>';

                //$fields[] = $value . ":attr";
            }
            $thf[] = '<th >' . $thfvalue . '</th>';

            $th[] = '<th>' . $valuetd['header'] . $thforder . '</th>';

        }

        if ($this->enablecolumnaction)
            $th[] = '<th>Action</th>';

        if ($this->searchaction) {
            if ($this->enablecolumnaction)
                $thf[] = '<th>'//<input name="path" value="' . $_GET['path'] . '" hidden >
                    . '<input name="dfilters" value="on" hidden >' //' . implode(",", $fields) . '
                    . '<button onclick="ddatatable.search(this)" class="' . $this->btnsearch_class . '" >search</button> <button id="dcancel-search" onclick="ddatatable.cancelsearch()" type="reset" class="btn btn-light hidden" hidden >cancel</button></th>';

            return ["th" => '<tr>' . implode(" ", $th) . '</tr>',
                "thf" => '<tr class="th-filter">' . implode(" ", $thf) . '</tr>'];
        } else {
            return ["th" => '<tr>' . implode(" ", $th) . '</tr>', "thf" => ''];
        }

    }

    private function tablebodybuilder()
    {

        foreach ($this->listentity as $entity) {
            $tr = [];

            if ($this->groupaction){
                $checkmethod = 'isSelectable'; // must return a boolean
                if (method_exists($entity, $checkmethod)) {
                    if (call_user_func(array($entity, $checkmethod)))
                        $tr[] = '<td><input name="id[]" value="'.$entity->getId().'" type="checkbox" class="dcheckbox" ></td>';
                    else
                        $tr[] = '<td></td>';
                }elseif($this->isRadio)
                    $tr[] = '<td><input name="id" value="'.$entity->getId().'" type="radio" class="dcheckbox" ></td>';
                else
                    $tr[] = '<td><input name="id[]" value="'.$entity->getId().'" type="checkbox" class="dcheckbox" ></td>';

            }

            foreach ($this->datatablemodel as $valuetd) {
                // will call the default get[Value] of the attribut
                $value = $valuetd["value"];
                $tdcontent = "";
                $param = [];
                // but if dev set get the will call custom get[Get]
                if (isset($valuetd["get"]))
                    $value = $valuetd["get"];

                if (isset($valuetd["param"]))
                    $param = $valuetd["param"];

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
                        $tdcontent = call_user_func(array($entityjoin, 'get' . ucfirst($join[1])), $param);
                    }

                } else {
                    $src = explode(":", $join[0]);

                    if (isset($src[1]) and $src[0] = 'src') {

                        $tdcontent = call_user_func(array($entity, 'show' . ucfirst($src[1])), $param);
                        //$td = "<td>" . $file . "</td>";
                    } elseif (isset($valuetd["param"])){
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

                $tr[] = "<td>" . $tdcontent . "</td>";
            }

            $actionbutton = true;
            $act = "";

            $this->rowaction = [];
            $customrowaction = [];
            // the user may write the method in the entity for better code practice

            if ($this->enablecolumnaction){

                if (!empty($this->customactions)) {
                    foreach ($this->customactions as $customaction) {
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

                        if(is_string($this->mainrowaction) && $customaction == $this->mainrowaction)
                            $this->mainrowactionbtn = $resactions;

                    }

                }

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

        if (is_string($action))
            $this->customactions[] = $action;
        return $this;
    }

}
