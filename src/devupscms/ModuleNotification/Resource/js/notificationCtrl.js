//notificationCtrl


model.sendsms = function (el, id) {
    var email = $("#notification-" + id).val();
    model.init("notificationtype");
    model.request("notificationtype.test&id=" + id + '&number=' + email).get((response) => {
        console.log(response);

    })
}

