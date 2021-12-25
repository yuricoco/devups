@extends('admin.layout')
@section('title', 'List')

@section('layout_content')

<h4>{{$title}}</h4>
    <br>
    <?= $datatable->render(); ?>
@endsection


