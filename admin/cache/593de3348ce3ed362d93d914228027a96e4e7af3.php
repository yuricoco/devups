<?php $__env->startSection('title', 'Show'); ?>


<?php $__env->startSection('content'); ?>
                
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
		<a href="index.php?path=storage/edit&id=<?php echo $storage->getId(); ?>" class="btn btn-default">Modifier</a>
		<a href="index.php?path=storage/delete&valid=oui&id=<?php echo $storage->getId(); ?>" class="btn btn-default">Supprimer</a>
	</div>
	
	</div>
					
                    </div>      
                    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>