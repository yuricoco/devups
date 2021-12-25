//dvups_roleCtrl

model.updateprivilege = function(el){
    console.log("update privilege");
    model.addLoader($(el))
    model.init("dvups_role");
    model.request("dvups_:update").get(function (response) {
        console.log(response);
        model.removeLoader();
        alert(response.message);
    })

};
