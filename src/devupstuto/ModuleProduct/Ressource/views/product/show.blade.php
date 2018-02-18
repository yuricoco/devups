
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
                            <h4>Image</h4>
                <?php echo $product->getImage()->getImage(); ?>
        </div> 
            <div class="form-group">
                            <h4>Category</h4>
                <?php echo $product->getCategory()->getName(); ?>
        </div> 
            <div class="form-group">
                            <h4>Subcategory</h4>
                <?php echo $product->getSubcategory()->getName(); ?>
        </div> 
            <div class="form-group">
                    <label>Storage product</label>
                  <?php 
                  if($product->getStorage() and $product->getStorage()[0]->getId()) {
                      foreach ($product->getStorage() as $storage){ 
					echo '
                <label class="checkbox-inline">
                            '.$storage->getTown().'
                </label>'; 
                            }} ?>
            </div> 
		<div class="form-group">
		<label>Name</label>
		<?php echo $product->getName(); ?>
	</div>
			
	<div class="form-group text-center">
		<a href="index.php?path=product/edit&id=<?php echo $product->getId(); ?>" class="btn btn-default">Modifier</a>
		<a href="index.php?path=product/delete&valid=oui&id=<?php echo $product->getId(); ?>" class="btn btn-default">Supprimer</a>
	</div>
	
	</div>
					
                    </div>      
                    
@endsection