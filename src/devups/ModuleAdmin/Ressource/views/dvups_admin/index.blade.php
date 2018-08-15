
@extends('layout')
@section('title', 'List')


@section('cssimport')

                <style></style>
                
@show

@section('content')

<?php
            function callbackbtn($entity){
                return "<a class='btn btn-default' href='index.php?path=dvups_admin/resetcredential&id=".$entity->getId()."'>reset password</a>";
            };

?>
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
                <div class="table-responsive">

                 <?= \DClass\devups\Datatable::renderdata($lazyloading, [
                    ['header' => 'nom', 'value' => 'name'],
                    ['header' => 'login', 'value' => 'login'],
                        ]);
                ?>


                </div>
        </div>
			
        </div>
        
@endsection

@section('jsimport')

    <script src="<?= CLASSJS ?>model.js"></script>
    <script src="<?= CLASSJS ?>ddatatable.js"></script>
                <script></script>
@show