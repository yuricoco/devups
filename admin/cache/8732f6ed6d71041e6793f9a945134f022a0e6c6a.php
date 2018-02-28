<?php $__env->startSection('title', 'Form'); ?>


<?php $__env->startSection('content'); ?>

                    <div class="row">
                            <div class="col-lg-12">
                                    <ol class="breadcrumb">
                                            <li class="active">
                                                    <i class="fa fa-dashboard"></i> <?php echo CHEMINMODULE; ?>  > Ajout 
                                            </li>
                                    </ol>
                            </div>
                            <div class="col-lg-12"><?= $__navigation  ?></div>
                    </div>
                    <div class="row">
                                    
			<div class="col-lg-12" >

                                    <?= Dvups_roleForm::__renderForm($dvups_role, $action_form, true); ?>

                        </div>
                    <div>        
         
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>