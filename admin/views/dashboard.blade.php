@extends('layout.layout')
@section('title', 'Page Title')


@section('content')

        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-car icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Analytics Dashboard
                        <div class="page-title-subheading">This is an example dashboard created using build-in elements and components.
                        </div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <button type="button" data-toggle="tooltip" title="Example Tooltip" data-placement="bottom" class="btn-shadow mr-3 btn btn-dark">
                        <i class="fa fa-star"></i>
                    </button>
                </div>
            </div>
        </div>

        @foreach($modules as $module)
            <h3><i class="{{$module->getFavicon()}}"></i>
               {{$module->getLabel()}}</h3>
            <hr>
        <div class="row">
            @ foreach($admin->dvups_role->collectDvups_entityOfModule($module) as $entity)
                @ include("default.entitywidget")
            @ endforeach
        </div>
        @endforeach
@endsection
