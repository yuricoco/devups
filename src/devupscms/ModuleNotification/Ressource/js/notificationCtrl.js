//notificationCtrl

model.sendmail = function (el, id){
    var email = $("#member-"+id).val();
    console.log(email);
    model._get("notification.test&id="+id+'&ids='+email, function (response){
        console.log(response);
    })
}
