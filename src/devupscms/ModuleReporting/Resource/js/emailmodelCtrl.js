//emailmodelCtrl

model.sendmail = function (el, id) {
    var email = $("#email-" + id).val();
    model.init("emailmodel");
    model.request("emailmodel.testmail&id=" + id + '&email=' + email).get((response) => {
        console.log(response);

    })
}