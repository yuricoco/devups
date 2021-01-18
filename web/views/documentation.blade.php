@extends('app')
@section('content')

    <div id="container">
        <div class="container">

            <!-- Breadcrumb Start-->
            <ul class="breadcrumb">
                <li><a href="{{__env  }}"><i class="fa fa-home"></i></a></li>
                <li><a href="#">@tt('profile')</a></li>
            </ul>
            <!-- Breadcrumb End-->
            <!-- customer content -->
            <div class="customer-content module">
                <div class="row">

                    <div class="col-lg-3 small-12 columns">

                        <h2><?= tt("menu.quicklist") ?></h2>

                        <div class="widget-content">

                            <ul class="list-group">
                                @foreach(Tree_item::getmainmenu("documentation") as $menu)

                                    <li class="list-group @if ($menu->getSlug() == Request::get("path")) active @endif ">
                                        <a href="{{route("documentation/".$menu->getSlug())}}">
                                            {!! $menu->getName() !!}</a>

                                        @if($children = $menu->collectChildren())
                                            <ul>
                                                @foreach($children as $child)
                                                    <li><a class="page-scroll"
                                                           href="{{route($child->getSlug())}}">{{$child->getName()}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>

                        </div><!-- widget content /-->

                    </div><!-- left column /-->

                    <div class="col-lg-9 small-12 columns" id="zone">
                        @if($cms)
                            {!! $cms->getContent() !!}
                        @endif
                    </div><!-- right ends /-->


                </div><!-- Row /-->
            </div><!-- customer content /-->
        </div><!-- customer content /-->
    </div><!-- customer content /-->

@endsection
