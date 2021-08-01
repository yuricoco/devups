@extends('admin.layout')
@section('title', 'List')

@section('layout_content')
    <div class="row">
        <div class="col-lg-5">
            {!! StatusTable::init(new Status())->buildindextable()->render() !!}
        </div>
        <div class="col-lg-7">
            {!! Status_entityTable::init(new Status_entity())->buildindextable()->render() !!}
        </div>
    </div>
@endsection
            