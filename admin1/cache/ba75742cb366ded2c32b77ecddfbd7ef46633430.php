<?php $__env->startSection('title', 'List'); ?>


<?php $__env->startSection('cssimport'); ?>

                <style></style>
                
<?php echo $__env->yieldSection(); ?>

<?php $__env->startSection('content'); ?>

        <div class="row">
                <div class="col-lg-12">
                        <ol class="breadcrumb">
                                <li class="active">
                                        <i class="fa fa-dashboard"></i> <?php echo CHEMINMODULE; ?>  > Liste 
                                </li>
                        </ol>
                </div>
                <div class="col-lg-12"> <?= $__navigation  ?></div>
        </div>
        <div class="row">
                
        <div class="col-lg-12 col-md-12">
                
                    <?= \DClass\devups\Datatable::renderdata($lazyloading, [
['header' => 'Ref', 'value' => 'ref'],
['header' => '_table', 'value' => '_table'], 
['header' => '_row', 'value' => '_row'],
['header' => '_column', 'value' => '_column']
]); ?>

        </div>
			
        </div>
        
        <div class="modal fade" id="dvups_langmodal" tabindex="-1" role="dialog"
             aria-labelledby="modallabel">
            <div  class="modal-dialog" role="document">
                <div class="modal-content">
        
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="title" id="modallabel">Modal Label</h3>
                    </div>
                    <div class="modal-body panel generalinformation"> </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" aria-label="Close" type="button" class="btn btn-danger" >Close</button>
                    </div>
        
                </div>
        
            </div>
        </div>
        
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsimport'); ?>
        <script src="<?= CLASSJS ?>model.js"></script>
        <script src="<?= CLASSJS ?>ddatatable.js"></script>
                <script></script>
<?php echo $__env->yieldSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>