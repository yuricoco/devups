function Ddatatable(entity) {
    self = this;
    //this.baseurl = "services.php";
    this.entity = "";
    this.currentpage = 1;
    this.per_page = 10;
    this.searchparam = "";
    this.allchecked = false;


    Ddatatable.prototype.getcheckbox = function () {
        return this.dtinstance.find("#dv_table").find('tbody').find("input[type=checkbox]");
    };
    Ddatatable.prototype.getcheckboxchecked = function () {
        var $input = this.getcheckbox();
        var ids = [];
        $.each($input, function (i, input) {
            if (input.checked)
                ids.push(input.value);
        });
        return ids;
    };
    Ddatatable.prototype.checkall = function () {
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
    };
    Ddatatable.prototype.uncheckall = function () {
        if (this.allchecked) {
            $("#checkall")[0].checked = false;
            this.allchecked = false;
        }
    };
    Ddatatable.prototype.groupdelete = function () {
        var thisclass = this;
        this.groupaction(function (ids, $trs) {

            if (ids === '') {
                alert("Aucun element selectionné!")
                return false;
            }

            if (!confirm('Voulez-vous Supprimer les éléments selectionnés?')) return false;

            $.get(this.baseurl + "?path=" + model.entity + "._deletegroup&ids=" + ids.join(), function (response) {
                    console.log(response);
                    $.each($trs, function (i, tr) {
                        tr.remove();
                    })
                    thisclass.uncheckall();
                },
                'json'
            ).error(function (resultat, statut, erreur) {
                console.log(statut, erreur);
                $("#" + model.entity + "modal").modal("show");
                Ddatatable.bindmodal(resultat.responseText);
            });//, 'json'
        });
    };
    Ddatatable.prototype.groupaction = function (callback) {
        var ids = this.getcheckboxchecked();

        var $trs = [];
        $.each(ids, function (i, id) {
            $trs.push($("#" + id));
        });
        callback(ids, $trs);
    };

    Ddatatable.prototype.search = (el) => {
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
    };
    Ddatatable.prototype.cancelsearch = ($this) => {
        this.searchparam = '';
        this.currentpage = 1;
        this.dtinstance.find("#dcancel-search").hide();
        this.page(1);
        // $.get("services.php?path="+model.entity+".datatable&next=1&per_page="+this.per_page, function (response) {
        //     //console.log(response);
        //     $("#dv_table").find("tbody").html(response.tablebody);
        //     $("#dv_table").find("input[type=reset]").addClass("hidden");
        //     removeloader();
        // }; 'json');//
    };
    Ddatatable.prototype.setperpage = function () {
        this.page(1);
    };
    Ddatatable.prototype.callback = function (response) {
        console.log(response);
    };
    Ddatatable.prototype.orderasc = (param) => {
        console.log(param);
        this.setloader();
        this.per_page = $("#dt_nbrow").val();
        this.order = "&" + param + " asc";
        $.get(this.geturl(), (response) => {
                console.log(response);
                this.dtinstance.find("#dv_table").find("tbody").html(response.datatable.tablebody);
                removeloader();
            },
            'json'
        ).fail(function (resultat, statut, erreur) {
            console.log(statut, erreur);
            $("#" + model.entity + "modal").modal("show");
            databinding.bindmodal(resultat.responseText);
        });//, 'json'
    };
    Ddatatable.prototype.orderdesc = (param) => {
        console.log(param);
        this.setloader();
        this.per_page = $("#dt_nbrow").val();
        this.order = "&" + param + " desc";
        $.get(this.geturl(), (response) => {
                //console.log(response);
                this.dtinstance.find("#dv_table").find("tbody").html(response.datatable.tablebody);
                this.removeloader();
            },
            'json'
        ).fail(function (resultat, statut, erreur) {
            console.log(statut, erreur);
            $("#" + model.entity + "modal").modal("show");
            databinding.bindmodal(resultat.responseText);
        });//, 'json'
    };
    Ddatatable.prototype.previous = () => {
        this.currentpage -= 1;
        this.page(this.currentpage);
    };
    Ddatatable.prototype.firstpage = function () {
        this.page(1);
    };
    Ddatatable.prototype.next = () => {
        this.currentpage += 1;
        this.page(this.currentpage);
    };
    Ddatatable.prototype.lastpage = (last) => {
        this.page(last);
    };
    Ddatatable.prototype.setloader = () => {
        this.dtinstance.find("#dv_table").prepend("<div class='loader'>loading</div>");
    };
    removeloader = () => {
        this.dtinstance.find("#dv_table").find(".loader").remove();
    };

    this.urlparam = "";

    Ddatatable.prototype.page = (index) => {
        if (index)
            this.currentpage = index;

        this.setloader();
        this.per_page = this.dtinstance.find("#dt_nbrow").val();
        console.log(this.geturl());
        $.get(this.geturl(), (response) => {
                console.log(response);
                this.dtinstance.find("#dv_table").find("tbody").html(response.datatable.tablebody);
                this.dtinstance.find("#dv_pagination").replaceWith(response.datatable.tablepagination);
                removeloader();
            },
            'json'
        ).fail(function (resultat, statut, erreur) {
            console.log(resultat);
            model._showmodal();
            //$("#"+model.entity+"modal").show();
            databinding.bindmodal(resultat.responseText);
        });//, 'json'

    };
    Ddatatable.prototype.findrow = (entityid) => {
        return this.dtinstance.find("#dv_table").find("#" + entityid).length;
    };
    Ddatatable.prototype.replacerow = (entityid, tablerow) => {
        this.dtinstance.find("#dv_table").find("#" + entityid).replaceWith(tablerow);
    };
    Ddatatable.prototype.removerow = (entityid) => {
        this.dtinstance.find("#dv_table").find("#" + entityid).remove();
    };
    Ddatatable.prototype.addrow = (tablerow) => {
        this.dtinstance.find("#dv_table").find("tbody").prepend(tablerow);
    };

    this.dtinstance = $("#dv_" + entity + "_table");
    this.entity = entity;

    this.dtinstance.find("#dt_nbrow").change(() => {
        console.log($(this).val());
        this.per_page = $(this).val();
        this.page(1);
    });

    this.dtinstance.find("#datatable-form").submit((e) => {
        e.preventDefault();
        this.search($(this));
    });

    Ddatatable.prototype.pagination = (page) => {

        this.currentpage = page;
        this.page(page);
    };

    this.dtinstance.find("#deletegroup").click(() => {
        this.groupdelete();
    });
    this.dtinstance.find("#checkall").click(() => {
        this.checkall();
    });
    this.dtinstance.find(".dcheckbox").click(() => {
        this.uncheckall();
    });

    this.baseurl = this.dtinstance.find("#dv_table").data('route') + "services.php";
    //console.log(ddatatable.baseurl);
    this.urlparam = this.dtinstance.find("#dv_table").data('filterparam');


    Ddatatable.prototype.geturl = () => {
        if (!this.order)
            this.order = "";

        return this.baseurl + "?path=" +
            this.entity + ".datatable&next=" +
            this.currentpage + "&per_page=" +
            this.per_page + this.searchparam +
            this.order + this.urlparam;
    };

}
