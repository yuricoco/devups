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
                    $top_action .= '<a id="model_new" href="' . $index_ajouter . '" data-toggle="modal" data-target="#' . $action . 'modal"   class="btn btn-default" ><i class="fa fa-plus"></i> add</a>';
            }
        }elseif (isset($_SESSION['action'])) {
            if (in_array('create', $_SESSION['action']))
                $top_action .= '<a id="model_new" href="' . $index_ajouter . '" data-toggle="modal" data-target="#' . $action . 'modal"   class="btn btn-default" ><i class="fa fa-plus"></i> add</a>';

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


}
