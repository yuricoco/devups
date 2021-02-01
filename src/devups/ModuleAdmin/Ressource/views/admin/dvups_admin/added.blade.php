
@extends('admin.layout')
@section('title', 'List')

@section('layout_content')


<div class="row">
</div>
<div class="row">

    <div class="col-lg-12 col-md-12">
        <div class="card">

            <div style=" width: 550px; margin: auto;" >

                <div class="form-group">
                    <label>Login</label>
                    <?= Request::get('login'); ?>
                </div>

                <div class="form-group">
                    <label>Mot de passe</label>
                    <?= Request::get('password'); ?>
                </div>

                <div class="form-group text-center">
                    <a href="<?= Dvups_admin::classpath().'dvups-admin/index'; ?>" class="btn btn-default">Return</a>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection
