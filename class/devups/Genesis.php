<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Philo\Blade\Blade;

/**
 * Description of Genesis
 *
 * @author azankang
 */
class Genesis {

    //put your code here
    private $entityinstance;

//        public function __construct($entity) {
//            $this->entityinstance = $entity;
//        }
    public static function actionListView($path, $id, $action = "") {
        $actionlien = "";

        if (!isset($_SESSION['action']))
            return "<span class='alert alert-info' >not rigth contact the administrator</span>";

        $rigths = getadmin()->availableentityright($path);
        if ($rigths) {
            if (in_array('update', $rigths)) {
                if (in_array('update', $_SESSION['action'])) // next deep is the admin right. its role maybe have the right to do some thing but he maybe not have that right
                    $actionlien .= '<span onclick="edit(' . $id . ')" class="btn btn-default" >edit</span>';
                    //$actionlien .= '<a href="index.php?path=' . $path . '/_edit&id=' . $id . '"  class="btn btn-default" >edit</a>';
            }
            if (in_array('read', $rigths)) {
                if (in_array('read', $_SESSION['action']))
                    $actionlien .= '<a href="index.php?path=' . $path . '/show&id=' . $id . '" target="_self" class="btn btn-default" >show</a> .';
            }
            if (in_array('delete', $rigths)) {
                if (in_array('delete', $_SESSION['action']))
                    $actionlien .= '<a href="index.php?path=' . $path . '/delete&id=' . $id . '"'
                            . ' onclick="if(!confirm(\'Voulez-vous Supprimer\')) return false;" '
                            . ' class="btn btn-default" >delete</a>';
            }
        }
        elseif (isset($_SESSION['action'])) {
            if (in_array('update', $_SESSION['action']) or
                    in_array('read', $_SESSION['action']) or
                    in_array('delete', $_SESSION['action'])) {

                if (in_array('update', $_SESSION['action']))
                    $actionlien .= '<span onclick="model._edit(' . $id . ')" data-toggle="modal" data-target="#' . $path . 'modal" class="btn btn-default" >edit</span>';
                    //$actionlien .= '<a href="index.php?path=' . $path . '/_edit&id=' . $id . '"  class="btn btn-default" >edit</a>';

                if (in_array('read', $_SESSION['action']))
                    $actionlien .= '<span onclick="model._show(' . $id . ')" data-toggle="modal" data-target="#' . $path . 'modal" class="btn btn-default" >show</span> .';
                    //$actionlien .= '<a href="index.php?path=' . $path . '/show&id=' . $id . '" target="_self" class="btn btn-default" >show</a> .';
//			else
//                                $actionlien .= "";
//
                if (in_array('delete', $_SESSION['action']))
                    $actionlien .= '<span onclick="model._delete(this, ' . $id . ')"'
                            . ' class="btn btn-default" >delete</span>';
//                    $actionlien .= '<a href="index.php?path=' . $path . '/delete&id=' . $id . '"'
//                            . ' onclick="if(!confirm(\'Voulez-vous Supprimer\')) return false;" '
//                            . ' class="btn btn-default" >delete</a>';
//                        else
//                                $actionlien .= "";
//
            }else {
                $actionlien .= "<span class='alert alert-info' >not rigth contact the administrator</span>";
            }
        }
        return $actionlien;
    }

    public static function top_action($lien_menu, $action) {

        $index_ajouter = "index.php?path=$action/_new";
        $index_modifier = "index.php?path=$action/index";

        $rigths = getadmin()->availableentityright($action);

        $top_action = '<div class="row">
                            <div class="col-lg-3 col-md-6">
                                    <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                    <div class="row">
                                                            <div class="col-xs-12 ">
                                                                    <h5>' . $lien_menu . ' ' . $action . '</h5>
                                                            </div>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                            <div style="float: right; margin-right: 30px;"  class="panel">';

        if ($rigths) {
            if (in_array('create', $rigths)) {
                if (in_array('create', $_SESSION['action']))
                    $top_action .= '<button onclick="model._new()" class="btn btn-default" data-toggle="modal" data-target="#' . $action . 'modal" type="button">
                <i class="fa fa-plus"></i>
            </button>';
                //$top_action .= '<a href="' . $index_ajouter . '"  class="btn btn-default" >add</a>';
            }
        }elseif (isset($_SESSION['action'])) {
            if (in_array('create', $_SESSION['action']))
                $top_action .= '<button onclick="model._new()" class="btn btn-default" data-toggle="modal" data-target="#' . $action . 'modal" type="button">
                <i class="fa fa-plus"></i> Create
            </button>';
                //$top_action .= '<a href="' . $index_ajouter . '"  class="btn btn-default" >add</a>';
            else {
                $top_action .= "<span class='alert alert-info' >not rigth contact the administrator</span>";
            }
        }

        $top_action .= '<a href="' . $index_modifier . '" target="_self" class="btn btn-default" ><i class="fa fa-list"></i> Listing</a> .';
        $top_action .= '</div>';

        return $top_action;
    }

