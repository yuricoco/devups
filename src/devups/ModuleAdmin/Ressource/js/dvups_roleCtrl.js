//dvups_roleCtrl

model.updateprivilege = function(){
    console.log("update privilege");

    model._get("dvups_:update", function (response) {
        console.log(response);
        alert(response.message);
    })

};
