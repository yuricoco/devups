<?php $__env->startSection('title', 'List'); ?>


<?php $__env->startSection('cssimport'); ?>

    <style></style>
                
<?php echo $__env->yieldSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-lg-3 col-md-6 ">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 ">
                        <h5>Manage Storage</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-6 text-right">
        <?= Genesis::top_action(Storage::class); ?>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-lg-12 col-md-12  stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                    
                
                    <?= \DClass\devups\Datatable::buildtable($lazyloading, [
['header' => 'Name', 'value' => 'name']
])
                    ->render(); ?>

			
                </div>
            </div>
        </div>
    </div>
</div>
        
<div class="modal fade" id="storagemodal" tabindex="-1" role="dialog"
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


<?php function script(){ ?>

<script src="<?= CLASSJS ?>model.js"></script>
<script src="<?= CLASSJS ?>ddatatable.js"></script>
<script src="<?= Storage::classpath('Ressource/js/storageCtrl.js') ?>"></script>

<?php } ?>
<?php $__env->startSection('jsimport'); ?>
<?php echo $__env->yieldSection(); ?> 
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>