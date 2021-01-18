
@extends('layout')
@section('title', 'List')

@section('layout_content')

<div class="row">
        <div class="col-lg-12 col-md-12  stretch-card">
            <div class="card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title">
                        <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                        {{ $title }}
                    </div>
                    <div class="btn-actions-pane-right">
                        <div class="nav">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {!! $datatablehtml; !!}
                </div>
            </div>
        </div>
    </div>
        
@endsection

