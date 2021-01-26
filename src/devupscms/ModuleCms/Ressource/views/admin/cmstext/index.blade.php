@extends('admin.layout')
@section('title', 'List')


@section('cssimport')

    <style></style>

@show

@section('content')

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
                <div class="col-lg-3 ">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12 ">
                                    <h5>Manage Cmstext</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-offset-6 col-lg-3">
                    <?= Genesis::top_action(Cmstext::class, true); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-12 col-md-12">

            <?= \DClass\devups\Datatable::buildtable($lazyloading, [
                ['header' => 'Titre', 'value' => 'titre'],
                ['header' => 'Url', 'value' => 'reference'],
                ['header' => 'Content', 'value' => 'sommary'],
                ['header' => 'Lang', 'value' => 'lang'],
                ['header' => 'Creationdate', 'value' => 'creationdate']
            ])
                ->render(); ?>

        </div>

    </div>

    <div class="modal fade" id="cmstextmodal" tabindex="-1" role="dialog"
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

@endsection


<?php function script(){ ?>

<script src="<?= CLASSJS ?>model.js"></script>
<script src="<?= CLASSJS ?>ddatatable.js"></script>
<script src="Ressource/js/cmstextCtrl.js"></script>

<?php } ?>
@section('jsimport')
@show 
