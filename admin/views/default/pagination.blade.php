@if (!$ll->nb_element)
    <div id="dv_pagination" class="alert alert-info"> no item founded</div>
@else

    <div id="dv_pagination" data-entity="{{$entityname}}" data-route="{{$base_url}}" style="width: 100%"
         class="row">
        <div id="pagination-notice" data-notice="{{$ll->pagination}}" class="col-lg-2 col-md-4">
            {{ t(" showing :index to :lastindex of :nbelement ",
 ["index"=>(($ll->current_page - 1) * $ll->per_page + 1),
 'lastindex'=>$ll->per_page * $ll->current_page, "nbelement"=> $ll->nb_element]) }}

        </div>

        <div class="col-lg-6 col-md-8">
            <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                <ul class="pagination">
                    @if ($ll->previous > 0)
                        <li class="paginate_button page-item previous">
                            <a class="page-link"
                               href="javascript:ddatatable.firstpage(this)"><i
                                        class="fa fa-angle-double-left"></i></a>
                        </li>
                        <li class="paginate_button page-item previous">
                            <a class="page-link"
                               href="javascript:ddatatable.previous(this)"><i
                                        class="fa fa-angle-left"></i></a>
                        </li>
                    @else
                        <li class="paginate_button page-item previous disabled"><a class="page-link" href="#"><i
                                        class="fa fa-angle-double-left"></i></a></li>
                        <li class="paginate_button page-item previous disabled"><a class="page-link" href="#"><i
                                        class="fa fa-angle-left"></i></a></li>
                    @endif

                    @if ($ll->pagination > 10 && !$ll->dynamicpagination)

                        <li class="paginate_button page-item ">
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
                        </li>
                    @else
                        @if ($ll->dynamicpagination)

                            @foreach ($ll->paginationcustom['firsts'] as $key => $page)
                                @if ($page == $ll->current_page)
                                    <li class="paginate_button page-item  active ">
                                        <a class="page-link"
                                           href="javascript:ddatatable.pagination(this, {{$page}});"
                                           data-next="{{$page}}">{{$page}}</a>
                                    </li>
                                @else
                                    <li class="paginate_button page-item ">
                                        <a class="page-link"
                                           href="javascript:ddatatable.pagination(this, {{$page}});"
                                           data-next="{{$page}}">{{$page}}</a>
                                    </li>
                                @endif
                            @endforeach

                            @if ($ll->current_page < 3 || $ll->current_page >= 7)
                                <li class="paginate_button page-item ">
                                    <a class="page-link"
                                       href="javascript:ddatatable.pagination(this, {{$ll->paginationcustom['middleleft']}});"
                                       data-next="{{$ll->paginationcustom['middleleft']}}">...</a>
                                </li>

                                @foreach ($ll->paginationcustom['middles'] as $key => $page)
                                    @if ($page == $ll->current_page)
                                        <li class="paginate_button page-item active "><a class="page-link"
                                                                                         href="javascript:ddatatable.pagination(this, {{$page}});"
                                                                                         data-next="{{$page}}">{{$page}}</a>
                                        </li>
                                    @else
                                        <li class="paginate_button page-item "><a class="page-link"
                                                                                  href="javascript:ddatatable.pagination(this, {{$page}});"
                                                                                  data-next="{{$page}}">{{$page}}</a>
                                        </li>
                                    @endif
                                @endforeach

                                @if ($ll->paginationcustom['lasts'])

                                    <li class="paginate_button page-item ">
                                        <a class="page-link"
                                           href="javascript:ddatatable.pagination(this, {{$ll->paginationcustom['middleright']}});"
                                           data-next="{{$ll->paginationcustom['middleright']}}">...</a>
                                    </li>

                                    @foreach ($ll->paginationcustom['lasts'] as $key => $page)
                                        @if ($page == $ll->current_page)
                                            <li class="paginate_button page-item active ">
                                                <a class="page-link"
                                                   href="javascript:ddatatable.pagination(this, {{$page}});"
                                                   data-next="{{$page}}">{{$page}}</a>
                                            </li>
                                        @else
                                            <li class="paginate_button page-item ">
                                                <a class="page-link"
                                                   href="javascript:ddatatable.pagination(this, {{$page}});"
                                                   data-next="{{$page}}">{{$page}}</a></li>
                                        @endif
                                    @endforeach

                                @else
                                    @for ($page = 1; $page <= $ll->pagination; $page++)
                                        @if ($page == $ll->current_page)
                                            <li class="paginate_button page-item active ">
                                                <a class="page-link"
                                                   href="javascript:ddatatable.pagination(this, {{$page}});"
                                                   data-next="{{$page}}"> {{$page}}
                                                </a>
                                            </li>
                                        @else
                                            <li class="paginate_button page-item ">
                                                <a class="page-link"
                                                   href="javascript:ddatatable.pagination(this, {{$page}});"
                                                   data-next="{{$page}}"> {{$page}} </a>
                                            </li>
                                        @endif
                                    @endfor

                                @endif

                            @endif

                        @else
                            @for ($page = 1; $page <= $ll->pagination; $page++)

                                <li class="paginate_button page-item @if ($page == $ll->current_page) active  @endif ">
                                    <a class="page-link" href="javascript:ddatatable.pagination(this,  {{$page}} );"
                                       data-next="{{$page}}">{{$page}}</a>
                                </li>

                            @endfor
                        @endif

                    @endif

                    @if ($ll->remain)
                        <li class="paginate_button page-item next">
                            <a class="page-link" href="javascript:ddatatable.next();">
                                <i class="fa fa-angle-right"></i></a>
                        </li>
                        <li class="paginate_button page-item next">
                            <a class="page-link"
                               href="javascript:ddatatable.lastpage(this,  {{$ll->pagination}} );">
                                <i class="fa fa-angle-double-right"></i></a>
                        </li>
                    @else
                        <li class="paginate_button page-item next disabled">
                            <a class="page-link" href="#">
                                <i class="fa fa-angle-right"></i></a>
                        </li>
                        <li class="paginate_button page-item next disabled">
                            <a class="page-link" href="#">
                                <i class="fa fa-angle-double-right"></i></a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        {!! $perpage !!}

    </div>
@endif