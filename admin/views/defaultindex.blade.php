
@extends('layout.layout')
@section('title', 'List')

<?php function style(){ ?>

<?php foreach (Controller::$cssfiles as $cssfile){ ?>
<link href="<?= $cssfile ?>" rel="stylesheet">
<?php } ?>

<?php } ?>

@section('content')

    <div class="row">
        <div class="col-lg-3 col-md-6 ">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 ">
                            <h5>{{$title}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-6 text-right">
            <?= Genesis::top_action($entity); ?>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-lg-12 col-md-12">

            <div class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">


                <?= \DClass\devups\Datatable::buildtable($lazyloading, $datatablemodel)->render(); ?>


            </div>
        </div>
    </div>

    <div class="modal fade" id="{{strtolower($entity)}}modal" tabindex="-1" role="dialog"
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

@endsection

<?php function script(){ ?>

<script src="<?= CLASSJS ?>model.js"></script>
<script src="<?= CLASSJS ?>ddatatable.js"></script>
<?php foreach (Controller::$jsfiles as $jsfile){ ?>
<script src="<?= $jsfile ?>"></script>
<?php } ?>

<?php } ?>

@section('jsimport')
@show 