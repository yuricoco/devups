
@extends('layout')
@section('title', 'List')


@section('cssimport')

                <style></style>
                
@show

@section('content')

        <div class="row">
                <div class="col-lg-12">
                        <ol class="breadcrumb">
                                <li class="active">
                                        <i class="fa fa-dashboard"></i> <?php echo CHEMINMODULE; ?>  > Liste 
                                </li>
                        </ol>
                </div>
                <div class="col-lg-12"> <?= $__navigation  ?></div>
        </div>
        <div class="row">
                
        <div class="col-lg-12 col-md-12">
                
                    <?= Genesis::lazyloadingUI($lazyloading, [
['header' => 'Lable', 'value' => 'lable'], 
['header' => '_table', 'value' => '_table'], 
['header' => '_row', 'value' => '_row'], 
['header' => 'Lang', 'value' => 'lang'], 
['header' => 'Content', 'value' => 'content']
]); ?>

        </div>
			
        </div>
        
@endsection

@section('jsimport')

                <script></script>
@show