@if (!$this->listentity)
return '
<div id="dv_pagination" class="alert alert-info"> no item founded</div>
@else
    <div id=\"dv_pagination\" class=\"col-lg-12\"></div>";

    $html = '
    <div id="dv_pagination" data-entity="' . $this->class . '" data-route="' . $this->base_url . '" style="width: 100%"
         class="row">
        <div id="pagination-notice" data-notice="' . $this->pagination . '" class="col-lg-2 col-md-4">
            Showing ' . (($this->current_page - 1) * $this->per_page + 1) . ' to ' . $this->per_page *
            $this->current_page . ' of ' . $this->nb_element . '
        </div>


        <div class="col-lg-6 col-md-8">
            <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                <ul class="pagination">
                    @if ($this->previous > 0)
                    <li class="paginate_button page-item previous"><a class="page-link"
                                                                      href="javascript:ddatatable.firstpage(this)"><i
                                    class="fa fa-angle-double-left"></i></a></li>
                    <li class="paginate_button page-item previous"><a class="page-link"
                                                                      href="javascript:ddatatable.previous(this)"><i
                                    class="fa fa-angle-left"></i></a></li>
                    }//' . $url . '&next=' . $previous . '&per_page=' . $per_page . '
                    @else 
                    <li class="paginate_button page-item previous disabled"><a class="page-link" href="#"><i
                                    class="fa fa-angle-double-left"></i></a></li>
                    <li class="paginate_button page-item previous disabled"><a class="page-link" href="#"><i
                                    class="fa fa-angle-left"></i></a></li>

                    }

                    @if ($this->pagination > 10 && !$this->dynamicpagination)
                    @for ($page = 1; $page <= $this->pagination; $page++)
                    @if ($page == $this->current_page)

                    <option selected value="{{$page}}">{{$page}}</option>
                     @else
                    <option value="{{$page}}">{{$page}}</option>
                    @endif
                    @endfor
                    <select class=" paginate_button page-item" onchange="ddatatable.pagination(this, this.value)">
                        {{$options}}
                    </select>
                     @else
                        @if ($this->dynamicpagination)

                        @foreach ($this->paginationcustom['firsts'] as $key => $page)
                        @if ($page == $this->current_page)
                        <li class="paginate_button page-item  active "><a class="page-link"
                                                                          href="javascript:ddatatable.pagination(this, {{$page}});"
                                                                          data-next="{{$page}}">{{$page}}</a>
                        </li>
                        } @else 
                        <li class="paginate_button page-item "><a class="page-link"
                                                                  href="javascript:ddatatable.pagination(this, {{$page}});"
                                                                  data-next="{{$page}}">{{$page}}</a></li>
                        @endif
                        @endforeach

                        @if ($this->current_page < 3 || $this->current_page >= 7)
                            <li class="paginate_button page-item "><a class="page-link"
                                                                      href="javascript:ddatatable.pagination(this, ' . $this->paginationcustom['middleleft'] . ');"
                                                                      data-next="' . $this->paginationcustom['middleleft'] . '">...</a>
                            </li>

                            @foreach ($this->paginationcustom['middles'] as $key => $page)
                            @if ($page == $this->current_page)
                            <li class="paginate_button page-item active "><a class="page-link"
                                                                             href="javascript:ddatatable.pagination(this, {{$page}});"
                                                                             data-next="{{$page}}">{{$page}}</a>
                            </li>
                            @else
                            <li class="paginate_button page-item "><a class="page-link"
                                                                      href="javascript:ddatatable.pagination(this, {{$page}});"
                                                                      data-next="{{$page}}">{{$page}}</a></li>
                            @endif
                            @endforeach

                            @if ($this->paginationcustom['lasts'])

                            <li class="paginate_button page-item ">
                                <a class="page-link"
                                   href="javascript:ddatatable.pagination(this, ' . $this->paginationcustom['middleright'] . ');"
                                   data-next="' . $this->paginationcustom['middleright'] . '">...</a>
                            </li>

                            @foreach ($this->paginationcustom['lasts'] as $key => $page)
                            @if ($page == $this->current_page)
                            <li class="paginate_button page-item active ">
                                <a class="page-link"
                                   href="javascript:ddatatable.pagination(this, {{$page}});"
                                   data-next="{{$page}}">{{$page}}</a>
                            </li>
                            } @else 
                            <li class="paginate_button page-item ">
                                <a class="page-link"
                                   href="javascript:ddatatable.pagination(this, {{$page}});"
                                   data-next="{{$page}}">{{$page}}</a></li>
                            @endif
                            @endforeach

                            }

                            } @else
                                @for ($page = 1; $page <= $this->pagination; $page++)
                                @if ($page == $this->current_page)
                                <li class="paginate_button page-item active ">
                                    <a class="page-link"
                                       href="javascript:ddatatable.pagination(this, {{$page}});"
                                       data-next="{{$page}}">' . {{$page}} .
                                    </a>
                                </li>
                                } @else 
                                <li class="paginate_button page-item ">
                                    <a class="page-link"
                                       href="javascript:ddatatable.pagination(this, {{$page}});"
                                       data-next="{{$page}}">' . {{$page}} . '</a>
                                </li>
                                @endif
                                @endfor

                                @if ($this->remain)
                                <li class="paginate_button page-item next">
                                    <a class="page-link" href="javascript:ddatatable.next();">
                                        <i class="fa fa-angle-right"></i></a>
                                </li>
                                <li class="paginate_button page-item next">
                                    <a class="page-link"
                                       href="javascript:ddatatable.lastpage(this, ' . {{$this->pagination}} . ');">
                                        <i class="fa fa-angle-double-right"></i></a></li>
                                } @else 
                                <li class="paginate_button page-item next disabled">
                                    <a class="page-link" href="#">
                                        <i class="fa fa-angle-right"></i></a>
                                </li>
                                <li class="paginate_button page-item next disabled">
                                    <a class="page-link" href="#">
                                        <i class="fa fa-angle-double-right"></i></a>
                                </li>
                                @endif
                            @endif

                </ul>
            </div>
        </div>
        {!! $this->perpagebuilder() !!}

    </div>

@endif