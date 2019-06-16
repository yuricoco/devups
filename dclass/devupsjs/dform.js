/**
 * Created by Aurelien Atemkeng on 9/6/2018.
 */

var entityid = 0;
var dform = {
    binderror: function(error){

        model.modalbody.find("#loader").remove();
        //console.log(response.error);
        var errorarray = [];
        var keys = Object.keys(error);
        var values = Object.values(error);
        for (var i = 0; i < keys.length; i++) {
            errorarray.push( "<b>" + keys[i] + "</b> : " + values[i]+ "");
        }
        model.modalbody.prepend('<div class="alert alert-danger alert-dismissable">\n' +
            '                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\n' +
            '                                '+ errorarray.join("<br>") +'.\n' +
            '                            </div>');

    },
    callbackcreate : function (response){
        //console.log(response, "create");

        if(response.success){
            if(response.redirect)
                window.location.href = response.redirect;

            else if(response.reload)
                window.location.reload();

            $("#dv_table").find("tbody").prepend(response.tablerow);
            model._dismissmodal();
            return;
        }

        dform.binderror(response.error);
    },
    callbackupdate : function (response){
        console.log(response, "update");
        if(response.success){
            if(response.redirect)
                window.location.href = response.redirect;

            else if(response.reload)
                window.location.reload();

            $("#dv_table").find("#"+entityid).replaceWith(response.tablerow);
            model._dismissmodal();
            return;
        }

        dform.binderror(response.error);
    },
    _submit: function(el, url){
        // var formserialize = $(this).serialize();
        // console.log(formserialize);
        var actionarray = $(el).attr("action").split("/");
        var action = actionarray[1];
        var callback = function (response) { console.log(response); };
        entityid = $(el).data("id");

        if(entityid){
            //action = actionarray[1];
            //action = "update&id="+entityid;
            callback = dform.callbackupdate;
        }else{
            callback = dform.callbackcreate;
        }

        var formdata = model._formdata($(el));
        //model._post(action, formdata, callback);
        console.log(url);
        return false;
    }
};

// $("#"+model.entity+"-form").submit(function (e) {
//     e.preventDefault();
//     dform._submit(this)
// });
