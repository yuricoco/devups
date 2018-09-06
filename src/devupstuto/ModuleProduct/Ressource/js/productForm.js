/**
 * Created by Aurelien Atemkeng on 7/25/2018.
 */

$("#"+model.entity+"-form").submit(function (e) {
    e.preventDefault();
    // var formserialize = $(this).serialize();
    // console.log(formserialize);
    var action = "create";
    var callback = function (response) { console.log(response); };
    var entityid = $(this).data("id");

    if(entityid){
        action = "update&id="+entityid;
        callback = callbackupdate;
    }else{
        callback = callbackcreate;
    }

    model._post(action, $(this), callback);

});

var callbackcreate = function (response){
    console.log(response);
    // set loader
    $("#dv_table").find("tbody").prepend(response.newrow);
}

var callbackupdate = function (response){
    console.log(response);
    model.dismissmodal();
    $("#dv_table").find("#"+response.product.id).replaceWith(response.updaterow);
}
