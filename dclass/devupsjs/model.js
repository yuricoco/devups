/**
 * Created by Aurelien Atemkeng on 7/26/2018.
 */

var databinding = {
    bindmodal: function (data) {
        // console.log(model.entity);
        // model.modalbody.html(data);
        model.modalboxcontainer.html(data);
    },
    checkrenderform: function (response) {
        //console.log(response);
        if (response.form)
            this.bindmodal(response.form);
        else
            this.bindmodal(response);
    }
}

var model = {
    baseredirect: "index.php",
    baseurl: "services.php",

    spinner: '<span class="spinner-border spinner-border-sm mr-2" role="status"></span>',
    btnactive: null,
    addLoader(btn) {
        this.btnactive = btn;
        this.btnactive.attr("disabled", true);
        this.btnactive.prepend(this.spinner);

    },
    removeLoader() {

        this.btnactive.attr("disabled", false);
        this.btnactive.find(".spinner-border").remove();

    },

    url: function (route, parameter) {
        var getAttr = "";
        if (parameter) {
            var keys = Object.keys(parameter);
            var values = Object.values(parameter);
            for (var i = 0; i < keys.length; i++) {
                getAttr += "&" + keys[i] + "=" + values[i];
            }
        }

        return route + getAttr;

    },
    routing: function (route, parameter) {
        return this.baseurl + "?path=" + this.url(route, parameter);
    },
    _showmodal: function (server = true) {
        //set content loader
        // model.modalbody.html('<div style="height: 150px; text-align: center; padding: 5%">Loading ...</div>');
        // model.modal.modal("show");
        if (server)
            model.modalboxcontainer.html('<div style="height: 150px; text-align: center; padding: 5%">Loading ...</div>');
        model.modalbox.css('display', "inline-flex");
        model.modalbox.find(".swal2-modal").css('display', "inline-flex");
    },
    _dismissmodal: function (empty = true) {
        // model.modalbody.html("");
        // model.modal.modal("hide");
        if (empty)
            model.modalboxcontainer.html('');
        model.modalbox.css('display', "none");
        model.modalbox.find(".swal2-modal").css('display', "none");
        this.init();
    },
    entity: null,
    _new: function (el, classname) {
        model.init(classname)
        /*if ($(el).parents(".dv-top-action").length) {
            this.baseurl = $(el).parents(".dv-top-action").data('route') + "services.php";
            this.entity = $(el).parents(".dv-top-action").data('entity');

            console.log("top action route", this.baseurl);
        }*/

        this._showmodal();
        model.request(this.entity + "._new"+ddatatable.urlparam)
            //.param({path: this.entity + "._new"})
            .get(function (response) {
                console.log(response)
                databinding.checkrenderform(response);
            })
            .fail(function (resultat, statut, erreur) {
                console.log(statut, erreur);
                databinding.bindmodal(resultat.responseText);
            });

    },
    _edit: function (id, entity) {
        model.init(entity)
        var regex = /_/gi;
        //string..replace(regex, '-')

        this._showmodal();

        model.request(this.entity + "._edit")
            .param({
                id: id
            })
            .get(function (response) {
                console.log(response)
                databinding.checkrenderform(response);
            })
            .fail(function (resultat, statut, erreur) {
                console.log(statut, erreur);
                databinding.bindmodal(resultat.responseText);
            });

    },
    callbackdelete(id, response) {

    },
    _delete: function ($this, id, entity, callback) {
        model.init(entity)
        this.addLoader($($this))
        var $tr = $($this).parents("tr");
        var $td = $($this).parents("td");

        if (!confirm('Voulez-vous Supprimer?')) return false;

        model.request(this.entity + "._delete")
            .param({
                id: id
            })
            .get( (response) => {
                this.removeLoader();
                console.log(response)
                if($tr.length)
                    $tr.remove();
                if (callback)
                    callback(response);
                this.callbackdelete(id, response)
            })
            .fail(function (resultat, statut, erreur) {
                console.log(statut, erreur);
                databinding.bindmodal(resultat.responseText);
            });

    },
    _show: function (id, entity, callback) {
        model.init(entity)
        this._showmodal();

        Drequest.init(this.baseurl)
            .param({
                path: this.entity + "._show",
                id: id
            })
            .get( (response) => {
                console.log(response);
                databinding.bindmodal(response);
            })
            .fail(function (resultat, statut, erreur) {
                console.log(statut, erreur);
                databinding.bindmodal(resultat.responseText);
            });

    },
    _formdatacustom: function (tbody) {

        var $rows = tbody.find("tr");
        var formentity = {};
        $.each($rows, function (i, row) {

            var $inputs = $(row).find('input');
            var $textareas = $(row).find('textarea');

            var value = {fr: $textareas.eq(1).val(), en: $textareas.eq(0).val()}

            formentity[$inputs.eq(0).val()] = value;
        })

        model.formentity = formentity;
        return formentity

    },
    _formdata: function (form, formdata) {
        var $inputs = form.find('input');
        var $textareas = form.find('textarea');
        var $selects = form.find('select');
        var formentity = {};

        if (!formdata)
            formdata = new FormData();

        $.each($inputs, function (i, input) {

            if ($(input).attr('type') === "file" && input.files[0]) {
                formdata.append($(input).attr('name'), input.files[0]);
                formentity[$(input).attr('name')] = $(input).val();
            } else if ($(input).attr('type') === "checkbox" && input.checked) {
                formdata.append($(input).attr('name'), $(input).val());
                formentity[$(input).attr('name')] = $(input).val();
            } else if ($(input).attr('type') === "radio" && input.checked) {
                formdata.append($(input).attr('name'), $(input).val());
                formentity[$(input).attr('name')] = $(input).val();
            } else if ($(input).attr('type') === "password") {
                formdata.append($(input).attr('name'), $(input).val());
                formentity[$(input).attr('name')] = $(input).val();
            } else if ($(input).attr('type') === "email") {
                formdata.append($(input).attr('name'), $(input).val());
                formentity[$(input).attr('name')] = $(input).val();
            } else if ($(input).attr('type') === "number") {
                formdata.append($(input).attr('name'), $(input).val());
                formentity[$(input).attr('name')] = $(input).val();
            } else if ($(input).attr('type') === "text") {
                formdata.append($(input).attr('name'), $(input).val());
                formentity[$(input).attr('name')] = $(input).val();
            }
        });
        $.each($textareas, function (i, textarea) {
            formdata.append($(textarea).attr('name'), $(textarea).val());
            formentity[$(textarea).attr('name')] = $(textarea).val();
        });
        $.each($selects, function (i, select) {
            formdata.append($(select).attr('name'), $(select).val());
            formentity[$(select).attr('name')] = {
                value: $(select).val(),
                option: $(select).find(":selected").text(),
            }
        });

        model.formentity = formentity;
        return formdata;
    },

    request : function (action) {
        // var formdata = this._formdata(form);
        // model.modalbody.append('<div id="loader" style="position: absolute;bottom:0; z-index: 3; height: 60px; text-align: center; padding: 5%">Loading ...</div>');
        console.log(this.baseurl)
        return Drequest.init(this.baseurl+"?path="+action)
    },

    getformvalue: function (field) {
        return this.formentity[this.entity + "_form[" + field + "]"];
    },
    getform: function (fm, entity, attribs) {
        this._formdata(fm);
        var keys = Object.keys(this.formentity);
        var values = Object.values(this.formentity);
        var form = [];
        var fd = new FormData();
        attribs.forEach((attr) => {
            for (var i = 0; i < keys.length; i++) {

                if (keys[i] === entity + "_form[" + attr + "]") {
                    form[attr] = values[i];
                    console.log(typeof values[i]);
                    if (typeof values[i] === 'string')
                        fd.append(keys[i], values[i]);
                    else
                        fd.append(keys[i], values[i].value);

                    break;
                }

            }
        });

        //form['dvups_form['+entity+']'] = this.formentity['dvups_form['+entity+']'];
        form[entity] = this.formentity['dvups_form[' + entity + ']'];
        console.log(JSON.parse(form[entity]));
        fd.append('dvups_form[' + entity + ']', this.formentity['dvups_form[' + entity + ']']);
        form.fd = fd;
        return form;
    },
    entitytoformdata(entity, entityformmodel) {
        var fd = new FormData();
        this.formentity = {};
        var keys = Object.keys(entity);
        var values = Object.values(entity);

        for (var i = 0; i < keys.length; i++) {
            if (typeof values[i] === 'object' && values[i] !== null)
                fd.append(entityformmodel.name + `_form[${keys[i]}]`, values[i].id)
            else
                fd.append(entityformmodel.name + `_form[${keys[i]}]`, values[i])
        }
        fd.append('dvups_form[' + entityformmodel.name + ']', JSON.stringify(entityformmodel.field));

        return fd;
    },
    entitytoformentity(entity, persistance = []) {

        var formentity = {};
        var keys = Object.keys(entity);
        var values = Object.values(entity);

        for (var i = 0; i < keys.length; i++) {
            if (persistance.length) {
                if (persistance.includes(keys[i])) {
                    if (typeof values[i] === 'object' && values[i] !== null) {
                        formentity[keys[i] + ".id"] = values[i].id;
                        //formentity[entityformmodel.name+`_form[${keys[i]}]`] = values[i].id;
                    } else
                        formentity[keys[i]] = values[i]
                }
            } else {
                if (typeof values[i] === 'object' && values[i] !== null) {
                    formentity[keys[i] + ".id"] = values[i].id;
                    //formentity[entityformmodel.name+`_form[${keys[i]}]`] = values[i].id;
                } else
                    formentity[keys[i]] = values[i]
            }
            // formentity[entityformmodel.name+`_form[${keys[i]}]`] = values[i]
        }
        //this.formentity['dvups_form['+entityformmodel.name+']'] = entityformmodel.field;

        return formentity;
    },
    getformfield: function (field) {
        return $("input[name='" + this.entity + "_form[" + field + "]']");
    },
    init: function (entity) {

        if(!entity)
            return ;
        model.entity = entity;
        ddatatable.init(entity);
        model.baseurl = ddatatable.baseurl;
        // model.entity = dvdatatable.eq(0).data('entity');

        model.modal = $("#" + model.entity + "modal");
        model.modalbox = $("#" + model.entity + "box");
        model.modalbody = $("#" + model.entity + "modal").find(".modal-body");
        model.modalboxcontainer = $("#" + model.entity + "box").find(".box-container .card-body");

    }
};

//setTimeout(function () {
    // model.init();
//}, 800)

