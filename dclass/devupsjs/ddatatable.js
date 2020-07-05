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

    rowselect (el, id, callback){

    },

    getcheckbox: function () {
        return this.dtinstance.find("#dv_table").find('tbody').find("input[type=checkbox]");
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
        this.dtinstance.find("#dcancel-search").hide();
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
        //this.per_page = $("#dt_nbrow").val();
        this.order = "&"+param+" asc";
        console.log(this.geturl());
        $.get(this.geturl(), (response) => {
            console.log(response);
            this.dtinstance.find("#dv_table").find("tbody").html(response.datatable.tablebody);
            removeloader();
        }, 'json').fail (function(resultat, statut, erreur){
            console.log(statut, erreur);
            //$("#"+model.entity+"modal").modal("show");
            databinding.bindmodal(resultat.responseText);
        });//, 'json'
    },
    orderdesc:function (param) {
        console.log(param);
        this.setloader();
        //this.per_page = $("#dt_nbrow").val();
        this.order = "&"+param+" desc";
        console.log(this.geturl());
        $.get(this.geturl(), (response) => {
            //console.log(response);
            this.dtinstance.find("#dv_table").find("tbody").html(response.datatable.tablebody);
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
    firstpage: function () {
        this.currentpage = 1;
        this.page(1);
    },
    next: function () {
        this.currentpage = parseInt(this.currentpage) + 1;
        this.page(this.currentpage);
    },
    lastpage: function (last) {
        this.currentpage = last;
        this.page(last);
    },
    setloader: function () {
        this.dtinstance.find("#dv_table").prepend("<div class='loader'>loading</div>");
    },
    removeloader: function () {
        this.dtinstance.find("#dv_table").find(".loader").remove();
    },
    geturl: function(){
        if(!this.order)
            this.order = "";

        return this.baseurl+"?path="+
            this.entity+".datatable&next="+
            this.currentpage+"&per_page="+
            this.per_page+this.searchparam+
            this.order + this.urlparam;
    },
    _reload (){
        this.page()
    },
    urlparam : "",
    page: function (index) {
        this.setloader();
        console.log(this.geturl());
        $.get(this.geturl(), (response) => {
            console.log(response);
            removeloader();
            this.dtinstance.find("#dv_table").find("tbody").html(response.datatable.tablebody);
            this.dtinstance.find("#dv_pagination").replaceWith(response.datatable.tablepagination);

        }, 'json').fail (function(resultat, statut, erreur){
            console.log(resultat);
            model._showmodal();
            removeloader();
            //$("#"+model.entity+"modal").show();
            databinding.bindmodal(resultat.responseText);
        });//, 'json'

    },
    findrow: function (entityid) {
        return this.dtinstance.find("#dv_table").find("#"+entityid).length;
    },
    replacerow: function (entityid, tablerow) {
        this.dtinstance.find("#dv_table").find("#"+entityid).replaceWith(tablerow);
    },
    removerow: function (entityid) {
        this.dtinstance.find("#dv_table").find("#"+entityid).remove();
    },
    addrow: function (tablerow) {
        this.dtinstance.find("#dv_table").find("tbody").prepend(tablerow);
    },
    getinstanceof(entity){
        return $("#dv_"+entity+"_table");
    },
    init: function (entity) {

        if(typeof $ === 'undefined'){
            return;
        }

        console.log("#dv_"+entity+"_table");
        this.dtinstance = $("#dv_"+entity+"_table");
        this.entity = entity;

        this.dtinstance.find("#dt_nbrow").change(function () {
            console.log($(this).val());
            ddatatable.per_page = $(this).val();
            ddatatable.page(1);
        });

        this.dtinstance.find("#datatable-form").submit(function (e) {
            e.preventDefault();
            ddatatable.search($(this));
        });

        ddatatable.pagination = function (page) {

            this.currentpage = page;
            this.page(page);
        };

        this.dtinstance.find("#deletegroup").click(function () {
            ddatatable.groupdelete();
        });
        this.dtinstance.find("#checkall").click(function () {
            ddatatable.checkall();
        });
        this.dtinstance.find(".dcheckbox").click(function () {
            ddatatable.uncheckall();
        });
        this.dtinstance.find(".search-field").keyup(function (event) {
            var key = event.keyCode;
            if(key === 13)
                ddatatable.search(this)
        });

        ddatatable.per_page = this.dtinstance.find("#dv_table").data('perpage');

        ddatatable.baseurl = this.dtinstance.find("#dv_table").data('route')+"services.php";
        //
        ddatatable.urlparam = this.dtinstance.find("#dv_table").data('filterparam');

        return this;

    }
};

function removeloader(){
    ddatatable.dtinstance.find("#dv_table").find(".loader").remove();
    //$('html,body').animate({scrollTop:$("#dbody").offset().top},500);
}


setTimeout(function () {

    ddatatable.init(model.entity);
    $("#dv_main_container").on('mouseenter', ".dv_datatable_container", function () {

        model.baseurl = $(this).find("#dv_table").eq(0).data('route')+"services.php";
        model.entity = $(this).find("#dv_table").eq(0).data('entity');

        //model.init($(this).find("#dv_table"));
        // ddatatable.init(model.entity);

    })

}, 800)

