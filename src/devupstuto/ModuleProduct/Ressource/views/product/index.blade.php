
@extends('layout')
@section('title', 'List')


@section('cssimport')

<style></style>

@show

@section('content')

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> <?php echo CHEMINMODULE; ?>  > Liste 
            </li>
        </ol>
    </div>
    <div class="col-lg-12"> <?= $__navigation ?>
        <div class="input-group custom-search-form">
            <button onclick="model._new()" class="btn btn-default" data-toggle="modal" data-target="#productmodal" type="button">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-lg-12 col-md-12">

        <?=
        Genesis::lazyloadingUI($lazyloading, [
            ['header' => 'Name', 'value' => 'name'],
            ['header' => 'Description', 'value' => 'description'],
            ['header' => 'Image', 'value' => 'src:Image.image'],
            ['header' => 'Category', 'value' => 'Category.name'],
            ['header' => 'Subcategory', 'value' => 'Subcategory.name']
        ]);
        ?>

    </div>

</div>

<div class="modal fade" id="productmodal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
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

@section('jsimport')
        <script src="<?= CLASSJS ?>model.js"></script>
        <script src="<?= CLASSJS ?>ddatatable.js"></script>
        <!--script src="Ressource/js/product.js"></script-->
@show