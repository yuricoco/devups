

model.convertphparraytojson =  function (el) {

    if(!confirm("This action will overwrite the whole file of lang! \n\nContinue?")) return false;
    model.baseurl = __env+"src/devups/ModuleTranslate/services.php";
    model.entity = "generalinfo";
    model._get("convertphparraytojson", function (response) {
        console.log(response);
        alert("well saved");
    })

}

model.saveinfo =  function (el) {

    this._formdatacustom($(el).find("tbody"));
    console.log(model.formentity);

    var fd = new FormData();
    fd.append("content", JSON.stringify(model.formentity))

    model.baseurl = __env+"src/devups/ModuleTranslate/services.php";
    model.entity = "generalinfo";
    model._post("save", fd, function (response) {
        console.log(response);
        alert("well saved");

    })

    return false;

}

model.addline =  function () {

    $("tbody").append(`<tr>
                    <th scope="row"><span class="btn btn-danger" onclick="model.removeline(this)">x</span></th>
                    <td><input class="form-control" name="key" type="text" placeholder="Key" value="" ></td>
                    <td><textarea class="form-control" name="en" type="text" placeholder="Value" rows="1" ></textarea></td>
                    <td><textarea class="form-control" name="fr" type="text" placeholder="Value" rows="1" ></textarea></td>
                </tr>`);
    return false;
}

model.removeline =  function (el) {
    $(el).parents("tr").remove()
}


function filterrow(el) {
    var input, filter, table, tr, td, i, txtValue;
    input = el;
    filter = input.value.toUpperCase();
    console.log(filter);
    table = $(el).parents("table")[0];
    tr = table.getElementsByTagName("tr");
    for (i = 1; i <= tr.length; i++) {
        if(!tr[i])
            break;

        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = $(td).find("input").val();
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}