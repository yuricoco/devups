/**
 * Created by Aurelien Atemkeng on 7/26/2018.
 */

var databinding = {
    bindmodal: function (data) {
        // console.log(model.entity);
        // model.modalbody.html(data);
        model.modalboxcontainer.html(data);
    },
    checkrenderform: function(response){
        //console.log(response);
        if(response.form)
            this.bindmodal(response.form);
        else
            this.bindmodal(response);
    }
}

var model = {
    baseredirect : "index.php",
    baseurl : "services.php",

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
    _showmodal: function(server = true){
        //set content loader
        // model.modalbody.html('<div style="height: 150px; text-align: center; padding: 5%">Loading ...</div>');
        // model.modal.modal("show");
        if(server)
            model.modalboxcontainer.html('<div style="height: 150px; text-align: center; padding: 5%">Loading ...</div>');
        model.modalbox.css('display',"inline-flex");
    },
    _dismissmodal: function(empty = true){
        // model.modalbody.html("");
        // model.modal.modal("hide");
        if(empty)
            model.modalboxcontainer.html('');
        model.modalbox.css('display',"none");
        this.init();
    },
    entity : null,
    _new: function (callback) {
        this._showmodal();

        console.log(this.baseurl+"?path="+this.entity+"._new")
        $.get(this.baseurl+"?path="+this.entity+"._new", function (response) {
            console.log(response)
            databinding.checkrenderform(response);
        }, 'json').fail (function(resultat, statut, erreur){
            console.log(statut, erreur);
            databinding.bindmodal(resultat.responseText);
        });

    },
    _edit: function (id, callback) {
        var regex = /_/gi;
        //string..replace(regex, '-')
        this._showmodal();

        console.log(this.baseurl+"?path="+this.entity+"._edit&id="+id)
        $.get(this.baseurl+"?path="+this.entity+"._edit&id="+id, function (response) {
            databinding.checkrenderform(response);
        }, 'json').fail (function(resultat, statut, erreur){
            console.log(statut, resultat);
            databinding.bindmodal(resultat.responseText);
        });//, 'json'
    },
    _delete: function ($this, id, callback) {

        var $tr = $($this).parents("tr");
        var $td = $($this).parents("td");

        if(!confirm('Voulez-vous Supprimer?')) return false;

        $.get(this.baseurl+"?path="+this.entity+"._delete&id="+id, function (response) {
            console.log(response);
            $tr.remove();
            if(callback)
                callback(response);

        }, 'json').fail (function(resultat, statut, erreur){
            console.log(resultat);
            databinding.bindmodal(resultat.responseText);
        });//, 'json'

    },
    _show: function (id, callback) {

        this._showmodal();

        $.get(this.baseurl+"?path="+this.entity+"._show&id="+id, function (response) {
            databinding.bindmodal(response);
        }, 'html').fail (function(resultat, statut, erreur){
            console.log(statut, erreur);
            databinding.bindmodal(resultat.responseText);
        });//, 'json'

    },
    _formdatacustom: function(tbody){

        var $rows = tbody.find("tr");
        var formentity = {};
        $.each($rows, function (i, row) {

            var $inputs = $(row).find('input');
            var $textareas = $(row).find('textarea');

            var value = {fr : $textareas.eq(1).val(), en: $textareas.eq(0).val()}

            formentity[$inputs.eq(0).val()] = value;
        })

        model.formentity = formentity;
        return formentity

    },
    _formdata : function (form, formdata) {
        var $inputs = form.find('input');
        var $textareas = form.find('textarea');
        var $selects = form.find('select');
        var formentity = {};

        if (!formdata)
            formdata = new FormData();

        $.each($inputs, function (i, input) {

            if($(input).attr('type') === "file" && input.files[0]){
                formdata.append($(input).attr('name'), input.files[0]);
                formentity[$(input).attr('name')] = $(input).val();
            }
            else if($(input).attr('type') === "checkbox" && input.checked){
                formdata.append($(input).attr('name'), $(input).val());
                formentity[$(input).attr('name')] = $(input).val();
            }
            else if($(input).attr('type') === "radio" && input.checked){
                formdata.append($(input).attr('name'), $(input).val());
                formentity[$(input).attr('name')] = $(input).val();
            }
            else if($(input).attr('type') === "password" ) {
                formdata.append($(input).attr('name'), $(input).val());
                formentity[$(input).attr('name')] = $(input).val();
            }
            else if($(input).attr('type') === "email" ) {
                formdata.append($(input).attr('name'), $(input).val());
                formentity[$(input).attr('name')] = $(input).val();
            }
            else if($(input).attr('type') === "number" ) {
                formdata.append($(input).attr('name'), $(input).val());
                formentity[$(input).attr('name')] = $(input).val();
            }
            else if($(input).attr('type') === "text" ) {
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
    _get : function (action, data, callback) {

        //console.log(typeof data)
        if(!callback){
            callback = data;
            data = {};
        }

        console.log(this.baseurl+"?path="+action);
        $.ajax({
            url: this.baseurl+"?path="+action,
            data: data,
            method: "GET",
            dataType: "json",
            success: callback,
            error: function (e) {
                console.log(e);//responseText
                callback(e.responseText)
            }
        });
    },
    _apiget : function (action, data, callback) {

        //console.log(typeof data)
        if(!callback){
            callback = data;
            data = {};
        }

        $.ajax({
            url: __env+'api/'+action,
            data: data,
            method: "GET",
            dataType: "json",
            success: callback,
            error: function (e) {
                console.log(e);//responseText
                if(e.status === 0){
                    var event = document.createEvent('Event');
                    event.initEvent("connectionLost", true, true);
                    window.dispatchEvent(event);
                }
            }
        });
    },


    _post : function (action, formdata, callback, fd = true) {
        // var formdata = this._formdata(form);
        // model.modalbody.append('<div id="loader" style="position: absolute;bottom:0; z-index: 3; height: 60px; text-align: center; padding: 5%">Loading ...</div>');
        if(!fd){

            $.ajax({
                url: this.baseurl+"?path="+action,
                data: formdata,
                method: "POST",
                dataType: "json",
                success: callback,
                error: function (e) {
                    console.log(e);//responseText
                    model.modalbody.html(e.responseText);
                }
            });

            return;
        }

        $.ajax({
            url: this.baseurl+"?path="+action,
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            method: "POST",
            dataType: "json",
            success: callback,
            error: function (e) {
                console.log(e);//responseText
                model.modalbody.html(e.responseText);
            }
        });
    },

    _apipost : function (action, formdata, callback, fd = true) {
        // var formdata = this._formdata(form);
        // model.modalbody.append('<div id="loader" style="position: absolute;bottom:0; z-index: 3; height: 60px; text-align: center; padding: 5%">Loading ...</div>');
        if(!fd){

            $.ajax({
                url: __env+'api/'+action,
                data: formdata,
                method: "POST",
                dataType: "json",
                success: callback,
                error: function (e) {
                    console.log(e);//responseText
                    model.modalbody.html(e.responseText);
                }
            });

            return;
        }

        $.ajax({
            url: __env+'api/'+action,
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            method: "POST",
            dataType: "json",
            success: callback,
            error: function (e) {
                console.log(e);//responseText
                model.modalbody.html(e.responseText);
            }
        });
    },

    getformvalue: function (field) {
        return this.formentity[this.entity+"_form["+field+"]"];
    },
    getform: function (fm, entity, attribs) {
        this._formdata(fm);
        var keys = Object.keys(this.formentity);
        var values = Object.values(this.formentity);
        var form = [];
        var fd = new FormData();
        attribs.forEach((attr)=>{
            for (var i = 0; i < keys.length; i++) {

                if(keys[i] === entity+"_form["+attr+"]"){
                    form[attr] = values[i];
                    console.log(typeof values[i]);
                    if(typeof values[i] === 'string')
                        fd.append(keys[i], values[i]);
                    else
                        fd.append(keys[i], values[i].value);

                    break;
                }

            }
        });

        //form['dvups_form['+entity+']'] = this.formentity['dvups_form['+entity+']'];
        form[entity] = this.formentity['dvups_form['+entity+']'];
        console.log(JSON.parse(form[entity]));
        fd.append('dvups_form['+entity+']', this.formentity['dvups_form['+entity+']']);
        form.fd = fd;
        return form;
    },
    entitytoformdata (entity, entityformmodel){
        var fd = new FormData();
        this.formentity = {};
        var keys = Object.keys(entity);
        var values = Object.values(entity);

        for (var i = 0; i < keys.length; i++) {
            if (typeof values[i] === 'object' && values[i] !== null)
                fd.append(entityformmodel.name+`_form[${keys[i]}]`, values[i].id)
            else
                fd.append(entityformmodel.name+`_form[${keys[i]}]`, values[i])
        }
        fd.append('dvups_form['+entityformmodel.name+']', JSON.stringify(entityformmodel.field));

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
        return $("input[name='"+this.entity+"_form["+field+"]']");
    },
    init: function (dvdatatable) {

        console.log(typeof $);
        if(typeof $ === 'undefined'){
            console.log("not ready");
            return;
        }

        model.baseurl = $(".dv_datatable").eq(0).data('route')+"services.php";
        model.entity = $(".dv_datatable").eq(0).data('entity');

        // model.baseurl = dvdatatable.eq(0).data('route')+"services.php";
        // model.entity = dvdatatable.eq(0).data('entity');

        model.modal = $("#"+model.entity+"modal");
        model.modalbox = $("#"+model.entity+"box");
        model.modalbody = $("#"+model.entity+"modal").find(".modal-body");
        model.modalboxcontainer = $("#"+model.entity+"box").find(".box-container .card-body");

    }
};

setTimeout(function () {
    model.init();
}, 800)

// $("#model_new").attr("href", "#");
// $("#model_new").click(function (e) {
//     e.preventDefault();
//     model._new()
// });
