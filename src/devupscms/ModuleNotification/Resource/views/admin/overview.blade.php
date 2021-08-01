@extends('admin.layout')
@section('title', 'List')

@section('layout_content')
    <div class="row">

    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6  stretch-card">
            <div class="card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title">
                        <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                        @tt('Notification type configuration ')
                    </div>
                    <div class="btn-actions-pane-right">
                        <div class="nav">{!! $notificationttypeable->renderTopaction() !!}</div>
                    </div>
                </div>
                <div class="card-body">
                    {!!
                        $notificationttypeable->buildconfigtable()
                            ->setModel("config")
                            ->render()
                    !!}
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6  stretch-card">
            <div class="card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title">
                        <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                        @tt('Notification')
                    </div>
                    <div class="btn-actions-pane-right">
                        <div class="nav"></div>
                    </div>
                </div>
                <div class="card-body">
                    {!!
                        $notificationtable->buildconfigtable()
                            ->setModel("config")
                            ->render()
                    !!}
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>
@endsection
            