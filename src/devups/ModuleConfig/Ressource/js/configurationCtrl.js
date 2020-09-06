//configurationCtrl

model.buildConfig = function () {
    this._get("configuration.build", (response)=>{
        console.log(response);
        alert(" Constante.php file regenerated with success");
    })
};
