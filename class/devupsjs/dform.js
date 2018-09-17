/**
 * Created by Aurelien Atemkeng on 9/6/2018.
 */

var entityid = 0;
var dform = {
    callbackcreate : function (response){
        console.log(response);
        $("#dv_table").find("tbody").prepend(response.tablerow);
        model._dismissmodal();
    },
    callbackupdate : function (response){
        console.log(response);
        $("#dv_table").find("#"+entityid).replaceWith(response.tablerow);
        model._dismissmodal();
    }
};

$("#"+model.entity+"-form").submit(function (e) {
    e.preventDefault();
    // var formserialize = $(this).serialize();
    // console.log(formserialize);
    var action = "create";
    var callback = function (response) { console.log(response); };
    entityid = $(this).data("id");

    if(entityid){
        action = "update&id="+entityid;
        callback = dform.callbackupdate;
    }else{
        callback = dform.callbackcreate;
    }

    model._post(action, $(this), callback);

});
