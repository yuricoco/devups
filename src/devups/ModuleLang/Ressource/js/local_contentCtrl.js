//local_contentCtrl
model.regeneratecache = function () {
    model.init("local_content")
    model.request("local_content.regeneratecache").get((response)=>{
        console.log(response);
        alert(response.message)
    })

}