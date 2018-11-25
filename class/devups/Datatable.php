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
    private $entity = null;
    private static $class;
    
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
                        $actionlien .= '<span onclick="model._edit(' . $id . ')" data-toggle="modal" data-target="#' . $path . 'modal" class="btn btn-default btn-sm" ><i class="fa fa-edit" ></i> edit</span>';
                    else{
                        $actionlien .= '<a href="index.php?path=' . $path . '/_edit&id=' . $id . '" class="btn btn-default btn-sm model_edit" ><i class="fa fa-edit" ></i> edit</a>';
                    }
                }
            }
            if (in_array('read', $rigths)) {

                if (in_array('read', $_SESSION['action'])){
                    if($ajax)
                        $actionlien .= '<span onclick="model._show(' . $id . ')" data-toggle="modal" data-target="#' . $path . 'modal" class="btn btn-default btn-sm" ><i class="fa fa-eye" ></i> view</span> .';
                    else{
                        $actionlien .= '<a href="index.php?path=' . $path . '/_show&id=' . $id . '" class="btn btn-default btn-sm" ><i class="fa fa-eye" ></i> view</a>';
                    }
                }
            }
            if (in_array('delete', $rigths)) {
                if (in_array('delete', $_SESSION['action']))
                    $actionlien .= '<span onclick="model._delete(this, ' . $id . ')"'
                        . ' class="btn btn-default" >delete</span>';
            }
        }

        elseif (isset($_SESSION['action'])) {
            if (in_array('update', $_SESSION['action']) or
                in_array('read', $_SESSION['action']) or
                in_array('delete', $_SESSION['action'])) {

                if (in_array('update', $_SESSION['action'])){
                    if($ajax)
                        $actionlien .= '<span onclick="model._edit(' . $id . ')" data-toggle="modal" data-target="#' . $path . 'modal" class="btn btn-default btn-sm" ><i class="fa fa-edit" ></i> edit</span>';
                    else{
                        $actionlien .= '<a href="index.php?path=' . $path . '/_edit&id=' . $id . '" class="btn btn-default model_edit btn-sm" ><i class="fa fa-edit" ></i> edit</a>';
                    }
                }
//                if (in_array('update', $_SESSION['action']))
//                    $actionlien .= '<span onclick="model._edit(' . $id . ')" data-toggle="modal" data-target="#' . $path . 'modal" class="btn btn-default" >edit</span>';
                //$actionlien .= '<a data-id="' . $id . '" href="index.php?path=' . $path . '/_edit&id=' . $id . '"  class="btn btn-default model_edit" data-toggle="modal" data-target="#' . $path . 'modal" >edit</a>';

                if (in_array('read', $_SESSION['action'])){
                    if($ajax)
                        $actionlien .= '<span onclick="model._show(' . $id . ')" data-toggle="modal" data-target="#' . $path . 'modal" class="btn btn-default btn-sm" ><i class="fa fa-eye" ></i> view</span> .';
                    else{
                        $actionlien .= '<a href="index.php?path=' . $path . '/_show&id=' . $id . '" class="btn btn-default btn-sm" ><i class="fa fa-eye" ></i> view</a>';
                    }
                }
//                if (in_array('read', $_SESSION['action']))
//                    $actionlien .= '<span onclick="model._show(' . $id . ')" data-toggle="modal" data-target="#' . $path . 'modal" class="btn btn-default" >show</span> .';
                //$actionlien .= '<a href="index.php?path=' . $path . '/show&id=' . $id . '" target="_self" class="btn btn-default" >show</a> .';
//			else
//                                $actionlien .= "";
//
                if (in_array('delete', $_SESSION['action']))
                    $actionlien .= '<span onclick="model._delete(this, ' . $id . ')"'
                        . ' class="btn btn-danger btn-sm" ><i class="fa fa-close" ></i> delete</span>';
//                    $actionlien .= '<a href="index.php?path=' . $path . '/delete&id=' . $id . '"'
//                            . ' onclick="if(!confirm(\'Voulez-vous Supprimer\')) return false;" '
//                            . ' class="btn btn-danger" >delete</a>';
//                        else
//                                $actionlien .= "";
//
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

        return '<table id="dv_table" data-entity="'.self::$class.'"  class="table table-bordered table-hover table-striped" >'
            //. '<thead><tr>' . implode(" ", $theader['th']) . '</tr><tr>' . implode(" ", $theader['thf']) . '</tr></thead>'
            . '<tbody>' . implode(" ", $tb) . '</tbody>'
            . '</table>';

    }

    private static function getTableEntityBody($entity, $header) {

//            $tr = [];
//            $tr[] = '<td><input name="id[]" value="'.$entity->getId().'" type="checkbox" class="dcheckbox" ></td>';

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

    public $html = "";
    public $lazyloading = "";
    public $tablefilter = "";
    public $pagination = "";
    public $tablebody = "";
    public $groupaction = true;
    public $searchaction = true;
    public $url_delete = true;
    public $url_update = true;
    public $url_show = true;

    public static function buildtable($lazyloading, $header, $action = true, $defaultaction = true,
                                      $groupedaction = true, $searchaction = true, $tbattr = ["class" => "table table-bordered table-hover table-striped"]){

        $datatable = new Datatable();
        $datatable->lazyloading = $lazyloading;

        return $datatable;

    }

    public function setfilter(){
        //$html .= self::tablefilter($lazyloading['current_page'], $groupedaction);
        $this->tablefilter = self::tablefilter($this->lazyloading['current_page']);
    }
    public function setpagination(){
        $this->pagination = self::pagination($this->lazyloading);
    }

    public function render(){
        $this->html = '
<form id="datatable-form" action="#" method="get" >
    <div class="row">
    <style>
        th{position: relative;}
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
    </style>

    <div class="col-lg-12 col-md-12"><div class="table-responsive">';
        $this->html .= $this->tablefilter;

        $_SESSION['dv_datatable'] = ['class' => self::$class, 'header' => $header, 'action' => $action, 'defaultaction' => $defaultaction];

        $theader = self::buildheader($header, $searchaction);

        if (!$list) {
            $tb = [];
        }else
            $tb = self::getTableBody($list, $header, $action, $defaultaction);

        $this->html .= '<table id="dv_table" data-entity="'.self::$class.'"  class="table table-bordered table-hover table-striped" >'
            . '<thead><tr>' . implode(" ", $theader['th']) . '</tr><tr>' . implode(" ", $theader['thf']) . '</tr></thead>'
            . '<tbody>' . implode(" ", $tb) . '</tbody>'
            . '</table>';

        //$this->html .= self::renderListViewUI($this->lazyloading['listEntity'], $header, $action, $defaultaction, $searchaction);
        $this->html .= $this->pagination;
        return  $this->html;
    }

    public static function renderdata($lazyloading, $header, $action = true, $defaultaction = true,
                                      $groupedaction = true, $searchaction = true, $tbattr = ["class" => "table table-bordered table-hover table-striped"]) {
        self::$class = $lazyloading['classname'];
//        if (!$lazyloading['listEntity']) {
//            return '<div id="dv_table" data-entity="'.$lazyloading['classname'].'" class="text-center">la liste est vide</div>';
//        }

        $html = '
    <div class="row">
<form id="datatable-form" action="#" method="get" >
    <style>
        th{position: relative;}
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
    </style>

    <div class="col-lg-12 col-md-12"><div class="table-responsive">';
        $html .= self::tablefilter($lazyloading['current_page'], $groupedaction);

        $html .= self::renderListViewUI($lazyloading['listEntity'], $header, $action, $defaultaction, $searchaction);

        $html .= ' </div></div>';

        $html .= self::pagination($lazyloading);

        $html .= "</form></div>";

        return $html;
    }

    public static function tablefilter($current_page, $groupedaction) {

        $html = '<div class="col-lg-12 col-md-12">
<div class="row">';

        if($groupedaction){
            $customaction = [];
            if(is_array($groupedaction)){
                foreach ($groupedaction as $action){
                    $customaction[] = "<span class=\"btn btn-info\" onclick=\"".$action["action"]."\" >".$action["label"]."</span>";
                }
            }
            $html .= '
<div class="col-lg-8 col-md-12">
<label class="" >Action groupe:</label> '.implode("", $customaction).'
<span id="deletegroup" class="btn btn-danger">delete</span>
                    </div>';

        }else{

            $html .= '
<div class="col-lg-8 col-md-12 hidden">
<label class="" >Action groupe:</label> Non disponible </div>';

        }

        $html .= '                    
            <div class="col-lg-4 col-md-12 hidden">

        <label class=" col-lg-7" >Nombre de ligne </label>';

        $html .= '<select class="form-control" style="width:100px;" onchange="ddatatable.setperpage(this.options[this.selectedIndex].value)" >';
        //$html .= '<option value="&next=' . $current_page . '&per_page=10" >10</option>';
        $html .= '<option value="10" >10</option>';
        $html .= '<option value="20" >20</option>';
        $html .= '<option value="30" >30</option>';
        $html .= '<option value="40" >40</option>';
        $html .= '<option value="50" >50</option>';
        $html .= '<option value="100" >100</option>';
        $html .= '<option value="all" >All</option>';

        $html .= " </select>
    </div>
    </div>
    </div>";

        return $html;
    }

    public static function pagination($lazyloading) {
        extract($lazyloading);
        if (!$lazyloading['listEntity']) {
            return' no page';
        }

        if($pagination <= 1){return '';}

        $html = '<div id="dv_pagination" class="col-lg-12"><div class="row">
            <div id="pagination-notice" data-notice="' . $pagination . '" class="col-lg-6 col-md-6">Showing ' . ( ($current_page - 1) * $per_page + 1) . ' to ' . $per_page * $current_page . ' of ' . $nb_element . '</div>
            ';


        $html .= '<div class="col-lg-6 col-md-6">
                <div class="dataTables_paginate paging_simple_numbers text-right">
                    <ul class="pagination">';
        if ($previous > 0)
            $html .= '<li class="paginate_button previous"><a onclick="ddatatable.previous()" >previous</a></li>';//' . $url . '&next=' . $previous . '&per_page=' . $per_page . '
        else
            $html .= '<li class="paginate_button previous disabled"><a href="#">previous</a></li>';

        for ($page = 1; $page <= $pagination; $page++) {
            if ($page == $current_page) {
                $html .= '<li class="paginate_button active "><a onclick="ddatatable.pagination(' . $page . ')" data-next="' . $page . '" >' . $page . '</a></li>';//' . $url . '&next=' . $page . '&per_page=' . $per_page . '
            } else {
                $html .= '<li class="paginate_button "><a onclick="ddatatable.pagination(' . $page . ')" data-next="' . $page . '" >' . $page . '</a></li>';//' . $url . '&next=' . $page . '&per_page=' . $per_page . '
            }
        }

        if ($remain)
            $html .= '<li class="paginate_button next"><a onclick="ddatatable.next()" >next</a></li>';//' . $url . '&next=' . $next . '&per_page=' . $per_page . '
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

    public static function renderListViewUI($list, $header, $action = false, $defaultaction = true, $searchaction = true) {


        $_SESSION['dv_datatable'] = ['class' => self::$class, 'header' => $header, 'action' => $action, 'defaultaction' => $defaultaction];

        $theader = self::buildheader($header, $searchaction);

        if (!$list) {
            $tb = [];
        }else
            $tb = self::getTableBody($list, $header, $action, $defaultaction);

        return '<table id="dv_table" data-entity="'.self::$class.'"  class="table table-bordered table-hover table-striped" >'
            . '<thead><tr>' . implode(" ", $theader['th']) . '</tr><tr>' . implode(" ", $theader['thf']) . '</tr></thead>'
            . '<tbody>' . implode(" ", $tb) . '</tbody>'
            . '</table>';
    }

    public static function getSingleRowRest($entity) {
        if(isset($_SESSION["dv_datatable"]) && $_SESSION["dv_datatable"]["class"] == strtolower(get_class($entity)))
            return self::getTableRest(\Controller::lastpersistance($entity))[0];

        return "";
    }

    public static function getTableRest($lazyloading) {
        extract($_SESSION["dv_datatable"]);
        self::$class = $lazyloading["classname"];

        if (!$lazyloading["listEntity"]) {
            return '<div id="dv_table" data-entity="'.self::$class.'" class="text-center">la liste est vide</div>';
        }
        return self::getTableBody($lazyloading["listEntity"], $header, $action, $defaultaction);
    }

    private static function buildheader($header, $searchaction) {
        $thf = [];
        $th = [];
        $fields = [];
        $th[] = '<th><input id="checkall" name="all" type="checkbox" class="" ></th>';
        $thf[] = '<th></th>';

        foreach ($header as $valuetd) {
            $th[] = '<th>' . $valuetd['header'] . '</th>';
            $value = $valuetd["value"];
            $join = explode(".", $value);
            if (isset($join[1])) {

//                $collection = explode("::", $join[0]);
//                $src = explode(":", $join[0]);
                if(isset($valuetd["search"])){
                    if($valuetd["search"]){
                        $thf[] = '<th ><input name="' . str_replace(".", "-", $value) . '" placeholder="' . $valuetd['header'] . '" class="form-control" ><div class="torder"><i onclick="ddatatable.orderasc(\'orderjoin=' . $value . '\')" class="fa fa-angle-up"></i> <i onclick="ddatatable.orderdesc(\'orderjoin=' . $value . '\')" class="fa fa-angle-down"></i></div></th>';
                    }else
                        $thf[] = '<th ></th>';
                }else{
                    $thf[] = '<th ><input name="' . str_replace(".", "-", $value) . '" placeholder="' . $valuetd['header'] . '" class="form-control" ><div class="torder"><i onclick="ddatatable.orderasc(\'orderjoin=' . $value . '\')" class="fa fa-angle-up"></i> <i onclick="ddatatable.orderdesc(\'orderjoin=' . $value . '\')" class="fa fa-angle-down"></i></div></th>';
                }
                $fields[] = str_replace(".", "-", $value) . ":join";
            } else {
                if(isset($valuetd["search"])) {
                    if ($valuetd["search"]) {
                        $thf[] = '<th ><input name="' . $value . '" placeholder="' . $valuetd['header'] . '" class="form-control" ><div class="torder"><i onclick="ddatatable.orderasc(\'order=' . $value . '\')" class="fa fa-angle-up"></i> <i onclick="ddatatable.orderdesc(\'order=' . $value . '\')" class="fa fa-angle-down"></i></div></th>';
                    }else
                        $thf[] = '<th ></th>';
                }else
                    $thf[] = '<th ><input name="' . $value . '" placeholder="' . $valuetd['header'] . '" class="form-control" ><div class="torder"><i onclick="ddatatable.orderasc(\'order=' . $value . '\')" class="fa fa-angle-up"></i> <i onclick="ddatatable.orderdesc(\'order=' . $value . '\')" class="fa fa-angle-down"></i></div></th>';

                $fields[] = $value . ":attr";
            }
        }

        if ($searchaction) {
            $th[] = '<th>Action</th>';

            $thf[] = '<th>'//<input name="path" value="' . $_GET['path'] . '" hidden >
                . '<input name="dfilters" value="' . implode(",", $fields) . '" hidden >'
                . '<button class="btn btn-default">search</button><input onclick="ddatatable.cancelsearch()" type="reset" class="btn btn-default hidden" value="cancel" /></th>';
        }

        return ["th" => $th, "thf" => $thf];

    }

    private static function getTableBody($list, $header, $action = false, $defaultaction = true, $userbaseurl = "") {

        foreach ($list as $entity) {
            $tr = [];
            $tr[] = '<td><input name="id[]" value="'.$entity->getId().'" type="checkbox" class="dcheckbox" ></td>';

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

                        $tr[] = "<td>" . $file . "</td>";
                    } elseif (isset($collection[1])) {
                        $td = [];
                        $entitycollection = call_user_func(array($entity, 'get' . ucfirst($collection[1])));
                        foreach ($entitycollection as $entity) {
                            $entityjoin = call_user_func(array($entity, 'get' . ucfirst($join[0])));
                            $td[] = '<td>' . call_user_func(array($entityjoin, 'get' . ucfirst($join[1]))) . '</td>';
                        }
                        $tr[] = '<td>' . call_user_func(array($entityjoin, 'get' . ucfirst($join[1]))) . '</td>';
                    } else {
                        $entityjoin = call_user_func(array($entity, 'get' . ucfirst($join[0])));
                        $tr[] = '<td>' . call_user_func(array($entityjoin, 'get' . ucfirst($join[1]))) . '</td>';
                    }
                } else {

                    $src = explode(":", $join[0]);

                    if (isset($src[1]) and $src[0] = 'src') {

                        $file = call_user_func(array($entity, 'show' . ucfirst($src[1])));
                        $tr[] = "<td>" . $file . "</td>";
                    } else {
                        if (is_object(call_user_func(array($entity, 'get' . ucfirst($value)))) && get_class(call_user_func(array($entity, 'get' . ucfirst($value)))) == "DateTime") {
                            $tr[] = '<td>' . call_user_func(array($entity, 'get' . ucfirst($value)))->format('d M Y') . '</td>';
                        } else {
                            $tr[] = '<td>' . call_user_func(array($entity, 'get' . ucfirst($value))) . '</td>';
                        }
                    }
                }
            }

            $dact = "";
            $act = "";
            if ($defaultaction) {
                if($defaultaction === "statefull")
                    $dact = self::actionListView(self::$class, $entity->getId(), false);
                else
                    $dact = self::actionListView(self::$class, $entity->getId());
            }

            // the user may write the method in the entity for better code practice
            if (!is_bool($action)) {
                $act = call_user_func(array($entity, $action.'Action'));
            }

            $tr[] = '<td>' .  $act . $dact . '</td>';

            $tb[] = '<tr id="' . $entity->getId() . '" >' . implode(" ", $tr) . '</tr>';
        }

        return$tb;
    }

}
