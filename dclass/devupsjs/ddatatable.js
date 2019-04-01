/**
 * Created by Aurelien Atemkeng on 7/26/2018.
 */

var ddatatable = {
    baseurl : "services.php",
    entity : "",
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

            if(ids === ''){
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
    search: function (el) {
        var form = $(el).parents("tr.th-filter");
        var $input = form.find('input');
        var $selects = form.find('select');
        this.currentpage = 1;
        var searchparam = '';

        $.each($input, function (i, input) {
            var valueparam = '';
            if($(input).attr('type') === "radio" && input.checked){
                valueparam = $(input).val();
            }else if ($(input).val()){
                valueparam = $(input).val();
            }
            searchparam += "&" + $(input).attr('name') + "=" + valueparam;

        });

        $.each($selects, function (i, select) {
            searchparam += "&" + $(select).attr('name') + "=" + $(select).val();
        });

        $("#dcancel-search").show();
        if(searchparam){
            this.searchparam = searchparam;
            this.page(1);
        }
    },
    cancelsearch : function ($this) {
        this.searchparam = '';
        this.currentpage = 1;
        $("#dcancel-search").hide();
        this.page(1);
        // $.get("services.php?path="+model.entity+".datatable&next=1&per_page="+this.per_page, function (response) {
        //     //console.log(response);
        //     $("#dv_table").find("tbody").html(response.tablebody);
        //     $("#dv_table").find("input[type=reset]").addClass("hidden");
        //     removeloader();
        // }, 'json');//
    },
    setperpage: function(){
        this.page(1);
    },
    callback: function (response) {
        console.log(response);
    },
    orderasc:function (param) {
        console.log(param);
        this.setloader();
        this.per_page = $("#dt_nbrow").val();
        this.order = "&"+param+" asc";
        $.get(this.geturl(), function (response) {
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
        this.per_page = $("#dt_nbrow").val();
        this.order = "&"+param+" desc";
        $.get(this.geturl(), function (response) {
            //console.log(response);
            $("#dv_table").find("tbody").html(response.datatable.tablebody);
            removeloader();
        }, 'json').fail (function(resultat, statut, erreur){
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
    geturl: function(){
        return this.baseurl+"?path="+model.entity+".datatable&next="+this.currentpage+"&per_page="+this.per_page+this.searchparam+this.order;
    },
    page: function (index) {
        this.setloader();
        this.per_page = $("#dt_nbrow").val();
        console.log(this.geturl());
        $.get(this.geturl(), function (response) {
            console.log(response);
            $("#dv_table").find("tbody").html(response.datatable.tablebody);
            $("#dv_pagination").replaceWith(response.datatable.tablepagination);
            removeloader();
        }, 'json').fail (function(resultat, statut, erreur){
            console.log(resultat);
            $("#"+model.entity+"modal").show();
            databinding.bindmodal(resultat.responseText);
        });//, 'json'

    },
    replacerow: function (entityid, tablerow) {
        $("#dv_table").find("#"+entityid).replaceWith(tablerow);
    },
    removerow: function (entityid) {
        $("#dv_table").find("#"+entityid).remove();
    },
    addrow: function (tablerow) {
        $("#dv_table").find("tbody").prepend(tablerow);
    },
    init: function () {
        console.log(typeof $);
        if(typeof $ === 'undefined'){
            console.log("not ready");
            return;
        }

        console.log("ready");

        $("#dt_nbrow").change(function () {
            console.log($(this).val());
            ddatatable.per_page = $(this).val();
            ddatatable.page(1);
        });

        $("#datatable-form").submit(function (e) {
            e.preventDefault();
            ddatatable.search($(this));
        });

        ddatatable.pagination = function (page) {

            this.currentpage = page;
            this.page(page);
        };

        $("#deletegroup").click(function () {
            ddatatable.groupdelete();
        });
        $("#checkall").click(function () {
            ddatatable.checkall();
        });
        $(".dcheckbox").click(function () {
            ddatatable.uncheckall();
        });

        ddatatable.baseurl = $("#dv_table").data('route')+"services.php";

    }
};

function removeloader(){
    $("#dv_table").find(".loader").remove();
    $('html,body').animate({scrollTop:$("#dbody").offset().top},500);
}


setTimeout(function () {

    ddatatable.init();

}, 800)