    public static function json_encode($value, $options = 0, $depth = 512) {

        if (isset($_SESSION["dvups_form"])) {
            unset($_SESSION["dvups_form"]);
        }

        echo json_encode($value, $options, $depth);
    }

    public static function renderBladeView($view, $data = [], $action = "list", $redirect = false) {

        global $path;
        global $views;

        if ($redirect && $data['success']) {

            if (isset($_SESSION["dvups_form"])) {
                unset($_SESSION["dvups_form"]);
            }

            header('location: index.php?path=' . $path[ENTITY] . '/' . $data['redirect']);
        }

        if ($data) {
            $data["__navigation"] = Genesis::top_action($action, $path[ENTITY]);
        }

        $blade = new Blade([$views, admin_dir . 'views'], admin_dir . "cache");
        echo $blade->view()->make($view, $data)->render();
    }

    public static function render($view, $data = []) {

        $compilate = [];
        if ($data) {
            if (key_exists(0, $data)) {
                foreach ($data as $el) {
                    foreach ($el as $key => $value) {
                        $compilate[$key] = $value;
                    }
                }
            } else {
                $compilate = $data;
            }
        }

        $blade = new Blade([web_dir . "views", admin_dir . 'views'], admin_dir . "cache");
        echo $blade->view()->make($view, $compilate)->render();
    }

    public static function renderView($view, $data = [], $action = "list", $redirect = false) {

        global $path;
        global $views;

        if ($redirect && $data['success']) {

            if (isset($_SESSION["dvups_form"])) {
                unset($_SESSION["dvups_form"]);
            }

            header('location: index.php?path=' . $path[ENTITY] . '/' . $data['redirect']);
        }

        $data["__navigation"] = Genesis::top_action($action, $path[ENTITY]);

        $blade = new Blade([$views, admin_dir . 'views'], admin_dir . "cache");
        echo $blade->view()->make($view, $data)->render();
    }

    public static function lazyloading($lazyloading, $header, $action = true) {

        if (!$lazyloading['listEntity']) {
            return'<div class="text-center">la liste est vide</div>';
        }

        $html = '<div class="row"><form action="index.php" method="get" >

    <div class="col-lg-12 col-md-12"><div class="table-responsive">';
        $html .= self::tablefilter($lazyloading['current_page']);
        $html .= Genesis::renderListView($lazyloading['listEntity'], $header, $action);

        $html .= ' </div>';

        $html .= Genesis::pagination($lazyloading);

        $html .= "</form></div>";
        return $html;
    }

    public static function lazyloadingUI($lazyloading, $header, $action = true, $defaultaction = true, $tbattr = ["class" => "table table-bordered table-hover table-striped"]) {

        $path = explode('/', $_GET['path']);
        if (!$lazyloading['listEntity']) {
            return '<div id="dv_table" data-entity="'.$path[0].'" class="text-center">la liste est vide</div>';
        }

        $html = '<div class="row"><form id="datatable-form" action="index.php" method="get" >

    <div class="col-lg-12 col-md-12"><div class="table-responsive">';
        $html .= self::tablefilter($lazyloading['current_page']);

        $html .= Genesis::renderListViewUI($lazyloading['listEntity'], $header, $action, $defaultaction);

        $html .= ' </div>';

        $html .= Genesis::pagination($lazyloading);

        $html .= "</form></div>";
        return $html;
    }

    public static function tablefilter($current_page) {

        $uri = explode('&next=', $_SERVER['REQUEST_URI']);

        $url = $uri[0];

        $html = '<div class="row"><div class="col-lg-8 col-md-12">';

        $html .= '<label class="" >Action groupe:</label> <span id="deletegroup" class="btn btn-danger">delete</span>
                    </div>
                    
            <div class="col-lg-4 col-md-12">

        <label class=" col-lg-7" >Nombre de ligne </label>';

        $html .= '<select class="form-control" style="width:100px;" onchange="ddatatable.setperpage(this.options[this.selectedIndex].value)" >';
        //$html .= '<option value="&next=' . $current_page . '&per_page=10" >10</option>';
        $html .= '<option value="20" >20</option>';
        $html .= '<option value="30" >30</option>';
        $html .= '<option value="40" >40</option>';
        $html .= '<option value="50" >50</option>';
        $html .= '<option value="100" >100</option>';
        $html .= '<option value="all" >All</option>';

        $html .= " </select>
    </div></div></div>";

        return $html;
    }

