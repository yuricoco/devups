/**
 * Created by Aurelien Atemkeng on 7/26/2018.
 */

var databinding = {
    bindmodal: function (data) {
        //console.log(data);
        $("#"+model.entity+"modal").find(".modal-body").html(data);
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
    entity : null,
    _new: function (callback) {

        $.get("services.php?path="+this.entity+"._new", function (response) {
            console.log(response);
            databinding.checkrenderform(response);
        }, 'json');//, 'json'

    },
    _edit: function (id, callback) {
        $.get("services.php?path="+this.entity+"._edit&id="+id, function (response) {
            databinding.checkrenderform(response);
        }, 'json');//, 'json'
    },
    _delete: function ($this, id, callback) {

        var $tr = $($this).parents("tr");
        var $td = $($this).parents("td");

        if(!confirm('Voulez-vous Supprimer?')) return false;

        $.get("services.php?path="+this.entity+"._delete&id="+id, function (response) {
            console.log(response);
            $tr.remove();
            if(callback)
                callback();

        }, 'json');//, 'json'

    },
    _show: function (id, callback) {

        $.get("services.php?path="+this.entity+"._show&id="+id, function (response) {
            databinding.bindmodal(response);
        }, 'html');//, 'json'

    }
};

model.entity = $("#dv_table").data('entity');
$("#model_new").attr("href", "#");
$("#model_new").click(function (e) {
    e.preventDefault();
    model._new()
});