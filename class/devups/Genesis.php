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
    public static function actionListView($path, $id, $action) {
        $actionlien = "";
        if (isset($_SESSION['action'])) {
            if (in_array('update', $_SESSION['action']) or
                    in_array('read', $_SESSION['action']) or
                    in_array('delete', $_SESSION['action'])) {

                if (in_array('update', $_SESSION['action']))
                    $actionlien .= '<a href="index.php?path=' . $path . '/_edit&id=' . $id . '"  class="btn btn-default" >modifier</a>';

                if (in_array('read', $_SESSION['action']))
                    $actionlien .= '<a href="index.php?path=' . $path . '/show&id=' . $id . '" target="_self" class="btn btn-default" >show</a> .';
//			else
//                                $actionlien .= "";
//
                if (in_array('delete', $_SESSION['action']))
                    $actionlien .= '<a href="index.php?path=' . $path . '/delete&id=' . $id . '"'
                            . ' onclick="if(!confirm(\'Voulez-vous Supprimer\')) return false;" '
                            . ' class="btn btn-default" >delete</a>';
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

//            if(isset($lien_menu)){
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
        if (isset($_SESSION['action'])) {
            if (in_array('create', $_SESSION['action']) or
                    in_array('read', $_SESSION['action'])) {
//
                if (in_array('create', $_SESSION['action']))
                    $top_action .= '<a href="' . $index_ajouter . '"  class="btn btn-default" >add</a>';
//                                            else
//                                                    echo "";
//
                if (in_array('read', $_SESSION['action']))
                    $top_action .= '<a href="' . $index_modifier . '" target="_self" class="btn btn-default" >Listing</a> .';
//                                            else
//                                                    echo "<span class='alert alert-info' >not rigth for 'list' action </span>";
//
            }else {
                $top_action .= "<span class='alert alert-info' >not rigth contact the administrator</span>";
            }
        }
        $top_action .= '</div>';

        return $top_action;
//            }else{
//                    if(isset($_SESSION['privilege_avance'][$action])){
//                            if( in_array('create', $_SESSION['privilege_avance'][$action]) or 
//                                    in_array('read', $_SESSION['privilege_avance'][$action]) ){
//
//                                    if(in_array('create', $_SESSION['privilege_avance'][$action]))
//                                            echo '<a href="'.$index_ajouter.'"  class="btn btn-default" >add</a>';
//                                    else
//                                            echo "";
//
//                                    if(in_array('read', $_SESSION['privilege_avance'][$action]))
//                                            echo '<a href="'.$index_modifier.'" target="_self" class="btn btn-default" >Listing</a> .';
//                                    else
//                                            echo "<span class='alert alert-info' >not rigth for 'list' action </span>";
//
//                            }else{
//                                    echo "<span class='alert alert-info' >not rigth contact the administrator</span>";
//                    }}
//            }
    }

    public static function json_encode($value, $options = 0, $depth = 512) {

        if (isset($_SESSION["dvups_form"])) {
            unset($_SESSION["dvups_form"]);
        }

        return json_encode($value, $options, $depth);
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

        $html = '<div class="row">

    <div class="col-lg-12 col-md-12"><div class="table-responsive">';
        $html .= self::tablefilter($lazyloading['current_page']);
        $html .= Genesis::renderListView($lazyloading['listEntity'], $header, $action);

        $html .= ' </div>';

        $html .= Genesis::pagination($lazyloading);

        $html .= "</div>";
        return $html;
    }

    public static function lazyloadingUI($lazyloading, $header, $action = true, $defaultaction = true, 
            $tbattr = ["class" => "table table-bordered table-hover table-striped"]) {

        if (!$lazyloading['listEntity']) {
            return'<div class="text-center">la liste est vide</div>';
        }

        $html = '<div class="row">

    <div class="col-lg-12 col-md-12"><div class="table-responsive">';
        $html .= self::tablefilter($lazyloading['current_page']);
        
        $html .= Genesis::renderListViewUI($lazyloading['listEntity'], $header, $action, $defaultaction);

        $html .= ' </div>';

        $html .= Genesis::pagination($lazyloading);

        $html .= "</div>";
        return $html;
    }

    public static function tablefilter($current_page) {
        
        $uri = explode('&next=', $_SERVER['REQUEST_URI']);

        $url = $uri[0];

        $html = '<div class="row"><div class="col-lg-8 col-md-12">';
        
        $html .= '<!--label class="" ><input type="checkbox" name="param[]" value="pseudo" /> pseudo</label-->
        <input class="form-control" type="text" onkeyup="myFunction()" placeholder="Find in the table ..." id="myInput" name="search" />
        <!--button class="clear">Find in database</button-->

    
    </div>
            <div class="row"><div class="col-lg-4 col-md-12">

        <label class=" col-lg-7" >Nombre de ligne </label>';

            $html .= '<select class="form-control" style="width:100px;" onchange="window.location.href = \''.$url.'\' + this.options[this.selectedIndex].value" >';
            $html .= '<option value="&next='.$current_page.'&per_page=10" >10</option>';
            $html .= '<option value="&next='.$current_page.'&per_page=20" >20</option>';
            $html .= '<option value="&next='.$current_page.'&per_page=30" >30</option>';
            $html .= '<option value="&next='.$current_page.'&per_page=40" >40</option>';
            $html .= '<option value="&next='.$current_page.'&per_page=50" >50</option>';
            $html .= '<option value="&next='.$current_page.'&per_page=100" >100</option>';
            $html .= '<option value="&next=1&per_page=all" >All</option>';
            
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
            <div class="col-lg-6 col-md-6">Showing ' . ( ($current_page - 1) *  $per_page + 1) . ' to ' . $per_page * $current_page . ' of ' . $nb_element . '</div>
            <div class="col-lg-6 col-md-6">
                <div class="dataTables_paginate paging_simple_numbers text-right">
                    <ul class="pagination">';

        if ($previous > 0)
            $html .= '<li class="paginate_button previous"><a href="' . $url . '&next=' . $previous . '&per_page=' . $per_page . '">previous</a></li>';
        else
            $html .= '<li class="paginate_button previous disabled"><a href="#">previous</a></li>';

        for ($page = 1; $page <= $pagination; $page++) {
            if ($page == $current_page) {
                $html .= '<li class="paginate_button active "><a href="' . $url . '&next=' . $page . '&per_page=' . $per_page . '">' . $page . '</a></li>';
            } else {
                $html .= '<li class="paginate_button "><a href="' . $url . '&next=' . $page . '&per_page=' . $per_page . '">' . $page . '</a></li>';
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

    public static function renderListView($list, $header, $action = true, 
            $tbattr = ["class" => "table table-bordered table-hover table-striped"]) {
        
        if (!$list) {
            return'<div class="text-center">la liste est vide</div>';
        }

        $th = [];
        $tb = [];

        foreach ($header as $value) {
            $th[] = '<th>' . $value . '</th>';
        }
        if ($action) {
            $th[] = '<th>Action</th>';
        }
        $class = strtolower(get_class($list[0]));
        foreach ($list as $entity) {
            $tr = [];
            foreach ($header as $value) {
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
//                    $tr[] = '<td><a href="index.php?path='.$class.'/delete&valid=oui&id='.$entity->getId().'"'
//                                                . ' onclick="if(!confirm(\'Voulez-vous Supprimer\')) return false;" '
//                                                . ' class="btn btn-default" >delete</a></td>';
            }

            $tb[] = '<tr>' . implode(" ", $tr) . '</tr>';
        }

        return '<table id="dv_table" class="table table-bordered table-hover table-striped" ><thead><tr>' . implode(" ", $th) . '</tr></thead><tbody>' . implode(" ", $tb) . '</tbody></table>';
    }

    public static function renderListViewUI($list, $header, $action = false, $defaultaction = true) {
        if (!$list) {
            return '<div class="text-center">la liste est vide</div>';
        }
        $_SESSION['dv_datatable'] = ['header' => $header, 'action' => $header, 'defaultaction' => $defaultaction ];
        
        $th = [];
//        $tb = [];

        foreach ($header as $value) {
            $th[] = '<th>' . $value['header'] . '</th>';
        }
        if ($action) {
            $th[] = '<th>Action</th>';
        }
        
        $tb = self::getTableBody($list, $header, $action, $defaultaction);

        return '<table id="dv_table"  class="table table-bordered table-hover table-striped" ><thead><tr>' . implode(" ", $th) . '</tr></thead><tbody>' . implode(" ", $tb) . '</tbody></table>';
    }

    public static function getTableRest($controller) {
            extract($_SESSION["dv_datatable"]);
            return self::getTableBody($controller["lazyloading"], $header, $action, $defaultaction);
    }
    
    private static function getTableBody($list, $header, $action = false, $defaultaction = true) {
        $class = strtolower(get_class($list[0]));
        foreach ($list as $entity) {
            $tr = [];
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
        
        return $tb;
    }

}
