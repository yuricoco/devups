@if (!$ll->nb_element)
    <div id="dv_pagination" class="alert alert-info text-center"> @tt("no item founded")</div>
@else

    <div id="dv_pagination" data-entity="{{$entityname}}" data-route="{{$base_url}}" style="width: 100%"
         class="row">
        <div id="pagination-notice" data-notice="{{$ll->pagination}}" class="col-lg-2 col-md-4">
            {{ t(" showing :index to :lastindex of :nbelement ",
 ["index"=>(($ll->current_page - 1) * $ll->per_page + 1),
 'lastindex'=>$ll->per_page * $ll->current_page, "nbelement"=> $ll->nb_element]) }}

        </div>

        <div class="col-lg-6 col-md-8">
            <div class="btn-group-sm" role="group" aria-label="Basic example">
                @if ($ll->previous > 0)
                    <button onclick="ddatatable.firstpage(this)" type="button" class="btn btn-outline-secondary">
                        <i class="fa fa-angle-double-left"></i>
                    </button>
                    <button onclick="ddatatable.previous(this)" type="button" class="btn btn-outline-secondary">
                        <i class="fa fa-angle-left"></i>
                    </button>
                @else
                    <button disabled type="button" class="btn ">
                        <i class="fa fa-angle-double-left"></i>
                    </button>
                    <button disabled type="button" class="btn ">
                        <i class="fa fa-angle-left"></i>
                    </button>
                @endif

                @if ($ll->pagination > 10)
                    @if(!$ll->dynamicpagination)

                        <span class="paginate_button page-item ">
                            <select class=" form-control"
                                    onchange="ddatatable.pagination(this, this.value)">
                                @for ($page = 1; $page <= $ll->pagination; $page++)
                                    @if ($page == $ll->current_page)

                                        <option selected value="{{$page}}">{{$page}}</option>
                                    @else
                                        <option value="{{$page}}">{{$page}}</option>
                                    @endif
                                @endfor
                            </select>
                        </span>
                    @else

                        @foreach ($ll->paginationcustom['firsts'] as $key => $page)
                            @if ($page == $ll->current_page)
                                <button onclick="ddatatable.pagination(this, {{$page}})" data-next="{{$page}}"
                                        type="button" class="btn btn-outline-secondary active">{{$page}}</button>
                            @else
                                <button onclick="ddatatable.pagination(this, {{$page}})" data-next="{{$page}}"
                                        type="button" class="btn btn-outline-secondary">{{$page}}</button>
                            @endif
                        @endforeach

                        @if ($ll->current_page < 3 || $ll->current_page >= 7)
                            <button onclick="ddatatable.pagination(this, {{$ll->paginationcustom['middleleft']}})"
                                    data-next="{{$ll->paginationcustom['middleleft']}}"
                                    type="button" class="btn btn-outline-secondary"> ...
                            </button>
                            @foreach ($ll->paginationcustom['middles'] as $key => $page)
                                @if ($page == $ll->current_page)
                                    <button onclick="ddatatable.pagination(this, {{$page}})" data-next="{{$page}}"
                                            type="button"
                                            class="btn btn-outline-secondary active">{{$page}}</button>
                                @else
                                    <button onclick="ddatatable.pagination(this, {{$page}})" data-next="{{$page}}"
                                            type="button" class="btn btn-outline-secondary">{{$page}}</button>
                                @endif
                            @endforeach

                            @if ($ll->paginationcustom['lasts'])
                                <button onclick="ddatatable.pagination(this, {{$ll->paginationcustom['middleright']}})"
                                        data-next="{{$ll->paginationcustom['middleright']}}"
                                        type="button" class="btn btn-outline-secondary"> ...
                                </button>
                                @foreach ($ll->paginationcustom['lasts'] as $key => $page)
                                    @if ($page == $ll->current_page)
                                        <button onclick="ddatatable.pagination(this, {{$page}})"
                                                data-next="{{$page}}"
                                                type="button"
                                                class="btn btn-outline-secondary active">{{$page}}</button>
                                    @else
                                        <button onclick="ddatatable.pagination(this, {{$page}})"
                                                data-next="{{$page}}"
                                                type="button" class="btn btn-outline-secondary">{{$page}}</button>
                                    @endif
                                @endforeach

                            @else
                                @for ($page = 1; $page <= $ll->pagination; $page++)
                                    @if ($page == $ll->current_page)
                                        <button onclick="ddatatable.pagination(this, {{$page}})"
                                                data-next="{{$page}}"
                                                type="button"
                                                class="btn btn-outline-secondary active">{{$page}}</button>
                                    @else
                                        <button onclick="ddatatable.pagination(this, {{$page}})"
                                                data-next="{{$page}}"
                                                type="button" class="btn btn-outline-secondary">{{$page}}</button>
                                    @endif
                                @endfor

                            @endif

                        @endif
                    @endif
                @else
                    @for ($page = 1; $page <= $ll->pagination; $page++)
                        <button onclick="ddatatable.pagination(this, {{$page}})" data-next="{{$page}}"
                                type="button"
                                class="btn @if ($page == $ll->current_page) btn-primary @else  btn-outline-secondary @endif btn-sm">{{$page}}</button>

                    @endfor

                @endif


                @if ($ll->remain)
                    <button onclick="ddatatable.next(this);" type="button" class="btn btn-outline-secondary">
                        <i class="fa fa-angle-right"></i>
                    </button>
                    <button onclick="ddatatable.lastpage(this,  {{$ll->pagination}} )" type="button"
                            class="btn btn-outline-secondary">
                        <i class="fa fa-angle-double-right"></i>
                    </button>
                @else
                    <button disabled type="button" class="btn">
                        <i class="fa fa-angle-right"></i>
                    </button>
                    <button disabled type="button" class="btn ">
                        <i class="fa fa-angle-double-right"></i>
                    </button>
                @endif
            </div>
        </div>

        {!! $perpage !!}

    </div>
@endif