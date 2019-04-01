/**
 * Created by Aurelien Atemkeng on 7/26/2018.
 */

var databinding = {
    bindmodal: function (data) {
        // console.log(model.entity);
        model.modalbody.html(data);
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
    _showmodal: function(){
        //set content loader
        model.modalbody.html('<div style="height: 150px; text-align: center; padding: 5%">Loading ...</div>');
        model.modal.modal("show");
    },
    _dismissmodal: function(){
        model.modalbody.html("");
        model.modal.modal("hide");
    },
    entity : null,
    _new: function (callback) {
        this._showmodal();

        $.get(this.baseurl+"?path="+this.entity+"._new", function (response) {
            databinding.checkrenderform(response);
        }, 'json').fail (function(resultat, statut, erreur){
            console.log(statut, erreur);
            databinding.bindmodal(resultat.responseText);
        });

    },
    _edit: function (id, callback) {
        var regex = /_/gi;
        //string..replace(regex, '-')

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
    _formdata : function (form) {
        var $inputs = form.find('input');
        var $textareas = form.find('textarea');
        var $selects = form.find('select');
        var formentity = {};
        var formdata = new FormData();
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
            formentity[$(select).attr('name')] = $(select).val();
        });

        model.formentity = formentity;
        return formdata;
    },
    _get : function (action, callback) {

        $.ajax({
            url: this.baseurl+"?path="+this.entity+"."+action,
            //data: formdata,
            method: "GET",
            dataType: "json",
            success: callback,
            error: function (e) {
                console.log(e);//responseText
                model.modalbody.html(e.responseText);
            }
        });
    },

    _post : function (action, formdata, callback, fd = true) {
        // var formdata = this._formdata(form);
        // model.modalbody.append('<div id="loader" style="position: absolute;bottom:0; z-index: 3; height: 60px; text-align: center; padding: 5%">Loading ...</div>');
        if(!fd){

            $.ajax({
                url: this.baseurl+"?path="+this.entity+"."+action,
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
            url: this.baseurl+"?path="+this.entity+"."+action,
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
    init: function () {

        console.log(typeof $);
        if(typeof $ === 'undefined'){
            console.log("not ready");
            return;
        }

        model.baseurl = $("#dv_table").data('route')+"services.php";
        model.entity = $("#dv_table").data('entity');
        model.modal = $("#"+model.entity+"modal");
        model.modalbody = $("#"+model.entity+"modal").find(".modal-body");

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