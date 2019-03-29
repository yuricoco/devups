<?php

namespace DClass\devups;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Datatable
 *
 * @author Aurelien Atemkeng
 */
class Datatable {
    public static $btnedit_class = "btn btn-warning btn-sm";
    public static $btnview_class = "btn btn-info btn-sm";
    public static $btndelete_class = "btn btn-danger btn-sm";
    public static $btnsearch_class = "btn btn-primary";
    public static $table_class = "table table-striped table-hover dataTable no-footer";

    private $entity = null;
    private static $class;

    public $html = "";
    public $lazyloading = "";
    public $tablefilter = "";
    public $pagination = "";
    public $header = []; // describe the model of the table (available column and metadata of row)
    public $tablebody = "";

    public $defaultaction = "stateless";
    public $customaction = [];
    public $groupaction = false;
    public $groupactioncore = [];
    public $searchaction = false;
    public $openform = "";
    public $closeform = "";

    public static $url_delete = "";
    public static $url_update = "";
    public static $url_read = "";
    public static $url_create = "";
    public $base_url = "";

    public $pagejump = 10;
    public $per_page = 10;
    public $paginationenabled = true;

    public $additionnalrow = [];

    static function init2(\stdClass $entity, $next = 0, $per_page = 10) {
        $dt = new Datatable();
        $dt->entity = $entity;
        return $dt;
    }

    public static function actionListView($path, $id, $ajax = true, $userside = false) {
        $actionlien = "";

        if($userside){

            $actionlien .= '<a href="#"  class="btn btn-default" ><i class="fa fa-edit" ></i>edit</a>';
            $actionlien .= '<a href="#" target="_self" class="btn btn-default" >show</a> .';

            return $actionlien;
        }

        if (!isset($_SESSION['action']))
            return "<span class='alert alert-info' >not rigth contact the administrator</span>";

        $rigths = getadmin()->availableentityright($path);
        if ($rigths) {
            if (in_array('update', $rigths)) {
                if (in_array('update', $_SESSION['action'])){
                    if($ajax)
                        $actionlien .= ' <button onclick="model._edit(' . $id . ')" data-toggle="modal" data-target="#' . $path . 'modal" class="'.self::$btnedit_class.'" ><i class="fa fa-edit" ></i> edit</button>';
                    else{
                        $actionlien .= '<a href="index.php?path=' . $path . '/_edit&id=' . $id . '" class="btn btn-default btn-sm model_edit" ><i class="fa fa-edit" ></i> edit</a>';
                    }
                }
            }

            if (in_array('read', $rigths)) {

                if (in_array('read', $_SESSION['action'])){
                    if($ajax)
                        $actionlien .= ' <button onclick="model._show(' . $id . ')" data-toggle="modal" data-target="#' . $path . 'modal" class="'.self::$btnview_class.'" ><i class="fa fa-eye" ></i> view</button>';
                    else{
                        $actionlien .= '<a href="index.php?path=' . $path . '/_show&id=' . $id . '" class="btn btn-default btn-sm" ><i class="fa fa-eye" ></i> view</a>';
                    }
                }
            }
            if (in_array('delete', $rigths)) {
                if (in_array('delete', $_SESSION['action']))
                    $actionlien .= ' <button onclick="model._delete(this, ' . $id . ')"'
                        . ' class="'.self::$btndelete_class.'" >delete</button>';
            }
        }

        elseif (isset($_SESSION['action'])) {
            if (in_array('update', $_SESSION['action']) or
                in_array('read', $_SESSION['action']) or
                in_array('delete', $_SESSION['action'])) {

                if (in_array('update', $_SESSION['action'])){
                    if($ajax)
                        $actionlien .= ' <button onclick="model._edit(' . $id . ')" data-toggle="modal" data-target="#' . $path . 'modal" class="'.self::$btnedit_class.'" ><i class="fa fa-edit" ></i> edit</button>';
                    else{
                        $actionlien .= '<a href="index.php?path=' . $path . '/_edit&id=' . $id . '" class="'.self::$btnedit_class.'" ><i class="fa fa-edit" ></i> edit</a>';
                    }
                }

                if (in_array('read', $_SESSION['action'])){
                    if($ajax)
                        $actionlien .= ' <button onclick="model._show(' . $id . ')" data-toggle="modal" data-target="#' . $path . 'modal" class="'.self::$btnview_class.'" ><i class="fa fa-eye" ></i> view</button>';
                    else{
                        $actionlien .= '<a href="index.php?path=' . $path . '/_show&id=' . $id . '" class="'.self::$btnview_class.'" ><i class="fa fa-eye" ></i> view</a>';
                    }
                }

                if (in_array('delete', $_SESSION['action']))
                    $actionlien .= ' <button onclick="model._delete(this, ' . $id . ')"'
                        . ' class="'.self::$btndelete_class.'" ><i class="fa fa-close" ></i> delete</button>';

            }else {
                $actionlien .= "<span class='alert alert-info btn-sm' >not rigth contact the administrator</span>";
            }
        }
        return $actionlien;
    }

