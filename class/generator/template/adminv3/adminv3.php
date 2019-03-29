<?php

class Adminv3 extends DvAdmin {

    private $traitement;

    function __construct() {
        $this->traitement = new Traitement();
    }

    static function modulelinkGenerator($projet) {
        return "";
    }

    static function layoutGenerator($module, $_dir) {

        $layout = "@extends('layout.layout')
@section('title', 'Page Title')

@section('content')
  
    <div class=\"row\">
            <div class=\"col-lg-12\">
                    <ol class=\"breadcrumb\">
                            <li class=\"active\">
                                    <i class=\"fa fa-dashboard\"></i> " . $module->name . "
                            </li>
                    </ol>
            </div>
    </div>
	<div class=\"row\">
                  ";
        foreach ($module->listentity as $entity) {
            $name = strtolower($entity->name);
            $layout .= "
                            <?php //if($" . "moi->is_anable('" . $name . "')){ ?> 
            <div class=\"col-lg-3 col-md-6\">
                            <div class=\"panel panel-primary\">
                                    <div class=\"panel-heading\">
                                            <div class=\"row\">
                                                    <div class=\"col-xs-3\">
                                                        <i class=\"fa fa-tasks fa-5x\"></i>
                                                    </div>
                                                    <div class=\"col-xs-9 \">
                                                            <h4>Gestion " . ucfirst($name) . "</h4>
                                                    </div>
                                            </div>
                                    </div>
                                    <a href=\"index.php?path=" . $name . "/index\">
                                            <div class=\"panel-footer\">
                                                    <?php 
                                                            //$" . "action = '" . $name . "';
                                                            //include RESSOURCE.'navigation.php'; 
                                                    ?>
                                                    <span class=\"pull-left\">View Details</span>
                                                    <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
                                                    <div class=\"clearfix\"></div>
                                            </div>
                                    </a>
                            </div>
                    </div>  
                <?php //} ?> 			
				";
        }

        $layout .= " 
            </div>
            
        @endsection
	";

        $layoutMod = fopen( $_dir . 'layout.blade.php', 'w');

        fputs($layoutMod, $layout);

        fclose($layoutMod);
    }

    static function viewsGenerator($listemodule, $entity, $_dir) {

        $name = strtolower($entity->name);

        $index = self::buildindexdatatable($listemodule, $entity);

        //---------------------------------- $head.
        $layout = "
@extends('layout')
@section('title', 'List')


@section('cssimport')

    <style></style>
                
@show

@section('content')

<div class=\"row\">
    <div class=\"col-lg-3 col-md-6 \">
        <div class=\"panel panel-primary\">
            <div class=\"panel-heading\">
                <div class=\"row\">
                    <div class=\"col-xs-12 \">
                        <h5>Manage " . ucfirst($name) . "</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=\"col-lg-9 col-md-6 text-right\">
        <?= Genesis::top_action(" . ucfirst($name) . "::class); ?>
    </div>
</div>
<hr>

<div class=\"row\">
    <div class=\"col-lg-12 col-md-12  stretch-card\">
        <div class=\"card\">
            <div class=\"card-body\">
                <div class=\"dataTables_wrapper container-fluid dt-bootstrap4 no-footer\">
                    " . $index . "
                </div>
            </div>
        </div>
    </div>
</div>
        
<div class=\"modal fade\" id=\"" . $name . "modal\" tabindex=\"-1\" role=\"dialog\"
     aria-labelledby=\"modallabel\">
    <div  class=\"modal-dialog\" role=\"document\">
        <div class=\"modal-content\">

            <div class=\"modal-header\">
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\"
                        aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                <h3 class=\"title\" id=\"modallabel\">Modal Label</h3>
            </div>
            <div class=\"modal-body panel generalinformation\"> </div>
            <div class=\"modal-footer\">
                <button data-dismiss=\"modal\" aria-label=\"Close\" type=\"button\" class=\"btn btn-danger\" >Close</button>
            </div>

        </div>

    </div>
</div>
        
@endsection


<?php function script(){ ?>

<script src=\"<?= CLASSJS ?>model.js\"></script>
<script src=\"<?= CLASSJS ?>ddatatable.js\"></script>
<script src=\"<?= " . ucfirst($name) . "::classpath('Ressource/js/" . $name . "Ctrl.js') ?>\"></script>

<?php } ?>
@section('jsimport')
@show ";

        $view = fopen($_dir . 'index.blade.php', 'w');
        fputs($view, $layout);
        fclose($view);

        //----------------------------------
       /* $layout = "
@extends('layout')
@section('title', 'Show')


@section('content')
                
                    <div class=\"row\">
                            <div class=\"col-lg-12\">
                                    <ol class=\"breadcrumb\">
                                            <li class=\"active\">
                                                    <i class=\"fa fa-dashboard\"></i> <?php echo CHEMINMODULE; ?>  > Detail 
                                            </li>
                                    </ol>
                            </div>
    <div class=\"col-lg-12\">
        <div class=\"row\">
            <div class=\"col-lg-3 \">
                <div class=\"panel panel-primary\">
                    <div class=\"panel-heading\">
                        <div class=\"row\">
                            <div class=\"col-xs-12 \">
                                <h5>Detail " . ucfirst($name) . "</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=\" col-md-offset-6 col-lg-3\">
                <?= Genesis::top_action(" . ucfirst($name) . "::class); ?>
            </div>
        </div>
    </div>
                    </div>
                    <div class=\"row\">
                                            " . $show . "
                    </div>        
         
@endsection";

        $view = fopen($_dir . 'show.blade.php', 'w');
        fputs($view, $layout);
        fclose($view);

        //----------------------------------
        $layout = "
@extends('layout')
@section('title', 'Form')


@section('content')

                    <div class=\"row\">
                            <div class=\"col-lg-12\">
                                    <ol class=\"breadcrumb\">
                                            <li class=\"active\">
                                                    <i class=\"fa fa-dashboard\"></i> <?php echo CHEMINMODULE; ?>  > Formula 
                                            </li>
                                    </ol>
                            </div>
    <div class=\"col-lg-12\">
        <div class=\"row\">
            <div class=\"col-lg-3 \">
                <div class=\"panel panel-primary\">
                    <div class=\"panel-heading\">
                        <div class=\"row\">
                            <div class=\"col-xs-12 \">
                                <h5>Formula " . ucfirst($name) . "</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=\" col-md-offset-6 col-lg-3\">
                <?= Genesis::top_action(" . ucfirst($name) . "::class); ?>
            </div>
        </div>
    </div>
                    </div>
                    <div class=\"row\">
                                    " . $new_edit . "
                    </div>      
         
@endsection";

        $view = fopen($_dir . 'form.blade.php', 'w');
        fputs($view, $layout);
        fclose($view);*/

    }

}
