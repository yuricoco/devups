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
                $listview[] = "'src:" . $attribut->name . "'";
//                        }elseif($entity->attribut[$i]->formtype == 'document'){
//                        }elseif($entity->attribut[$i]->formtype == 'document'){
//                        }elseif($entity->attribut[$i]->formtype == 'document'){
                $listview[] = "'" . $attribut->name . "'";
            } else {
                $listview[] = "'" . $attribut->name . "'";
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

                $listview[] = "'" . $entrel . "." . $entitylinkattrname . "'";
            }
        }

        $index = "
        <div class=\"col-lg-12 col-md-12\">
                
                    <?= Genesis::lazyloading($" . "lazyloading, [" . implode(', ', $listview) . "]); ?>

        </div>
			";

        $show = "
                    <div class=\"col-lg-12 col-md-12\">
			";
        if (!empty($entity->relation)) {
            foreach ($entity->relation as $relation) {
                $entitylink = $traitement->relation($listemodule, $relation->entity);
                $entrel = ucfirst(strtolower($relation->entity));
                $key = 0;
                $entitylinkattrname = "id";
                $entitylink->attribut = (array) $entitylink->attribut;
                if (isset($entitylink->attribut[1])) {
                    $key = 1;
                    $entitylinkattrname = $entitylink->attribut[$key]->name;
                }
                if ($relation->cardinality == 'manyToMany') {
                    $show .= "
            <div class=\"form-group\">
                    <label>" . $entrel . " " . $name . "</label>
                  <?php 
                  if($" . $name . "->get" . $entrel . "() and $" . $name . "->get" . $entrel . "()[0]->getId()) {
                      foreach ($" . $name . "->get" . $entrel . "() as $" . $relation->entity . "){ 
                                    echo '
                <label class=\"checkbox-inline\">
                                            '.$" . $relation->entity . "->get" . ucfirst($entitylinkattrname) . "().'
                </label>'; 
                            }} ?>
            </div> 
		";
                } elseif (in_array($relation->cardinality, ['oneToOne', 'manyToOne'])) {

                    $show .= "
            <div class=\"form-group\">
                            <h4>" . $entrel . "</h4>
                <?php echo $" . $name . "->get" . $entrel . "()->get" . ucfirst($entitylinkattrname) . "(); ?>
        </div> ";
                }
            }
        }
        if ($key) {
            for ($i = 1; $i < count($entity->attribut); $i++) {
                if (in_array($entity->attribut[$i]->datatype, ['date', 'datetime', 'time'])) {

                    $show .= "<div class=\"form-group\">
		<label>" . ucfirst($entity->attribut[$i]->name) . "</label>
		<?php echo $" . $name . "->get" . ucfirst($entity->attribut[$i]->name) . "()->format('d M Y'); ?>
	</div>";
                } elseif (!in_array($entity->attribut[$i]->formtype, ['document', 'image', 'music', 'video'])) {

                    $show .= "<div class=\"form-group\">
		<label>" . ucfirst($entity->attribut[$i]->name) . "</label>
		<?php echo $" . $name . "->get" . ucfirst($entity->attribut[$i]->name) . "(); ?>
	</div>";
                } else {
                    if ($entity->attribut[$i]->formtype == 'document') {
                        $show .= "
	<div class=\"form-group\">
			<label>" . ucfirst($entity->attribut[$i]->name) . "</label>
		  <a target='_blank' href='<?php echo $" . $name . "->show" . ucfirst($entity->attribut[$i]->name) . "(); ?>' >download the document</a>
	</div>
	";
                    } elseif ($entity->attribut[$i]->formtype == 'video') {
                        $show .= "
	<div class=\"form-group\">
			<label>" . ucfirst($entity->attribut[$i]->name) . "</label>
		  <video src='<?php echo $" . $name . "->show" . ucfirst($entity->attribut[$i]->name) . "(); ?>' ></video>
	</div>";
                    } elseif ($entity->attribut[$i]->formtype == 'music') {
                        $show .= "
	<div class=\"form-group\">
			<label>" . ucfirst($entity->attribut[$i]->name) . "</label>
		  <audio src='<?php echo $" . $name . "->show" . ucfirst($entity->attribut[$i]->name) . "(); ?>' ></audio>
	</div>";
                    } elseif ($entity->attribut[$i]->formtype == 'image') {
                        $show .= "
	<div class=\"form-group\">
			<label>" . ucfirst($entity->attribut[$i]->name) . "</label>
		  <img width='120' src='<?php echo $" . $name . "->show" . ucfirst($entity->attribut[$i]->name) . "(); ?>' />
	</div>";
                    }
                }
            }
        }
        $show .= "
			
	<div class=\"form-group text-center\">
		<a href=\"index.php?path=" . $name . "/edit&id=<?php echo $" . $name . "->getId(); ?>\" class=\"btn btn-default\">Modifier</a>
		<a href=\"index.php?path=" . $name . "/delete&valid=oui&id=<?php echo $" . $name . "->getId(); ?>\" class=\"btn btn-default\">Supprimer</a>
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
        
@endsection

@section('jsimport')

                <script>
    function findindatabase(){
        $.get( \"index.php?path=abonne.rest/datatable&search=\" + $(\"#search\").val(), function (response) {
                    console.log(response);
        });
    }
    
    function myFunction() {
        var input, filter, table, tr, td, i;
        input = document.getElementById(\"myInput\");
        filter = input.value.toUpperCase();
        table = document.getElementById(\"dv_table\");
        console.log(table);
        tr = table.getElementsByTagName(\"tr\");

        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName(\"td\")[1].innerHTML.toUpperCase();
            td += \" \" + tr[i].getElementsByTagName(\"td\")[2].innerHTML.toUpperCase();
//            td += \" \" + tr[i].getElementsByTagName(\"td\")[3].innerHTML.toUpperCase();
//            td += \" \" + tr[i].getElementsByTagName(\"td\")[4].innerHTML.toUpperCase();
            search(tr, td, filter, i);
            
        }
    }
    function search(tr, td, filter, i) {
        if (td.indexOf(filter) > -1) {
            tr[i].style.display = \"\";
        } else {
            tr[i].style.display = \"none\";
        }
    }
    </script>
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
