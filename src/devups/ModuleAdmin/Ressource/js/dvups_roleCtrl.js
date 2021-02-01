//dvups_roleCtrl

model.updateprivilege = function(){
    console.log("update privilege");

    model.init("dvups_role");
    model.request("dvups_:update").get(function (response) {
        console.log(response);
        alert(response.message);
    })

};
