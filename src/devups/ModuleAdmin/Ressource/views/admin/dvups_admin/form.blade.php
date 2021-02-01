@extends('layout')
@section('title', 'Form')


@section('content')

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> <?php echo CHEMINMODULE; ?> > Ajout
                </li>
            </ol>
        </div>
        <div class="col-lg-12"><?= $__navigation  ?></div>
    </div>
    <div class="row">

        <div class="col-lg-12">

            <?= Dvups_adminForm::__renderForm($dvups_admin, $action_form, true); ?>

        </div>
        <div>

@endsection