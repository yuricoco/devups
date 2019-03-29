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

    public static function top_action($action, $statefull = false) {
        $action = strtolower($action);
        $index_ajouter = "index.php?path=$action/_new";
        $index_modifier = "index";

        $rigths = getadmin()->availableentityright($action);

        $top_action = '';

        if ($rigths) {
            if (in_array('create', $rigths)) {
                if (in_array('create', $_SESSION['action'])){
                    if(!$statefull)
                        $top_action .= '<button id="model_new" onclick="model._new()"  class="btn btn-success" ><i class="fa fa-plus"></i> add</button>';
                    else
                        $top_action .= '<a href="' . $index_ajouter . '" class="btn btn-success" ><i class="fa fa-plus"></i> add</a>';

                }
                //$top_action .= '<a id="model_new" href="' . $index_ajouter . '" data-toggle="modal" data-target="#' . $action . 'modal"   class="btn btn-default" ><i class="fa fa-plus"></i> add</a>';
            }
        }elseif (isset($_SESSION['action'])) {
            if (in_array('create', $_SESSION['action'])){
                if(!$statefull)
                    $top_action .= '<button id="model_new" onclick="model._new()"  class="btn btn-success" ><i class="fa fa-plus"></i> add</button>';
                else
                    $top_action .= '<a href="' . $index_ajouter . '" class="btn btn-success" ><i class="fa fa-plus"></i> add</a>';

            }

            else {
                $top_action .= "<span class='alert alert-info' >not rigth contact the administrator</span>";
            }
        }

        $top_action .= ' <a href="' . $index_modifier . '" target="_self" class="btn btn-primary" ><i class="fa fa-list"></i> Listing</a> .';

        return $top_action;
    }

    public static function json_encode($value, $options = 0, $depth = 512) {
        echo json_encode($value, $options, $depth);
    }

    public static function renderBladeView($view, $data = [], $action = "list", $redirect = false) {

        global $path;
        global $views;

        if ($redirect && $data['success']) {
            header('location: index.php?path=' . $path[ENTITY] . '/' . $data['redirect']);
        }

        if ($data) {
            $data["__navigation"] = "";//Genesis::top_action($action, $path[ENTITY]);
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
        //die;
    }

    public static function renderView($view, $data = [], $redirect = false) {

        global $viewdir;

        if ($redirect && isset($data['redirect'])) {
            $classroot = Request::classroot("path");
            header('location: index.php?path=' . $classroot . '/' . $data['redirect']);
        }

        $data["__navigation"] = "";//Genesis::top_action($action, $classroot);

        $blade = new Blade($viewdir, admin_dir . "cache");
        echo $blade->view()->make($view, $data)->render();
    }


}
