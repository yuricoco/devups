<?php

class Adminv2 {

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
        $traitement = new Traitement();
        $listview = [];

        $key = 0;
        if (isset($entity->attribut[1])) {
            $key = 1;
        }

        foreach ($entity->attribut as $attribut) {
            if ($attribut->formtype == 'image') {
//                $listview[] = "'src:" . $attribut->name . "'";
                $listview[] = "\n['header' => '" . ucfirst($attribut->name) . "', 'value' => 'src:" . $attribut->name . "']";
//                        }elseif($entity->attribut[$i]->formtype == 'document'){
//                        }elseif($entity->attribut[$i]->formtype == 'document'){
//                        }elseif($entity->attribut[$i]->formtype == 'document'){
                $listview[] = "\n['header' => '" . ucfirst($attribut->name) . "', 'value' => '" . $attribut->name . "']";
            } else {
                $listview[] = "\n['header' => '" . ucfirst($attribut->name) . "', 'value' => '" . $attribut->name . "']";
//                $listview[] = "'" . $attribut->name . "'";
            }
        }

        if (!empty($entity->relation)) {
            foreach ($entity->relation as $relation) {

                if ($relation->cardinality == 'manyToMany')
                    break;

                $entitylink = $traitement->relation($listemodule, $relation->entity);
                $entrel = ucfirst(strtolower($relation->entity));
                $key = 0;
                $entitylinkattrname = "id";
                $entitylink->attribut = (array) $entitylink->attribut;
                if (isset($entitylink->attribut[1])) {
                    $key = 1;
                    $entitylinkattrname = $entitylink->attribut[$key]->name;
                }

                $listview[] = "\n['header' => '" . $entrel . "', 'value' => '" . $entrel . "." . $entitylinkattrname . "']";
            }
        }

        $index = "
        <div class=\"col-lg-12 col-md-12\">
                
                    <?= Genesis::lazyloadingUI($" . "lazyloading, [" . implode(', ', $listview) . "\n]); ?>

        </div>
			";

        $show = "
                    <div class=\"col-lg-12 col-md-12\">
                    
			<?php " . ucfirst($name) . "Form::__renderDetailWidget($" . $name . "); ?>
			
	<div class=\"form-group text-center\">
		<?php echo Genesis::actionListView(\"" . $name . "\", $" . $name . "->getId()); ?>
	</div>
	
	</div>
					";

        $new_edit = "
                    <div class=\"col-lg-12\" >

                                    <?= " . ucfirst($name) . "Form::__renderForm($" . $name . ", $" . "action_form, true); ?>

                        </div>";

        //---------------------------------- $head.
        $layout = "
@extends('layout')
@section('title', 'List')


@section('cssimport')

                <style></style>
                
@show

@section('content')

        <div class=\"row\">
                <div class=\"col-lg-12\">
                        <ol class=\"breadcrumb\">
                                <li class=\"active\">
                                        <i class=\"fa fa-dashboard\"></i> <?php echo CHEMINMODULE; ?>  > Liste 
                                </li>
                        </ol>
                </div>
                <div class=\"col-lg-12\"> <?= $" . "__navigation  ?></div>
        </div>
        <div class=\"row\">
                " . $index . "
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

@section('jsimport')
        <script src=\"<?= CLASSJS ?>model.js\"></script>
        <script src=\"<?= CLASSJS ?>ddatatable.js\"></script>
                <script></script>
@show";

        $view = fopen($_dir . 'index.blade.php', 'w');
        fputs($view, $layout);
        fclose($view);

        //----------------------------------
        $layout = "
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
                            <div class=\"col-lg-12\"><?= $" . "__navigation  ?></div>
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
                                                    <i class=\"fa fa-dashboard\"></i> <?php echo CHEMINMODULE; ?>  > Ajout 
                                            </li>
                                    </ol>
                            </div>
                            <div class=\"col-lg-12\"><?= $" . "__navigation  ?></div>
                    </div>
                    <div class=\"row\">
                                    " . $new_edit . "
                    <div>        
         
@endsection";

        $view = fopen($_dir . 'form.blade.php', 'w');
        fputs($view, $layout);
        fclose($view);
    }

}
