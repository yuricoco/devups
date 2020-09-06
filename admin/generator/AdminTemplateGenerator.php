<?php

class AdminTemplateGenerator extends DvAdmin
{

    private $traitement;

    function __construct()
    {
        $this->traitement = new Traitement();
    }

    static function dt_btn_action($rowaction, $customrowactions, $actionDropdown, $mainaction)
    {

        $actionclass = ['edit' => "mb-2 mr-2 btn btn-warning",
            'show' => "mb-2 mr-2 btn btn-info", 'delete' => "mb-2 mr-2 btn btn-danger",];

        $act = "";

        if (!$actionDropdown) {

            foreach ($customrowactions as $el) {
                $act .= '' . $el . '';
            }
            foreach ($rowaction as $el) {
                if (is_array($el)) {

                    if (isset($actionclass[$el["class"]]))
                        $el["class"] = $actionclass[$el["class"]];

                    $act .= '<button type="button" class="' . $el["class"] . '" ' . $el["action"] . ' >' . $el["content"] . '</button>';

                } else {
                    $act .= $el;
                }
            }

            return <<<EOF
$act
EOF;
        }

        foreach ($customrowactions as $el) {
            $act .= '<li class="nav-item">' . $el . '</li>';
        }
        foreach ($rowaction as $el) {

            if (is_array($el)) {

                if (isset($actionclass[$el["class"]]))
                    $el["class"] = $actionclass[$el["class"]];

                $act .= '<li class="nav-item"><button type="button" class="' . $el["class"] . ' btn-block" ' . $el["action"] . ' >' . $el["content"] . '</button></li>';

            } else {
                $act .= $el;
            }
        }

        if (is_array($mainaction)) {

//                if (isset($actionclass[$mainaction["class"]]))
//                    $mainaction["ctlass"] = $actionclass[$mainaction["class"]];

            $mainaction = '<button type="button" class="btn btn-warning" ' . $mainaction["action"] . ' >' . $mainaction["content"] . '</button>';

            }
        return <<<EOF
<div class="btn-group d-inline-block dropdown">
    $mainaction
    <div class="btn-group" role="group">
    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn-shadow dropdown-toggle btn btn-light">
        <i class="fa fa-angle-down"></i>
    </button>
    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-131px, 33px, 0px);">
        <ul class="nav flex-column"> $act </ul>
    </div>
    </div>
</div>
EOF;

    }

    static function modulelinkGenerator($projet)
    {
        return "";
    }

    static function layoutGenerator($module, $_dir)
    {

        $layout = "@extends('layout.layout')
@section('title', 'Page Title')

<?php function style(){ ?>

<?php foreach (dclass\devups\Controller\Controller::$" . "cssfiles as $" . "cssfile){ ?>
<link href=\"<?= $" . "cssfile ?>\" rel=\"stylesheet\">
<?php } ?>

<?php } ?>

@section('content')
 
    @include(\"default.moduleheaderwidget\")
    <hr>

    @yield('layout_content')


        @endsection
        
<?php function script(){ ?>

<script src=\"<?= CLASSJS ?>devups.js\"></script>
<script src=\"<?= CLASSJS ?>model.js\"></script>
<script src=\"<?= CLASSJS ?>ddatatable.js\"></script>
<?php foreach (dclass\devups\Controller\Controller::$" . "jsfiles as $" . "jsfile){ ?>
<script src=\"<?= $" . "jsfile ?>\"></script>
<?php } ?>

<?php } ?>

	";

        $layoutMod = fopen($_dir . 'layout.blade.php', 'w');

        fputs($layoutMod, $layout);

        fclose($layoutMod);

        $overview = " @extends('layout')
            @section('title', 'List')
            
            @section('layout_content')
                <div class=\"row\">
                    @foreach(\$moduledata->dvups_entity as \$entity)
                        @include(\"default.entitywidget\")
                    @endforeach
                </div>
            @endsection 
            ";

        $overviewMod = fopen($_dir . 'overview.blade.php', 'w');

        fputs($overviewMod, $overview);

        fclose($overviewMod);

    }

    static function viewsGenerator($listemodule, $entity, $_dir)
    {

        $name = strtolower($entity->name);

        $index = self::buildindexdatatable($listemodule, $entity);

        //---------------------------------- $head.
        $layout = "
@extends('layout')
@section('title', 'List')

@section('layout_content')

<div class=\"row\">
        <div class=\"col-lg-12 col-md-12  stretch-card\">
            <div class=\"card\">
                <div class=\"card-header-tab card-header\">
                    <div class=\"card-header-title\">
                        <i class=\"header-icon lnr-rocket icon-gradient bg-tempting-azure\"> </i>
                        {{ $" . "title }}
                    </div>
                    <div class=\"btn-actions-pane-right\">
                        <div class=\"nav\">

                        </div>
                    </div>
                </div>
                <div class=\"card-body\">
                    <?= $" . "datatablehtml; ?>
                </div>
            </div>
        </div>
    </div>

    <div id=\"{{ strtolower($" . "entity) }}box\" class=\"swal2-container swal2-fade swal2-shown\" style=\"display:none; overflow-y: auto;\">
        <div role=\"dialog\" aria-labelledby=\"swal2-title\" aria-describedby=\"swal2-content\" class=\"swal2-modal swal2-show dv_modal\" tabindex=\"1\"
             style=\"\">
            <div class=\"main-card mb-3 card  box-container\">
                <div class=\"card-header\">Header

                    <button onclick=\"model._dismissmodal()\" type=\"button\" class=\"swal2-close\" aria-label=\"Close this dialog\" style=\"display: block;\">×</button>
                </div>
                <div class=\"card-body\"></div>
            </div>

        </div>
    </div>
        
@endsection

";

        $view = fopen($_dir . 'index.blade.php', 'w');
        fputs($view, $layout);
        fclose($view);

        //----------------------------------

    }

    static function dashboardView(){
        $admin = getadmin();
        $modules = $admin->dvups_role->collectDvups_module();
        return compact("admin", "modules");
    }

}
