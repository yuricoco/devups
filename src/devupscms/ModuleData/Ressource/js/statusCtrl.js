
$('#dv_table tbody').sortable({
    helper: fixWidthHelper,
    stop: function( event, ui ) {
        var i = 0;
        var datapersit = [];
        for(var item of $(this).find("tr")){
            i++;
            $(item).find(".position").html(i);
        }

    }
}).disableSelection();

function fixWidthHelper(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
}

model.status = {
    sortlist : function (el) {
        model.addLoader($(el))
        var fd = new FormData();
        $.each($('#dv_table tbody').find('tr'), function(i, tr){
            console.log(tr);
            fd.append("positions[]", $(tr).attr("id"));
        });

        model._post("status.orderlist", fd, function (response) {
            model.removeLoader();
            console.log(response);
            // ddatatable._reload();
            $.notify("List Réorganisée!", "success");
        });

    }
};
