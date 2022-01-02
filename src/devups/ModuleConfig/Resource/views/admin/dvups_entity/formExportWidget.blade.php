{{$entity}}

<hr>
<button data-filters="{{$filters}}" onclick="dventity.exportdata(this)" type="button" class="btn btn-info">Export data on first page!</button>
<button data-filters="{{$filters}}&per_page=all" onclick="dventity.exportdata(this)" type="button" class="btn btn-info">Export all pages!</button>
<hr>
<div id="result"></div>
<script>

    var dventity = {
        exportdata (el){
            model.addLoader($(el))
            Drequest.init(__env + "admin/services.php?dfilters=on&path=export&classname={{$entity}}&"+$(el).data("filters"))
                //.toFormdata()
                .get((function (response) {
                    model.removeLoader();
                    console.log(response)
                    $("#result").html(`<a class="btn btn-primary btn-block" target="_blank" href="${response.result.download}">download the exported file</a>`)
                }))

        }
    }

</script>