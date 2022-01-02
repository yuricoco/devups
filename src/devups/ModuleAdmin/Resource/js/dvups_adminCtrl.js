//dvups_adminCtrl

model.resetcredential = function (id, el) {

    model._get("dvups_admin.resetcredential&id="+id, (response)=>{
        console.log(response);
        window.location.href = response.redirect;

    })

};