
$(document).ready(function () {

    model._post = function (action, form, callback) {
        var formdata = this._formdata(form);
        $.ajax({
            url: __env + "services.php?path=user." + action,
            data: formdata,
            cache: false,
            contentType: false,
            processData: false,
            method: "POST",
            dataType: "json",
            success: callback,
            error: function (e) {
                console.log(e.responseText);//responseText
                //model.modalbody.html(e.responseText);
            }
        });
    }

    $("#user-form").submit(function (e) {
        e.preventDefault();
        console.log(__formaction);
        $("#valideform").html('<i class="fa fa-spinner" ></i> ... en cours');
        model._post(__formaction, $(this), callback);

    });

});