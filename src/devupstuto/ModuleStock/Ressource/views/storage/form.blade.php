
@extends('layout')
@section('title', 'Form')


@section('content')

                    <div class="row">
                            <div class="col-lg-12">
                                    <ol class="breadcrumb">
                                            <li class="active">
                                                    <i class="fa fa-dashboard"></i> <?= CHEMINMODULE; ?>  > Ajout 
                                            </li>
                                    </ol>
                            </div>
                            <div class="col-lg-12"><?= $__navigation  ?></div>
                    </div>
                    <div class="row">
                                    
			<div class="col-lg-12" >

                                    <?= StorageForm::__renderForm($storage, $action_form, true); ?>

                        </div>
                    <div>        
                    
        @endsection