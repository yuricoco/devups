
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
                            <h4>Category</h4>
                <?php echo $subcategory->getCategory()->getName(); ?>
        </div> 
			
	<div class="form-group text-center">
		<a href="index.php?path=subcategory/edit&id=<?php echo $subcategory->getId(); ?>" class="btn btn-default">Modifier</a>
		<a href="index.php?path=subcategory/delete&valid=oui&id=<?php echo $subcategory->getId(); ?>" class="btn btn-default">Supprimer</a>
	</div>
	
	</div>
					
                    </div>      
                    
@endsection