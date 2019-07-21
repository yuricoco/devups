
@extends('layout')
@section('title', 'List')

@section('layout_content')

        <div class="row">
                
        <div class="col-lg-12 col-md-12">

            <div class="card">
                <div class="card-body">
                    <?= \DClass\devups\Datatable::buildtable($lazyloading, [
['header' => 'Name', 'value' => 'name']
])->render(); ?>

        </div>
        </div>
        </div>

        </div>

@endsection
