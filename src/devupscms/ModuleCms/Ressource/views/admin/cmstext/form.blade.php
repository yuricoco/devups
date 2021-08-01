@extends('admin.layout')
@section('title', 'List')


@section('cssimport')

    <style></style>

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-9 col-md-12  stretch-card">
            <div class="card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title">
                        <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                        Formulaire
                    </div>
                    <div class="btn-actions-pane-right">

                    </div>
                </div>
                <div class="card-body">
                    @include("admin.cmstext.formWidget")
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-12  stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! ImagecmsTable::init()->buildindextable()->render() !!}
                </div>
            </div>
        </div>
    </div>

    <div id="commonbox" class="swal2-container swal2-fade swal2-shown" style="display:none; overflow-y: auto;">
        <div role="dialog" aria-labelledby="swal2-title" aria-describedby="swal2-content"
             class="swal2-modal swal2-show dv_modal" tabindex="1"
             style="">
            <div class="main-card mb-3 card  box-container">
                <div class="card-header">.

                    <button onclick="model._dismissmodal()" type="button" class="swal2-close"
                            aria-label="Close this dialog" style="display: block;">×
                    </button>
                </div>
                <div class="card-body"></div>
            </div>

        </div>
    </div>
@endsection

@section('jsimport')

    <?= Form::addDformjs() ?>
    {!! Form::addjs(__admin.'plugins/tinymce.min') !!}
    <?= Form::addjs(Cmstext::classpath('Ressource/js/cmstextForm')) ?>

@endsection
