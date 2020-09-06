//dvups_entityCtrl

model.truncate = function (id) {
    if(!confirm("Confirm truncate of this table in database"))
        return;

    model._get("dvups-entity.truncate&id="+id, function (response) {
        console.log(response);
        ddatatable.replacerow(id, response.tablerow);
        alert("Table truncated successfully")
    })
};