    public static function pagination($lazyloading) {
        extract($lazyloading);
        if (!$lazyloading['listEntity']) {
            return' no page';
        }

        $uri = explode('&next=', $_SERVER['REQUEST_URI']);

        $url = $uri[0];

        $html = '<div class="row">
            <div id="pagination-notice" data-notice="' . $pagination . '" class="col-lg-6 col-md-6">Showing ' . ( ($current_page - 1) * $per_page + 1) . ' to ' . $per_page * $current_page . ' of ' . $nb_element . '</div>
            <div class="col-lg-6 col-md-6">
                <div class="dataTables_paginate paging_simple_numbers text-right">
                    <ul class="pagination">';

        if ($previous > 0)
            $html .= '<li class="paginate_button previous"><a href="' . $url . '&next=' . $previous . '&per_page=' . $per_page . '">previous</a></li>';
        else
            $html .= '<li class="paginate_button previous disabled"><a href="#">previous</a></li>';

        for ($page = 1; $page <= $pagination; $page++) {
            if ($page == $current_page) {
                $html .= '<li class="paginate_button active "><a data-next="' . $page . '" href="' . $url . '&next=' . $page . '&per_page=' . $per_page . '">' . $page . '</a></li>';
            } else {
                $html .= '<li class="paginate_button "><a data-next="' . $page . '" href="' . $url . '&next=' . $page . '&per_page=' . $per_page . '">' . $page . '</a></li>';
            }
        }

        if ($remain)
            $html .= '<li class="paginate_button next"><a href="' . $url . '&next=' . $next . '&per_page=' . $per_page . '">next</a></li>';
        else
            $html .= '<li class="paginate_button next disabled"><a href="#">next</a></li>';

        $html .= " </ul>
                </div>
            </div>
            </div>";

        return $html;
    }

