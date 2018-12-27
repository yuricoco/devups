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
        }, 'json').error (function(resultat, statut, erreur){
            console.log(statut, erreur);
            databinding.bindmodal(resultat.responseText);
        });

    },
    _edit: function (id, callback) {
        $.get(this.baseurl+"?path="+this.entity+"._edit&id="+id, function (response) {
            databinding.checkrenderform(response);
        }, 'json').error (function(resultat, statut, erreur){
            console.log(statut, erreur);
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

        }, 'json').error (function(resultat, statut, erreur){
            console.log(statut, erreur);
            databinding.bindmodal(resultat.responseText);
        });//, 'json'

    },
    _show: function (id, callback) {

        $.get(this.baseurl+"?path="+this.entity+"._show&id="+id, function (response) {
            databinding.bindmodal(response);
        }, 'html').error (function(resultat, statut, erreur){
            console.log(statut, erreur);
            databinding.bindmodal(resultat.responseText);
        });//, 'json'

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
    _post : function (action, formdata, callback) {
        // var formdata = this._formdata(form);
        // model.modalbody.append('<div id="loader" style="position: absolute;bottom:0; z-index: 3; height: 60px; text-align: center; padding: 5%">Loading ...</div>');

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
    }
};

model.entity = $("#dv_table").data('entity');
model.modal = $("#"+model.entity+"modal");
model.modalbody = $("#"+model.entity+"modal").find(".modal-body");

// $("#model_new").attr("href", "#");
// $("#model_new").click(function (e) {
//     e.preventDefault();
//     model._new()
// });