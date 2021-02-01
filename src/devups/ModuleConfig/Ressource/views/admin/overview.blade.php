@extends('admin.layout')
@section('title', 'List')

@section('layout_content')
    <div class="row">
        @foreach($moduledata->dvups_entity as $entity)
            @include("default.entitywidget")
        @endforeach
    </div>
@endsection
            