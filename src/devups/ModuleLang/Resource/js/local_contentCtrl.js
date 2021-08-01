//local_contentCtrl
model.regeneratecache = function (event) {

    model.addLoader($(event.target));
    model.init("local_content")
    model.request("local_content.regeneratecache").get((response)=>{
        console.log(response);
        model.removeLoader();
        alert(response.message)
    })

}