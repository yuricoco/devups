
@extends('layout')
@section('title', 'Show')


@section('content')
                
                    <div class="row">
                            <div class="col-lg-12">
                                    <ol class="breadcrumb">
                                            <li class="active">
                                                    <i class="fa fa-dashboard"></i> <?php echo CHEMINMODULE; ?>  > Detail 
                                            </li>
                                    </ol>
                            </div>
                            <div class="col-lg-12"><?= $__navigation  ?></div>
                    </div>
                    <div class="row">
                                            
                    <div class="col-lg-12 col-md-12">
			
			
	<div class="form-group text-center">
		<a href="index.php?path=dvups_module/edit&id=<?php echo $dvups_module->getId(); ?>" class="btn btn-default">Modifier</a>
		<a href="index.php?path=dvups_module/delete&valid=oui&id=<?php echo $dvups_module->getId(); ?>" class="btn btn-default">Supprimer</a>
	</div>
	
	</div>
					
                    </div>        
         
@endsection