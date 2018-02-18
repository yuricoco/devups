
@extends('layout')
@section('title', 'List')


@section('cssimport')

                <style></style>
                
@show

@section('content')

<?php
            $callbackbtn = function($entity){
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

                 <?=
                Genesis::lazyloadingUI($lazyloading, [
                    ['header' => 'nom', 'value' => 'name'],
                    ['header' => 'login', 'value' => 'login'],
                        ], $callbackbtn);
                ?>


                </div>
        </div>
			
        </div>
        
@endsection

@section('jsimport')

                <script></script>
@show