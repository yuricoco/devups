
@extends('admin.layout')
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
			<label>Dvups_role dvups_admin</label>
                  <?php 
                  if($dvups_admin->getDvups_role() and $dvups_admin->getDvups_role()[0]->getId()) {
                      foreach ($dvups_admin->getDvups_role() as $dvups_role){ 
					echo '
                <label class="checkbox-inline">
						'.$dvups_role->getId().'
                </label>'; 
				}} ?>
		</div> 
		
			
	<div class="form-group text-center">
		<a href="index.php?path=dvups_admin/edit&id=<?php echo $dvups_admin->getId(); ?>" class="btn btn-default">Modifier</a>
		<a href="index.php?path=dvups_admin/delete&valid=oui&id=<?php echo $dvups_admin->getId(); ?>" class="btn btn-default">Supprimer</a>
	</div>
	
	</div>
					
                    </div>        
         
@endsection