var dialogbox = function () {
    self = this;

    self.title = "";
    self.body = ``;
    self.bodycontent = ``;
    self.footer = ``;
    self.footercontent = ``;
    self.spinner = '<span class="spinner-border spinner-border-sm mr-2" role="status"></span>';
    self.loader = `<div style="height: 150px; text-align: center; padding: 5%">Loading ...</div>`;

    self.addLoader = function () {
        self.dialog.find("button").attr("disabled", true);
        //self.dialog.find("button").prepend(self.spinner);
        self.body.prepend(self.spinner);
    };
    self.removeLoader = function () {

        self.dialog.find("button").attr("disabled", false);
        self.body.find(".spinner-border").remove();

    };
    self.init = function (){
        self.dialog = $(self.render());
        self.body = self.dialog.find(".card-body")
    };
    self.setcontent = function (content = ""){
        if(!content) {
            self.body.html(self.bodycontent)
            return ;
        }
        self.body.html(content)
    };
    self.show = function (server = true){
        self.dialog = $(self.render());
        self.body = self.dialog.find(".card-body")
        if(server)
            self.bodycontent = self.loader;
        self.dialog.css('display',"inline-flex");
        $("#dialog-container").html(self.dialog);
        //self.addLoader();
    };
    self.dismiss = function (empty = true) {
        // model.modalbody.html("");
        // model.modal.modal("hide");
        if (empty)
            self.bodycontent = '';
        
        $("#dialog-container").html("");
        self.dialog.css('display', "none");
    };
    self.dialoghead = function (){
        return `
        <div class="card-header">
            ${self.title}
            <button onclick="self.dismiss()" type="button" class="swal2-close" aria-label="Close this dialog" style="display: block;">×</button>
        </div>
        `;
    };
    self.dialogbody = function (){
        return `
        <div class="card-body">
            ${self.bodycontent}
        </div>
        `;
    };
    self.dialogfooter = function (){
        return `
        <div class="card-footer">
            ${self.footercontent}
        </div>
        `;
    };
    self.render = function (entity){
        var head = self.dialoghead();
        var body = self.dialogbody();
        var footer = self.dialogfooter();
        return `
    <div id="${entity}box" class="swal2-container swal2-fade swal2-shown" style="overflow-y: auto;">
        <div role="dialog" aria-labelledby="swal2-title" aria-describedby="swal2-content" class="swal2-modal swal2-show dv_modal" tabindex="1"
             style="">
            <div class="main-card mb-3 card  box-container">
                ${head}
                
                ${body}
                    
                ${footer}
            </div>

        </div>
    </div>
        `;
    }
}