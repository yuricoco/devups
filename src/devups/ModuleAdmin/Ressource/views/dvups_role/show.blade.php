
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
			
		<div class="form-group">
			<label>Dvups_right dvups_role</label>
                  <?php 
                  if($dvups_role->getDvups_right() and $dvups_role->getDvups_right()[0]->getId()) {
                      foreach ($dvups_role->getDvups_right() as $dvups_right){ 
					echo '
                <label class="checkbox-inline">
						'.$dvups_right->getId().'
                </label>'; 
				}} ?>
		</div> 
		
		<div class="form-group">
			<label>Dvups_module dvups_role</label>
                  <?php 
                  if($dvups_role->getDvups_module() and $dvups_role->getDvups_module()[0]->getId()) {
                      foreach ($dvups_role->getDvups_module() as $dvups_module){ 
					echo '
                <label class="checkbox-inline">
						'.$dvups_module->getId().'
                </label>'; 
				}} ?>
		</div> 
		
		<div class="form-group">
			<label>Dvups_entity dvups_role</label>
                  <?php 
                  if($dvups_role->getDvups_entity() and $dvups_role->getDvups_entity()[0]->getId()) {
                      foreach ($dvups_role->getDvups_entity() as $dvups_entity){ 
					echo '
                <label class="checkbox-inline">
						'.$dvups_entity->getId().'
                </label>'; 
				}} ?>
		</div> 
		
			
	<div class="form-group text-center">
		<a href="index.php?path=dvups_role/edit&id=<?php echo $dvups_role->getId(); ?>" class="btn btn-default">Modifier</a>
		<a href="index.php?path=dvups_role/delete&valid=oui&id=<?php echo $dvups_role->getId(); ?>" class="btn btn-default">Supprimer</a>
	</div>
	
	</div>
					
                    </div>        
         
@endsection