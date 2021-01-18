//emailmodelCtrl

model.sendmail = function (el, id){
    var email = $("#email-"+id).val();
    console.log(email);
    model._get("emailmodel.testmail&id="+id+'&email='+email, function (response){
        console.log(response);

    })
}