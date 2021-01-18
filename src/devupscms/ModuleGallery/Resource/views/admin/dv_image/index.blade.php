
@extends('admin.layout')
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
                            {!! Dv_imageTable::init(new Dv_image())->renderTopaction() !!}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    { $datatable->render(); !!}
                    {!! Dv_imageTable::init(new Dv_image())->buildfrontcustom()
                            ->setModel("frontcustom")
                            //->setContainer()
                            ->renderCustomBody("div", ["class"=>"row"]) !!}
                </div>
            </div>
        </div>
    </div>
{!! Dv_imageTable::init(new Dv_image())->dialogBox() !!}
        
@endsection

