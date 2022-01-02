{{$entity}}
<hr>
<div class="form-group">
    <label>Coller un contenu csv</label>
    <textarea id="contentcsv" class="form-control"></textarea>
</div>
<div class="form-group">
    <label>Importer un  fichier csv</label>
    <input id="csvfile" class="form-control" type="file"  />
</div>
<button onclick="dventity.exportdata(this)" type="button" class="btn btn-info">Importer les données!</button>
<hr>
<div id="result"></div>
<script>

    var dventity = {
        exportdata (el){
            model.addLoader($(el))
            var fd = new FormData();
            if ($("#csvfile")[0].files[0])
                fd.append( "fixture", $("#csvfile")[0].files[0])
            else
                fd.append( "contentcsv", $("#contentcsv").val())
            Drequest.init(__env + "admin/services.php?path=import&classname={{$entity}}")
                .data(fd)
                .post((function (response) {
                    model.removeLoader();
                    console.log(response)
                    $("#result").html(`<a class="btn btn-primary btn-block" target="_blank" href="${response.result.download}">download the exported file</a>`)
                }))

        }
    }

</script>