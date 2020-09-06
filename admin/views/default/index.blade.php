@extends('layout')
@section('title', 'List')

@section('layout_content')

    <div class="row">
        <div class="col-lg-12 col-md-12  stretch-card">
            <div class="card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title">
                        <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                        {{$title}}
                    </div>
                    <div class="btn-actions-pane-right">
                        <div class="nav">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?= $datatable->render(); ?>
                </div>
            </div>
        </div>
    </div>

    <div id="{{ strtolower($entitytarget) }}box" class="swal2-container swal2-fade swal2-shown" style="display:none; overflow-y: auto;">
        <div role="dialog" aria-labelledby="swal2-title" aria-describedby="swal2-content" class="swal2-modal swal2-show dv_modal" tabindex="1"
             style="">
            <div class="main-card mb-3 card  box-container">
                <div class="card-header">.

                    <button onclick="model._dismissmodal()" type="button" class="swal2-close" aria-label="Close this dialog" style="display: block;">×</button>
                </div>
                <div class="card-body"></div>
            </div>

        </div>
    </div>

@endsection


