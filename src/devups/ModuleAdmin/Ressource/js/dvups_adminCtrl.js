//dvups_adminCtrl

// class dvups_adminCtrl extends

model.resetcredential = function (id, el) {

    model._get("dvups_admin.resetcredential&id="+id, (response)=>{
        console.log(response);
        window.location.href = response.redirect;

    })

};