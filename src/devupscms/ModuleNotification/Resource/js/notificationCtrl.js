//notificationCtrl


model.sendsms = function (el, id) {
    model.addLoader($(el))
    var email = $("#notification-" + id).val();
    model.init("notificationtype");
    model.request("notificationtype.test&id=" + id + '&number=' + email).get((response) => {
        model.removeLoader();
        console.log(response);

    })
}

