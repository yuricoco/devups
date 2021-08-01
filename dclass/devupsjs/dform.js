/**
 * Created by Aurelien Atemkeng on 9/6/2018.
 */

var entityid = 0;
var dform = {
    geterror(error) {
        var errorarray = [];
        var keys = Object.keys(error);
        var values = Object.values(error);
        for (var i = 0; i < keys.length; i++) {
            errorarray.push("<b>" + keys[i] + "</b> : " + values[i] + "");
        }

        return '<div class="alert alert-danger alert-dismissable">\n' +
            '                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\n' +
            '                                ' + errorarray.join("<br>") + '.\n' +
            '                            </div>';
    },
    binderror: function (error) {

        if (!error)
            return 0;

        //model.modalbody.find("#loader").remove();
        //model.modalboxcontainer.find("#loader").remove();
        //console.log(response.error);

        if ($("#form-error").length) {
            $("#form-error").html(this.geterror(error));
            return;
        }

        model.modalboxcontainer.append(this.geterror(error));

    },
    callbackcreate: function (response) {
        console.log(response, "create");

        if (response.success) {
            if (response.redirect)
                window.location.href = response.redirect;

            else if (response.reload)
                window.location.reload();

            $.notify("Nouvelle ligne ajoutée avec succès!", "success");
            ddatatable.addrow(response.tablerow.row);
            //$("#dv_pagination").replaceWith(response.tablerow.tablepagination);

            //$("#dv_table").find("tbody").prepend(response.tablerow);
            model._dismissmodal();
            return;
        }

        dform.binderror(response.error);
    },
    callbackupdate: function (response) {
        console.log(response, "update");
        if (response.success) {
            if (response.redirect)
                window.location.href = response.redirect;

            else if (response.reload)
                window.location.reload();

            $.notify("Nouvelle ligne mise à jour avec succès!", "success");
            ddatatable.replacerow(dform.entityid, response.tablerow.row);
            // ddatatable.addrow(response.tablerow.row);
            //$("#dv_table").find("#"+entityid).replaceWith(response.tablerow);
            model._dismissmodal();
            return;
        }

        dform.binderror(response.error);
    },
    callback: null,
    formdata: null,
    currentform: null,
    _submit: function (el, url, next) {
        // var formserialize = $(this).serialize();
        // console.log(formserialize);
        this.currentform = $(el);
        if (!url) {
            url = this.currentform.attr("action");
        }

        this.currentbtnsubmit = $(el).find("button[type=submit]");

        // this.currentbtnsubmit.attr("disabled", true);
        this.currentbtnsubmit.prepend('<span class="spinner-border spinner-border-sm mr-2" role="status"></span>');

        this.callback = function (response) {
            console.log(response);
        };
        dform.entityid = $(el).data("id");

        if (dform.entityid) {
            //action = actionarray[1];
            //action = "update&id="+entityid;
            this.callback = dform.callbackupdate;
        } else {
            this.callback = dform.callbackcreate;
        }

        this.formdata = model._formdata($(el), this.formdata);

        console.log(url)
        Drequest.init(url)
            .data(this.formdata)
            .post((response) => {

                this.currentbtnsubmit.attr("disabled", false);
                this.currentbtnsubmit.find(".spinner-border").remove();

                if (next)
                    next(response);
                else
                    this.callback(response);

            });

        return false;
    },
    _apisubmit: function (el, url, next) {
        // var formserialize = $(this).serialize();
        // console.log(formserialize);
        if (!url) {
            var actionarray = $(el).attr("action").split("/");
            url = actionarray[1];
        }

        this.callback = function (response) {
            console.log(response);
        };
        dform.entityid = $(el).data("id");

        if (dform.entityid) {
            //action = actionarray[1];
            //action = "update&id="+entityid;
            this.callback = dform.callbackupdate;
        } else {
            this.callback = dform.callbackcreate;
        }

        this.formdata = model._formdata($(el));
        console.log(url);
        // if(next){
        //     next(model.entity+'.'+url);
        //     return 0;
        // }
        model._apipost(url, this.formdata, this.callback);

        return false;
    },
    findsuggestion(e) {

        $("input[name='product_form[name]']").val(this.productname);
        if (e.keyCode === 13) { //|| product.id
            return;
        }

        if (this.productname.length >= 3) {

            //$("#box-loader").show();
            var self = this;
            self.showlist = true;
            if (this.productdatas.length) {
                this.products = this.filterrow(this.productname, this.productdatas);
                //return;
            }
            // else
            console.log(this.productname, this.lastquery)
            if (this.productname.length === 3 && this.productname !== this.lastquery) {
                this.lastquery = this.productname;
                model._apiget(model.entity + ".list", {search: devups.escapeHtml(this.productname)},
                    (response) => {
                        console.log(response);
                        //self.showlist = true;
                        self.products = response.products;
                        self.productdatas = response.products;
                    })
            }
        } else {
            $("#productselected").html("");
            this.products = [];
            //this.productdatas = [];
            this.showlist = false;
        }
    },
    showliststatus(status) {
        setTimeout(() => {
            this.showlist = status;
        }, 500)
    },
    setproduct: function (product, idx) {
        console.log(product);
        if (!product.category)
            product.category = {};

        this.lastquery = "";
        this.products = [];
        this.productname = product.name;
        $("input[name='product_form[name]']").val(product.name);
        //productformvue.setProduct(product);
        this.$emit('selectproduct', product);

    },
    close() {

    },

    filterrow(value, dataarray) {
        var filter, filtered = [], tr, td, i, data;

        console.log(dataarray);
        filter = value.toUpperCase();

        for (i = 0; i < dataarray.length; i++) {
            data = dataarray[i];
            if (data.name.toUpperCase().indexOf(filter) > -1) {
                filtered.push(data);
            }
        }
        return filtered;
    },
};

console.log(model.entity)
$("#" + model.entity + "-form").submit(function (e) {
    e.preventDefault();
    dform._submit(this, $(this).attr("action"))
});
