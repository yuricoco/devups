@extends('admin.layout')
@section('title', 'List')

@section('layout_content')
    <div class="row">
        @foreach($moduledata->dvups_entity as $entity)
            @include("default.entitywidget")
        @endforeach
    </div>
    <div class="row">
        <div class="col-lg-6">
            {!! $datatablemodule->render() !!}
        </div>
        <div class="col-lg-6">
            {!! $datatableentity->render() !!}
        </div>
    </div>
@endsection
            