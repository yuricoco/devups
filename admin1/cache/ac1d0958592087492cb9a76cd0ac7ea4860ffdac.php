<?php $__env->startSection('title', 'Page Title'); ?>

<?php $__env->startSection('content'); ?>
  
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> <?php echo CHEMINMODULE; ?>
            </li>
        </ol>
    </div>
</div>
<div class="row">

</div>

        <?php $__env->stopSection(); ?>
    
<?php echo $__env->make('layout.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>