    public static function renderListView($list, $header, $action = true, $tbattr = ["class" => "table table-bordered table-hover table-striped"]) {

        if (!$list) {
            return'<div class="text-center">la liste est vide</div>';
        }

        $th = [];
        $thf = [];
        $tb = [];

        foreach ($header as $value) {
            $th[] = '<th>' . $value . '</th>';
        }

        $class = strtolower(get_class($list[0]));
        foreach ($list as $entity) {
            $tr = [];
            foreach ($header as $value) {
                $join = explode(".", $value);
                if (isset($join[1])) {

                    $thf[] = '<th><input name="' . str_replace(".", "-", $value) . '" placeholder="' . $value . '" class="form-control" ></th>';
                    $fields[] = str_replace(".", "-", $value) . ":join";

                    $collection = explode("::", $join[0]);
                    $src = explode(":", $join[0]);

                    if (isset($src[1]) and $src[0] = 'src') {

                        $entityjoin = call_user_func(array($entity, 'get' . ucfirst($src[1])));
                        $file = call_user_func(array($entityjoin, 'show' . ucfirst($join[1])));

                        $tr[] = "<td><img class='dv-img' width='50' src='" . $file . "' /></td>";
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

                    $thf[] = '<th><input name="' . $value . '" placeholder="' . $value . '" class="form-control" ></th>';
                    $fields[] = $value . ":attr";

                    $src = explode(":", $join[0]);

                    if (isset($src[1]) and $src[0] = 'src') {

                        $file = call_user_func(array($entity, 'show' . ucfirst($src[1])));
                        $tr[] = "<td><img class='dv-img' width='50' src='" . $file . "' /></td>";
                    } else {
                        if (is_object(call_user_func(array($entity, 'get' . ucfirst($value)))) && get_class(call_user_func(array($entity, 'get' . ucfirst($value)))) == "DateTime") {
                            $tr[] = '<td>' . call_user_func(array($entity, 'get' . ucfirst($value)))->format('d M Y') . '</td>';
                        } else {
                            $tr[] = '<td>' . call_user_func(array($entity, 'get' . ucfirst($value))) . '</td>';
                        }
                    }
                }
            }

            if ($action) {
                $tr[] = '<td>' . Genesis::actionListView($class, $entity->getId(), '') . '</td>';
            }

            $tb[] = '<tr>' . implode(" ", $tr) . '</tr>';
        }

        if ($action) {
            $th[] = '<th>Action</th>';
            $thf[] = '<th><input name="path" value="' . $_GET['path'] . '" hidden >'
                    . '<input name="dfields" value="' . implode(",", $fields) . '" hidden >'
                    . '<button class="btn btn-default">search</button></th>';
        }
        
        return '<table id="dv_table" data-entity="" class="table table-bordered table-hover table-striped" ><thead><tr>' . implode(" ", $th) . '</tr></thead><tbody>' . implode(" ", $tb) . '</tbody></table>';
    }

    private static $class;
    public static function renderListViewUI($list, $header, $action = false, $defaultaction = true) {
        $path = explode('/', $_GET['path']);
        if (!$list) {
            return '<div id="dv_table" data-entity="'.$path[0].'" class="text-center">la liste est vide</div>';
        }

        self::$class = strtolower(get_class($list[0]));

        $_SESSION['dv_datatable'] = ['header' => $header, 'action' => $action, 'defaultaction' => $defaultaction];

        $theader = self::buildheader($header, $action);

        $tb = self::getTableBody($list, $header, $action, $defaultaction);

        return '<table id="dv_table" data-entity="'.self::$class.'"  class="table table-bordered table-hover table-striped" >'
        . '<thead><tr>' . implode(" ", $theader['th']) . '</tr><tr>' . implode(" ", $theader['thf']) . '</tr></thead>'
                . '<tbody>' . implode(" ", $tb) . '</tbody>'
                . '</table>';
    }

    public static function getTableRest($lazyloading) {
        extract($_SESSION["dv_datatable"]);
        return self::getTableBody($lazyloading["listEntity"], $header, $action, $defaultaction);
    }

    private static function buildheader($header, $action) {
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

                $thf[] = '<th><input name="' . str_replace(".", "-", $value) . '" placeholder="' . $valuetd['header'] . '" class="form-control" ><i onclick="ddatatable.orderasc(\'orderjoin=' . $value . '\')" class="fa fa-angle-up"></i> <i onclick="ddatatable.orderdesc(\'orderjoin=' . $value . '\')" class="fa fa-angle-down"></i></th>';
                $fields[] = str_replace(".", "-", $value) . ":join";
            } else {
                $thf[] = '<th><input name="' . $value . '" placeholder="' . $valuetd['header'] . '" class="form-control" ><i onclick="ddatatable.orderasc(\'order=' . $value . '\')" class="fa fa-angle-up"></i> <i onclick="ddatatable.orderdesc(\'order=' . $value . '\')" class="fa fa-angle-down"></i></th>';
                $fields[] = $value . ":attr";
            }
        }

        if ($action) {
            $th[] = '<th>Action</th>';

            $thf[] = '<th>'//<input name="path" value="' . $_GET['path'] . '" hidden >
                    . '<input name="dfilters" value="' . implode(",", $fields) . '" hidden >'
                    . '<button class="btn btn-default">search</button><input onclick="ddatatable.cancelsearch()" type="reset" class="btn btn-default hidden" value="cancel" /></th>';
        }

        return ["th" => $th, "thf" => $thf];
        
    }

    private static function getTableBody($list, $header, $action = false, $defaultaction = true) {
        $class = strtolower(get_class($list[0]));

        foreach ($list as $entity) {
            $tr = [];
            $tr[] = '<td><input name="id[]" value="'.$entity->getId().'" type="checkbox" class="dcheckbox" ></td>';

            foreach ($header as $valuetd) {
                $value = $valuetd["value"];
                $join = explode(".", $value);
                if (isset($join[1])) {

                    $collection = explode("::", $join[0]);
                    $src = explode(":", $join[0]);

                    if (isset($src[1]) and $src[0] = 'src') {

                        $entityjoin = call_user_func(array($entity, 'get' . ucfirst($src[1])));
                        $file = call_user_func(array($entityjoin, 'show' . ucfirst($join[1])));

                        $tr[] = "<td><img class='dv-img' width='50' src='" . $file . "' /></td>";
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
                        $tr[] = "<td><img class='dv-img' width='50' src='" . $file . "' /></td>";
                    } elseif (isset($valuetd["callback"])) {

                        $tr[] = '<td>' . $valuetd["callback"]($entity) . '</td>';
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
                $dact = Genesis::actionListView($class, $entity->getId(), '');
            }

            if (!is_bool($action)) {
                $act = $action($entity);
            }

            $tr[] = '<td>' . $dact . $act . '</td>';

            $tb[] = '<tr id="' . $entity->getId() . '" >' . implode(" ", $tr) . '</tr>';
        }

        return$tb;
    }

}
