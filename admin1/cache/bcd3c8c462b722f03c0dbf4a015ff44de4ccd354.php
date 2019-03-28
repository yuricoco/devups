<?php $__env->startSection('title', 'List'); ?>


<?php $__env->startSection('cssimport'); ?>

    <style></style>

<?php echo $__env->yieldSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> <?php echo CHEMINMODULE; ?> > Liste
                </li>
            </ol>
        </div>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12 ">
                                    <h5>Manage Module</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="float: right; margin-right: 30px;" class="panel">
                    <?= Genesis::top_action(Dvups_module::class); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-12 col-md-12">

            <?= \DClass\devups\Datatable::buildtable($lazyloading, [
                ['header' => 'Name', 'value' => 'name'],
                ['header' => 'Label', 'value' => 'label', 'get' => 'labelform']
            ])->render(); ?>

        </div>

    </div>

    <div class="modal fade" id="dvups_modulemodal" tabindex="-1" role="dialog"
         aria-labelledby="modallabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="title" id="modallabel">Modal Label</h3>
                </div>
                <div class="modal-body panel generalinformation"></div>
                <div class="modal-footer">
                    <button data-dismiss="modal" aria-label="Close" type="button" class="btn btn-danger">Close</button>
                </div>

            </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsimport'); ?>
    <script src="<?= CLASSJS ?>model.js"></script>
    <script src="<?= CLASSJS ?>ddatatable.js"></script>
    <script>
        var dom = null;

        function updatelabel(id) {
            var label = $("#input-" + id).val();
            dom.find("span").html(label);
            console.log(id, label);

            $.get("services.php?path=dvups_module.updatelabel&id=" + id, {
                label: label
            }, function (response) {
                console.log(response);

                dom.next().hide();
                dom.show();
            });
        }

        function cancelupdate() {
            dom.next().show();
            dom.hide();
        }

        function editlabel($this) {
            dom = $($this).parent();
            dom.next().show();
            dom.hide();
        }
    </script>
<?php echo $__env->yieldSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>