/**
 * Created by Aurelien Atemkeng on 7/26/2018.
 */

var totalpage = $("#pagination-notice").data('notice');

$("#deletegroup").click(function () {
    ddatatable.groupdelete();
});
$("#checkall").click(function () {
    ddatatable.checkall();
});
$(".dcheckbox").click(function () {
    ddatatable.uncheckall();
});
var ddatatable = {
    baseurl : "services.php",
    currentpage : 1,
    per_page : 10,
    searchparam : "",
    allchecked: false,
    getcheckbox: function () {
        return $("#dv_table").find('tbody').find("input[type=checkbox]");
    },
    getcheckboxchecked: function () {
        var $input = this.getcheckbox();
        var ids = [];
        $.each($input, function (i, input) {
            if(input.checked)
                ids.push(input.value);
        });
        return ids;
    },
    checkall : function () {
        var $input = this.getcheckbox();
        if(this.allchecked){
            this.allchecked = false;
            $.each($input, function (i, input) {
                //console.log(input);
                input.checked = false;
            });
        }else{
            this.allchecked = true;
            $.each($input, function (i, input) {
                //console.log(input);
                input.checked = true;
            });
        }
    },
    uncheckall: function () {
        if(this.allchecked){
            $("#checkall")[0].checked = false;
            this.allchecked = false;
        }
    },
    groupdelete: function () {
        var thisclass = this;
        this.groupaction(function (ids, $trs) {

            if(ids == ''){
                alert("Aucun element selectionné!")
                return false;
            }

            if(!confirm('Voulez-vous Supprimer les éléments selectionnés?')) return false;

            $.get(this.baseurl+"?path="+model.entity+"._deletegroup&ids="+ids.join(), function (response) {
                console.log(response);
                $.each($trs, function (i, tr) {
                    tr.remove();
                })
                thisclass.uncheckall();
            }, 'json').error (function(resultat, statut, erreur){
                console.log(statut, erreur);
                $("#"+model.entity+"modal").modal("show");
                databinding.bindmodal(resultat.responseText);
            });//, 'json'
        });
    },
    groupaction : function (callback) {
        var ids = this.getcheckboxchecked();

        var $trs = [];
        $.each(ids, function (i, id) {
            $trs.push($("#"+id));
        });
        callback(ids, $trs);
    },
    search: function (form) {
        var $input = form.find("thead").find('input');
        this.currentpage = 1;
        var searchparam = '';
        $.each($input, function (i, input) {
            if ($(input).val()){
                searchparam += "&" + $(input).attr('name') + "=" + $(input).val();
            }
        });

        $("#dcancel-search").removeClass("hidden");
        if(searchparam){
            this.searchparam = searchparam;
            this.page(1);
        }
    },
    cancelsearch : function ($this) {
        this.searchparam = '';
        this.currentpage = 1;
        $("#dcancel-search").addClass("hidden");
        this.page(1);
        // $.get("services.php?path="+model.entity+".datatable&next=1&per_page="+this.per_page, function (response) {
        //     //console.log(response);
        //     $("#dv_table").find("tbody").html(response.tablebody);
        //     $("#dv_table").find("input[type=reset]").addClass("hidden");
        //     removeloader();
        // }, 'json');//
    },
    setperpage: function(per_page){
        this.per_page = per_page;
        this.page(1);
    },
    callback: function (response) {
        console.log(response);
    },
    orderasc:function (param) {
        console.log(param);
        this.setloader();
        $.get(this.baseurl+"?path="+model.entity+".datatable&next="+this.currentpage+"&per_page="+this.per_page+this.searchparam+"&"+param, function (response) {
            console.log(response);
            $("#dv_table").find("tbody").html(response.datatable.tablebody);
            removeloader();
        }, 'json').error (function(resultat, statut, erreur){
            console.log(statut, erreur);
            $("#"+model.entity+"modal").modal("show");
            databinding.bindmodal(resultat.responseText);
        });//, 'json'
    },
    orderdesc:function (param) {
        console.log(param);
        this.setloader();
        $.get(this.baseurl+"?path="+model.entity+".datatable&next="+this.currentpage+"&per_page="+this.per_page+this.searchparam+"&"+param+" desc", function (response) {
            //console.log(response);
            $("#dv_table").find("tbody").html(response.datatable.tablebody);
            removeloader();
        }, 'json').error (function(resultat, statut, erreur){
            console.log(statut, erreur);
            $("#"+model.entity+"modal").modal("show");
            databinding.bindmodal(resultat.responseText);
        });//, 'json'
    },
    previous: function () {
        this.currentpage -= 1;
        this.page(this.currentpage);
    },
    next: function () {
        this.currentpage += 1;
        this.page(this.currentpage);
    },
    setloader: function () {
        $("#dv_table").prepend("<div class='loader'>loading</div>");
    },
    removeloader: function () {
        $("#dv_table").find(".loader").remove();
    },
    page: function (index) {
        this.setloader();
        console.log("services.php?path="+model.entity+".datatable&next="+index+"&per_page="+this.per_page+""+this.searchparam);
        $.get(this.baseurl+"?path="+model.entity+".datatable&next="+index+"&per_page="+this.per_page+""+this.searchparam, function (response) {
            console.log(response);
            $("#dv_table").find("tbody").html(response.datatable.tablebody);
            $("#dv_pagination").replaceWith(response.datatable.tablepagination);
            removeloader();
        }, 'json').error (function(resultat, statut, erreur){
            console.log(resultat);
            $("#"+model.entity+"modal").show();
            databinding.bindmodal(resultat.responseText);
        });//, 'json'

    }
};

function removeloader(){
    $("#dv_table").find(".loader").remove();
}

$("#dt_nbrow").change(function () {
    console.log($(this).val());
    ddatatable.per_page = $(this).val();
});

$("#datatable-form").submit(function (e) {
    e.preventDefault();
    ddatatable.search($(this));
});

ddatatable.pagination = function (page) {
    this.currentpage = page;
    this.page(page);
};