    public static function renderentitydata($entity, $header){
        self::$class = get_class($entity);

        if (!$header) {
            $tb = [];
        }else
            $tb = self::getTableEntityBody($entity, $header);

        return '<table data-entity="'.self::$class.'"  class="table table-bordered table-hover table-striped" >'
            //. '<thead><tr>' . implode(" ", $theader['th']) . '</tr><tr>' . implode(" ", $theader['thf']) . '</tr></thead>'
            . '<tbody>' . implode(" ", $tb) . '</tbody>'
            . '</table>';

    }

    private static function getTableEntityBody($entity, $header) {

        foreach ($header as $valuetd) {
            // will call the default get[Value] of the attribut
            $value = $valuetd["value"];
            // but if dev set get the will call custom get[Get]
            if(isset($valuetd["get"]))
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

    public static function buildtable($lazyloading, $header, $action = true,
                                      $tbattr = ["class" => "table table-bordered table-hover table-striped"]){

        $datatable = new Datatable();

        self::$class = $lazyloading["classname"];
        $datatable->entity = $lazyloading["classname"];
        $datatable->listentity = $lazyloading["listEntity"];
        $datatable->nb_element = $lazyloading["nb_element"];
        $datatable->per_page = $lazyloading["per_page"];
        $datatable->pagination = $lazyloading["pagination"];
        $datatable->current_page = $lazyloading["current_page"];
        $datatable->next = $lazyloading["next"];
        $datatable->previous = $lazyloading["previous"];
        $datatable->remain = $lazyloading["remain"];

        //unset($lazyloading);
        
        $datatable->header = $header;
        $datatable->action = $action;

        return $datatable;

    }

    public function setpagination($enable = true){
        $this->paginationenabled = $enable;
        return $this;
    }

    public function render(){
        if($this->searchaction){
            $this->openform = '<form id="datatable-form" action="#" method="get" >';
            $this->closeform = '</form>';
        }
        $html = '';//<div class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">

        $html .= '
    <style>
        th{position: relative;}
        tr.th-filter th{padding: 0px !important;}
        .torder{z-index: 3; position: absolute; top:0; right: 0; padding: 15px 12px}
        .loader{
        position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            z-index: 3;
            padding: 25% 0;
            text-align: center;
            color: white;
            font-size: 50px;
            background: rgba(51,122,183,0.3);
        }
    </style>';//.$this->openform;


        $html .= $this->tableoption();

        $_SESSION['dv_datatable'] = ['class' => self::$class,
            'header' => $this->header,
            'customaction' => $this->customaction,
            'groupaction' => $this->groupaction,
            'defaultaction' => $this->defaultaction];

        $theader = $this->headerbuilder();

        if (!$this->listentity) {
            $tb = "";
        }else
            $tb = self::tablebodybuilder($this->listentity, $this->header,
                $this->defaultaction, $this->groupaction, $this->customaction);

        $newrows = "";
        if(!empty($this->additionnalrow)){
            $newrows = $this->rowbuilder();
        }

        $dentity = \Dvups_entity::select()->where("this.name", self::$class)->__getOne();
        $html .= '<table id="dv_table" data-route="'.path( 'src/'. strtolower($dentity->dvups_module->getProject()) .'/'. $dentity->dvups_module->getName() . '/').'" data-entity="'.self::$class.'"  class="'.self::$table_class.'" >'
            . '<thead>' . $theader['th'] . $theader['thf'] . '</thead>'
            . '<tbody>' . $tb . '</tbody>'
            . '<tfoot>' . $newrows . '</tfoot>'
            . '</table>';

        //$this->html .= self::renderListViewUI($this->lazyloading['listEntity'], $header, $action, $defaultaction, $searchaction);
        if($this->paginationenabled)
            $html .= $this->paginationbuilder();

        $html .= "";//</div> $this->closeform.

        return  $html;
    }

    private function tableoption() {

        $html = '<div class="col-lg-12 col-md-12"><div class="row">';

        if($this->groupaction){
            $html .= $this->groupactionbuilder();
        }

        $html .= $this->perpagebuilder();

        $html .= "</div></div>";

        return $html;
    }

    /**
     * @param bool $sure
     */
    public function addgroupaction($action){
        $this->groupaction = true;
        $this->groupactioncore[] = $action;

        return $this;
    }

    public function enablegroupaction(){
        $this->groupaction = true;
        return $this;
    }

    public function addrow($row){
        $this->additionnalrow[] = $row;
        return $this;
    }

    private function rowbuilder(){
        $tr = [];
        foreach ($this->additionnalrow as $row){
            $td = "";
            if($this->groupaction)
                $td .= "<td ></td>";

            foreach ($row["data"] as $data){
                $directive = "";

                if(isset($data["directive"]))
                    $directive = \Form::serialysedirective($data["directive"]);

                $td .= "<td $directive >".$data["value"]."</td>";

            }

            $directive = "";
            if(isset($row["directive"]))
                $directive = \Form::serialysedirective($row["directive"]);

            $tr[] = "<tr $directive >".$td."<td ></td></tr>";
        }

        return implode("", $tr);
    }

    public $defaultgroupaction = '<button id="deletegroup" class="btn btn-danger">delete</button>';
    public function disabledefaultgroupaction(){
        $this->defaultgroupaction = "";
        return $this;
    }

    private function groupactionbuilder(){

        $customaction = [];
        foreach ($this->groupactioncore as $action){
            //$customaction[] = "<span id='".$action["id"]."' class=\"btn btn-info\" >".$action["label"]."</span>";
            $customaction[] = call_user_func(array(self::$class, $action."Groupaction")); //, $param)
        }

        return '
<div class="col-lg-8 col-md-12">
<label class="" >Action groupe:</label> '.implode("", $customaction).'
'.$this->defaultgroupaction.'
                    </div>';

    }

    public function setjumppage($jump = 10){
        $this->pagejump = $jump;
        return $this;
    }


    public function setperpage($nbjump = 10){
        $this->per_page = $nbjump;
        return $this;
    }

    public function disablepagination(){
        $this->paginationenabled = false;
        $this->per_page = "no";
        return $this;
    }

    public function enablefilter(){
        $this->searchaction = true;
        return $this;
    }

    private function perpagebuilder(){
        if(!is_numeric($this->pagejump) || !is_numeric($this->per_page))
            return "";

        $html = '                    
            <div class="col-lg-4 col-md-12 ">

        <label class=" col-lg-7" >Line to show </label>';

        $html .= '<select id="dt_nbrow" class="form-control" style="width:100px;" onchange="ddatatable.setperpage(this.options[this.selectedIndex].value)" >';
        //$html .= '<option value="&next=' . $current_page . '&per_page=10" >10</option>';

        for ($i = 1; $i <= $this->per_page; $i++){
            $html .= '<option value="'.$i * $this->per_page.'" >'.$i * $this->per_page.'</option>';
        }
        $html .= '<option value="all" >All</option>';
        $html .= " </select>
    </div>";

        return $html;
    }

    public function paginationbuilder() {

        if (!$this->listentity) {
            return'<div id="dv_pagination" class="col-lg-12"> no page</div>';
        }

        if(!is_numeric($this->per_page))
            return "<div id=\"dv_pagination\" class=\"col-lg-12\"></div>";

        $html = '<div id="dv_pagination" class="col-lg-12"><div class="row">
            <div id="pagination-notice" data-notice="' . $this->pagination . '" class="col-lg-6 col-md-6">Showing ' . ( ($this->current_page - 1) * $this->per_page + 1) . ' to ' . $this->per_page * $this->current_page . ' of ' . $this->nb_element . '</div>
            ';


        $html .= '<div class="col-lg-6 col-md-6">
                <div class="dataTables_paginate paging_simple_numbers text-right">
                    <ul class="pagination">';
        if ($this->previous > 0)
            $html .= '<li class="paginate_button previous"><a href="javascript:ddatatable.previous()" >previous</a></li>';//' . $url . '&next=' . $previous . '&per_page=' . $per_page . '
        else
            $html .= '<li class="paginate_button previous disabled"><a href="#">previous</a></li>';

        for ($page = 1; $page <= $this->pagination; $page++) {
            if ($page == $this->current_page) {
                $html .= '<li class="paginate_button active "><a href="javascript:ddatatable.pagination(' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';//' . $url . '&next=' . $page . '&per_page=' . $per_page . '
            } else {
                $html .= '<li class="paginate_button "><a href="javascript:ddatatable.pagination(' . $page . ');" data-next="' . $page . '" >' . $page . '</a></li>';//' . $url . '&next=' . $page . '&per_page=' . $per_page . '
            }
        }

        if ($this->remain)
            $html .= '<li class="paginate_button next"><a href="javascript:ddatatable.next();" >next</a></li>';//' . $url . '&next=' . $next . '&per_page=' . $per_page . '
        else
            $html .= '<li class="paginate_button next disabled"><a href="#" >next</a></li>';

        $html .= " </ul>
                </div>
            </div>";

        $html .= " 
            </div>
            </div>";

        return $html;
    }

    public static function getSingleRowRest($entity) {
        if(isset($_SESSION["dv_datatable"]) && $_SESSION["dv_datatable"]["class"] == strtolower(get_class($entity))){

            extract($_SESSION["dv_datatable"]);

            self::$class = $class;
            return self::tablebodybuilder([$entity], $header, $defaultaction, $groupaction, $customaction);

        }
            //return self::getTableRest(\Controller::lastpersistance($entity))[0];

        return "";
    }

    public static function getTableRest($lazyloading) {

        self::$class = $lazyloading["classname"];

        if (!$lazyloading["listEntity"]) {

            return [
                'tablebody' => '<div id="dv_table" data-entity="'.self::$class.'" class="text-center">la liste est vide</div>',
                'tablepagination' => '<div id="dv_pagination" class="col-lg-12"> no page</div>'
            ];

        }

        extract($_SESSION["dv_datatable"]);
        $datatable = new Datatable();

        $datatable->entity = $lazyloading["classname"];
        $datatable->listentity = $lazyloading["listEntity"];
        $datatable->nb_element = $lazyloading["nb_element"];
        $datatable->per_page = $lazyloading["per_page"];
        $datatable->pagination = $lazyloading["pagination"];
        $datatable->current_page = $lazyloading["current_page"];
        $datatable->next = $lazyloading["next"];
        $datatable->previous = $lazyloading["previous"];
        $datatable->remain = $lazyloading["remain"];

        return [
            'tablebody' => self::tablebodybuilder($lazyloading["listEntity"], $header, $defaultaction, $groupaction, $customaction),
            'tablepagination' => $datatable->paginationbuilder()
        ];

    }

    private function headerbuilder() {
        $thf = [];
        $th = [];
        $fields = [];
        if($this->groupaction){
            $th[] = '<th><input id="checkall" name="all" type="checkbox" class="" ></th>';
            $thf[] = '<th></th>';
        }

        foreach ($this->header as $valuetd) {
            $th[] = '<th>' . $valuetd['header'] . '</th>';
            $value = $valuetd["value"];
            if(!isset($valuetd["order"]))
                $valuetd["order"] = false;

            $thfvalue = '';
            $join = explode(".", $value);
            if (isset($join[1])) {
                $thisfield = str_replace(".", "-", $value) . ":attr";
                if(!$this->searchaction){ }
                elseif(isset($valuetd["search"]) ){
                    if(is_string($valuetd["search"])){
                        $thfvalue = call_user_func(array(self::$class, $valuetd["search"].'Search'), $thisfield);
                    }else
                        $thfvalue = '<input name="' . $thisfield . '" value="" placeholder="' . $valuetd['header'] . '" class="form-control" >';
                }else{
                }

                if($valuetd["order"]){
                    $thfvalue .= '<div class="torder"><i onclick="ddatatable.orderasc(\'orderjoin=' . $value . '\')" class="fa fa-angle-up"></i> <i onclick="ddatatable.orderdesc(\'orderjoin=' . $value . '\')" class="fa fa-angle-down"></i></div>';
                }
                //$fields[] = str_replace(".", "-", $value) . ":join";
            } else {
                $thisfield = $value . ":attr";
                if(!$this->searchaction){ }
                elseif(isset($valuetd["search"])) {
                    if (is_string($valuetd["search"])) {
                        $thfvalue = call_user_func(array(self::$class, $valuetd["search"].'Search'), $thisfield);
                    }else
                        $thfvalue = '<input name="' . $thisfield . '" placeholder="' . $valuetd['header'] . '" value="" class="form-control" >';

                }
                if($valuetd["order"])
                    $thfvalue .= '<div class="torder"><i onclick="ddatatable.orderasc(\'order=' . $value . '\')" class="fa fa-angle-up"></i> <i onclick="ddatatable.orderdesc(\'order=' . $value . '\')" class="fa fa-angle-down"></i></div>';

                //$fields[] = $value . ":attr";
            }
            $thf[] = '<th >' . $thfvalue . '</th>';
        }

        $th[] = '<th>Action</th>';

        if ($this->searchaction) {
            $thf[] = '<th>'//<input name="path" value="' . $_GET['path'] . '" hidden >
                . '<input name="dfilters" value="on" hidden >' //' . implode(",", $fields) . '
                . '<button onclick="ddatatable.search(this)" class="'.self::$btnsearch_class.'" >search</button> <button id="dcancel-search" onclick="ddatatable.cancelsearch()" type="reset" class="btn btn-light hidden" hidden >cancel</button></th>';

            return ["th" => '<tr>'.implode(" ", $th).'</tr>',
                "thf" => '<tr class="th-filter">'.implode(" ", $thf) .'</tr>'];
        }else{
            return ["th" => '<tr>'.implode(" ", $th).'</tr>', "thf" => ''];
        }

    }

    private static function tablebodybuilder($listentity, $header, $defaultaction, $groupaction, $customaction) {

        foreach ($listentity as $entity) {
            $tr = [];

            if($groupaction)
                $tr[] = '<td><input name="id[]" value="'.$entity->getId().'" type="checkbox" class="dcheckbox" ></td>';

            foreach ($header as $valuetd) {
                // will call the default get[Value] of the attribut
                $value = $valuetd["value"];
                $tdcontent = "";
                $param = [];
                // but if dev set get the will call custom get[Get]
                if(isset($valuetd["get"]))
                    $value = $valuetd["get"];

                if(isset($valuetd["param"]))
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

                }
                else {
                    $src = explode(":", $join[0]);

                    if (isset($src[1]) and $src[0] = 'src') {

                        $tdcontent = call_user_func(array($entity, 'show' . ucfirst($src[1])), $param);
                        //$td = "<td>" . $file . "</td>";
                    }
                    else {
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

            $dact = "";
            $act = "";
            if ($defaultaction) {
                if($defaultaction === "statefull")
                    $dact = self::actionListView(self::$class, $entity->getId(), false);
                elseif($defaultaction === "stateless")
                    $dact = self::actionListView(self::$class, $entity->getId());
                else{
                    $dact = "";
                    if(self::$url_read){
                        $show = str_replace('$id', $entity->getId(), self::$url_read);
                        $dact .= '<a href="' . $show . '" class="'.self::$btnview_class.'" ><i class="fa fa-eye" ></i> view</a>';
                    }
                    if(self::$url_update){
                        $update = str_replace('$id', $entity->getId(), self::$url_update);
                        $dact .= '<a href="' . $update . '" class="'.self::$btnedit_class.'" >'.gettranslation("dt.button.edit").'</a>';
                    }
                    if(self::$url_delete){
                        $delete = str_replace('$id', $entity->getId(), self::$url_delete);
                        $dact .= '<a href="' . $delete . '" class="'.self::$btndelete_class.'" ><i class="fa fa-delete" ></i> delete</a>';
                    }
                }
            }

            // the user may write the method in the entity for better code practice
            if (!empty($customaction)) {
                foreach ($customaction as $action)
                    $act .= call_user_func(array($entity, $action.'Action'));
            }

            $tr[] = '<td>' .  $act . $dact . '</td>';

            $tb[] = '<tr id="' . $entity->getId() . '" >' . implode(" ", $tr) . '</tr>';
        }

        return implode(" ", $tb);

    }

    public function crud_url($read = "", $update = "", $delete = ""){
        $this->defaultaction = "customcrud";
        //self::$url_create = $create;
        self::$url_read = $read;
        self::$url_update = $update;
        self::$url_delete = $delete;

        return $this;
    }

    public function addcustomaction($action){
        $this->customaction[] = $action;
        return $this;
    }

}
