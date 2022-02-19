
<div id="dv_{{$this->class}}_table" class="dv_datatable_container dt-bootstrap4 card" >
    <div class="  {{$this->responsive}}">
        <table id="dv_table" {{$lang}}
                data-perpage="{{$this->per_page}}"
               data-filterparam="{{$filterParam}}"
               data-route="{{$this->base_url}}"
               data-entity="{{$this->class}}"
               class="dv_datatable {{$this->table_class}}" >
        <thead>{{$theader['th']}}{{$theader['thf']}}</thead>
        <tbody>{{$tbody}}</tbody>
        <tfoot>{{$newrows }}</tfoot>
        </table>
    </div>
    <div class="card-footer">{{$this->paginationbuilder()}}</div>
</div>
