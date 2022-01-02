
@extends('admin.layout')
@section('title', 'New admin')


@section('content')


    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> <?php echo CHEMINMODULE; ?>  > Liste
                </li>
            </ol>
        </div>

    </div>
    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="table-responsive">

                <div style=" width: 550px; margin: auto;" >

                    <div class="form-group">
                        <?php echo $_GET['detail']; ?>
                    </div>

                    <div class="form-group">
                        <label>name</label>
                        <?php echo $admin->getName(); ?>
                    </div>
                    <div class="form-group">
                        <label>login</label>
                        <?php echo $admin->getLogin(); ?>
                    </div>

                    <div class="form-group text-center">
                        <a href="<?= __env.'admin/'; ?>" class="btn btn-default">Return to dashboard</a>
                    </div>

                </div>

            </div>
        </div>

    </div>

@endsection