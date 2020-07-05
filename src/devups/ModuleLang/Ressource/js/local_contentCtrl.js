//local_contentCtrl
model.regeneratecache = function () {

    this._get("local_content.regeneratecache", (response)=>{
        console.log(response);
        alert(response.message)
    })

}