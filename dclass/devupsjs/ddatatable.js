/**
 * Created by Aurelien Atemkeng on 7/26/2018.
 */

var ddatatable = {
    baseurl: "services.php",
    entity: "",
    currentpage: 1,
    per_page: 10,
    searchparam: "",
    allchecked: false,

    rowselect(el, id, callback) {

    },

    getcheckbox: function () {
        return this.dtinstance.find("#dv_table").find('tbody').find("input[type=checkbox]");
    },
    getcheckboxchecked: function () {
        var $input = this.getcheckbox();
        var ids = [];
        $.each($input, function (i, input) {
            if (input.checked)
                ids.push(input.value);
        });
        return ids;
    },
    checkall: function () {
        var $input = this.getcheckbox();
        if (this.allchecked) {
            this.allchecked = false;
            $.each($input, function (i, input) {
                //console.log(input);
                input.checked = false;
            });
        } else {
            this.allchecked = true;
            $.each($input, function (i, input) {
                //console.log(input);
                input.checked = true;
            });
        }
    },
    uncheckall: function () {
        if (this.allchecked) {
            $("#checkall")[0].checked = false;
            this.allchecked = false;
        }
    },
    groupdelete: function () {
        var thisclass = this;
        this.groupaction(function (ids, $trs) {

            if (ids === '') {
                alert("Aucun element selectionné!")
                return false;
            }

            if (!confirm('Voulez-vous Supprimer les éléments selectionnés?')) return false;

            $.get(ddatatable.baseurl + "?path=" + model.entity + "._deletegroup&ids=" + ids.join(),
                (response) => {
                    console.log(response);
                    $.each($trs, function (i, tr) {
                        tr.remove();
                    })
                    thisclass.uncheckall();
                }, 'json').fail(function (resultat, statut, erreur) {
                console.log(statut, erreur);
                //$("#" + model.entity + "modal").modal("show");
                databinding.bindmodal(resultat.responseText);
            });//, 'json'
        });
    },
    groupaction: function (callback) {
        var ids = this.getcheckboxchecked();

        var $trs = [];
        $.each(ids, function (i, id) {
            $trs.push($("#" + id));
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
            if ($(input).attr('type') === "radio" && input.checked) {
                valueparam = $(input).val();
            } else if ($(input).val()) {
                valueparam = $(input).val();
            }
            searchparam += "&" + $(input).attr('name') + "=" + valueparam;

        });

        $.each($selects, function (i, select) {
            searchparam += "&" + $(select).attr('name') + "=" + $(select).val();
        });

        $("#dcancel-search").show();
        if (searchparam) {
            this.searchparam = searchparam;
            this.page(1);
        }
    },
    cancelsearch: function ($this) {
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
    setperpage: function () {
        this.page(1);
    },
    callback: function (response) {
        console.log(response);
    },
    orderasc: function (param) {
        console.log(param);
        this.setloader();
        //this.per_page = $("#dt_nbrow").val();
        this.order = "&" + param + " asc";
        console.log(this.geturl());
        $.get(this.geturl(), (response) => {
            console.log(response);
            this.dtinstance.find("#dv_table").find("tbody").html(response.datatable.tablebody);
            removeloader();
        }, 'json').fail(function (resultat, statut, erreur) {
            console.log(statut, erreur);
            //$("#"+model.entity+"modal").modal("show");
            databinding.bindmodal(resultat.responseText);
        });//, 'json'
    },
    orderdesc: function (param) {
        console.log(param);
        this.setloader();
        //this.per_page = $("#dt_nbrow").val();
        this.order = "&" + param + " desc";
        console.log(this.geturl());
        $.get(this.geturl(), (response) => {
            //console.log(response);
            this.dtinstance.find("#dv_table").find("tbody").html(response.datatable.tablebody);
            removeloader();
        }, 'json').fail(function (resultat, statut, erreur) {
            console.log(statut, erreur);
            $("#" + model.entity + "modal").modal("show");
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
    geturl: function () {
        if (!this.order)
            this.order = "";

        return this.baseurl + "?path=" +
            this.entity + ".datatable&next=" +
            this.currentpage + "&per_page=" +
            this.per_page + this.searchparam +
            this.order + this.urlparam;
    },
    _reload() {
        this.page()
    },
    urlparam: "",
    callbackpaginaison(response){
        this.dtinstance.find("#dv_table").find("tbody").html(response.datatable.tablebody);
        this.dtinstance.find("#dv_pagination").replaceWith(response.datatable.tablepagination);

    },
    page: function (index) {
        this.setloader();
        console.log(this.geturl());
        $.get(this.geturl(), (response) => {
            console.log(response);
            removeloader();
            this.callbackpaginaison(response)
        }, 'json').fail(function (resultat, statut, erreur) {
            console.log(resultat);
            model._showmodal();
            removeloader();
            //$("#"+model.entity+"modal").show();
            databinding.bindmodal(resultat.responseText);
        });//, 'json'

    },
    findrow: function (entityid) {
        return this.dtinstance.find("#dv_table").find("#" + entityid).length;
    },
    replacerow: function (entityid, tablerow) {
        this.dtinstance.find("#dv_table").find("#" + entityid).replaceWith(tablerow);
    },
    removerow: function (entityid) {
        this.dtinstance.find("#dv_table").find("#" + entityid).remove();
    },
    addrow: function (tablerow) {
        this.dtinstance.find("#dv_table").find("tbody").prepend(tablerow);
    },
    getinstanceof(entity) {
        return $("#dv_" + entity + "_table");
    },
    exportcsv(entity) {

        var dialog = new dialogbox();
        dialog.title = model.entity;
        dialog.export = function () {

            dialog.addLoader()

            $.get(__env + "admin/header.php?dvpath=dvexport&classname=" + model.entity + "",
                (response) => {
                    console.log(response);
                    dialog.removeLoader();
                    dialog.setcontent(`
                        <div class="alert alert-success">${response.message}</div>
                    `)
                }, 'json').fail(function (resultat, statut, erreur) {
                console.log(resultat, statut, erreur);

            });
        }
        dialog.footercontent = `
            <button onclick="self.export()" type="button" class="btn btn-default">Exporter les données!</button>
        `;
        dialog.init()
        dialog.show()

    },
    importcsv() {

        var dialog = new dialogbox();
        dialog.title = model.entity;
        dialog.import = function () {

            dialog.addLoader()

            var formdata = new FormData();
            formdata.append("fixture", $("input.dv_import_form")[0].files[0])
            $.ajax({
                url: __env+"admin/header.php?dvpath=dvimport&classname=" + model.entity,
                data: formdata,
                cache: false,
                contentType: false,
                processData: false,
                method: "POST",
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    dialog.removeLoader();
                    dialog.setcontent(`
                        <div class="alert alert-success">${response.message}</div>
                    `)
                },
                error: function (e) {
                    console.log(e);//responseText
                }
            });

        }
        dialog.opendialogmedia = function () {
            $("input.dv_import_form").trigger("click");
        }
        dialog.bodycontent = `
             <input class="dv_import_form" type="file" style="display: none" />
    <button onclick="self.opendialogmedia()">Open File Dialog</button>
        `;
        dialog.footercontent = `
            <button onclick="self.import()" type="button" class="btn btn-default">import data!</button>
        `;
        //dialog.init()
        dialog.show()
        dialog.setcontent()

    },
    init: function (entity) {

        // if (typeof $ === 'undefined') {
        //     return;
        // }

        console.log("#dv_" + entity + "_table");
        this.dtinstance = $("#dv_" + entity + "_table");
        this.entity = entity;


        ddatatable.per_page = this.dtinstance.find("#dv_table").data('perpage');

        ddatatable.baseurl = this.dtinstance.find("#dv_table").data('route') + "services.php";
        console.log(ddatatable.baseurl);
        //
        ddatatable.urlparam = this.dtinstance.find("#dv_table").data('filterparam');

        return this;

    }
};

function removeloader() {
    ddatatable.dtinstance.find("#dv_table").find(".loader").remove();
    //$('html,body').animate({scrollTop:$("#dbody").offset().top},500);
}


setTimeout(function () {

    ddatatable.init(model.entity);
    ddatatable.dtinstance.find("#dt_nbrow").change(function () {
        console.log($(this).val());
        ddatatable.per_page = $(this).val();
        ddatatable.page(1);
    });

    ddatatable.dtinstance.find("#datatable-form").submit(function (e) {
        e.preventDefault();
        ddatatable.search($(this));
    });

    ddatatable.pagination = function (el, page) {

        model.baseurl = $("#dv_pagination").data('route') + "services.php";
        model.entity = $("#dv_pagination").data('entity');

        ddatatable.init(model.entity);

        this.currentpage = page;
        this.page(page);

    };

    ddatatable.dtinstance.find(".dv_export_csv").click(function () {
        ddatatable.exportcsv();
    });
    ddatatable.dtinstance.find(".dv_import_csv").click(function () {
        ddatatable.importcsv();
    });
    ddatatable.dtinstance.find("#deletegroup").click(function () {
        ddatatable.groupdelete();
    });
    ddatatable.dtinstance.find("#checkall").click(function () {
        ddatatable.checkall();
    });
    ddatatable.dtinstance.find(".dcheckbox").click(function () {
        ddatatable.uncheckall();
    });
    ddatatable.dtinstance.find(".search-field").keyup(function (event) {
        var key = event.keyCode;
        if (key === 13)
            ddatatable.search(this)
    });

    /*$("#dv_main_container").on('mouseenter', ".dv_datatable_container", function () {

        model.baseurl = $(this).find("#dv_table").eq(0).data('route') + "services.php";
        model.entity = $(this).find("#dv_table").eq(0).data('entity');
        ddatatable.init(model.entity);
        console.log(model.entity);
        //model.init($(this).find("#dv_table"));
        // ddatatable.init(model.entity);

    })*/

}, 800)

