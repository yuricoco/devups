<h3>{{$entity}}</h3>
<form action="{{__env}}admin/index.php?dfilters=on&path=export&classname={{$entity}}&{{$filters}}" method="post">
    <div class="row">
        <div class="col-lg-8">
            <div class="form-group">
                <label><input hidden name="fields" value="{{implode(',', $fields)}}"></label>
                <table class="table">
                    <tr>
                        <td><input name="allcolumns" checked type="checkbox" value="all"/> (toutes)</td>
                        <th>Colonne a exporter</th>
                    </tr>
                    @foreach($fields as $field)
                        <tr>
                            <td><input name="columns[]" type="checkbox" value="{{$field}}"/></td>
                            <td>{{$field}}</td>
                        </tr>

                    @endforeach
                </table>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Langue source</label>
                <select class="form-control" name="idlang">
                    @foreach($langs as $lang)
                        <option value="{{$lang->id}}">{{$lang->iso_code}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Options</label><br>
                {!! Form::radio("per_page", ['10'=>'Export data on first page!', "all"=>'Export all pages!'], '10') !!}
            </div>
        </div>

    </div>
    <hr>
    <button type="submit" class="btn btn-info">Export data</button>
</form>
<!-- <button data-filters="{{$filters}}" onclick="dventity.exportdata(this)" type="button" class="btn btn-info">Export data
    on first page!
</button>
<button data-filters="{{$filters}}&per_page=all" onclick="dventity.exportdata(this)" type="button" class="btn btn-info">
    Export all pages!
</button> -->

<hr>
<div id="result"></div>
<script>

    var dventity = {
        exportdata(el) {
            //model.addLoader($(el))
            window.location.href = __env + "admin/index.php?dfilters=on&path=export&classname={{$entity}}&" + $(el).data("filters")
            /*Drequest.init(__env + "admin/services.php?dfilters=on&path=export&classname={{$entity}}&"+$(el).data("filters"))
                //.toFormdata()
                .get((function (response) {
                    model.removeLoader();
                    console.log(response)
                    $("#result").html(`<a class="btn btn-primary btn-block" target="_blank" href="${response.result.download}">download the exported file</a>`)
                }))*/

        }
    }

</script>