//cmstextForm
tinymce.init({
    selector: 'textarea#editor',
    height: 550,
    fontSize: 10,
    relative_urls : false,
    remove_script_host : false,
    convert_urls : true,
    menubar: false,
    plugins: [
        'advlist autolink lists link image preview anchor ',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help code',
    content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        // '//www.tiny.cloud/css/codepen.min.css'
    ]
});
function fallbackCopyTextToClipboard(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;

    // Avoid scrolling to bottom
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";

    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
        console.log('Fallback: Copying text command was ' + msg);
    } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
    }

    document.body.removeChild(textArea);
}
function copyTextToClipboard(text) {
    if (!navigator.clipboard) {
        fallbackCopyTextToClipboard(text);
        return;
    }
    navigator.clipboard.writeText(text).then(function() {
        console.log('Async: Copying to clipboard was successful!');
    }, function(err) {
        console.error('Async: Could not copy text: ', err);
    });
}

var cmstext = {
    block: null,
    optionimage: null,
    lang: "fr",
    setcontent() {
        tinymce.triggerSave();
        this.block.html(tinymce.activeEditor.getContent());
        this._dismissmodal()
    },
    menu() {
        return `<table class="dv-block-action">
        <tr>
            <td>
                <button onclick="cmstext.startmove()" >move</button>
            </td>
            <td>
                <button onclick="cmstext.addimageblock('append')">add image</button>
            </td>
            <td><button onclick="cmstext.addblock(this, 'prepend')">ajouter un block avant</button></td>
            <td><button onclick="cmstext.addblock(this, 'append')">ajouter un block apres</button></td>
            <td><button onclick="cmstext.editblock(this)">edit block</button></td>
            <td><button onclick="cmstext.deleteblock(this)" >remove block</button></td>
        </tr>
    </table>`
    },
    changelang(el) {
        $(".dv-editable").hide()
        $("#dv-editable-" + el.value).show()
        $(".dv-title").hide()
        $("#dv-title-" + el.value).show()
        this.lang = el.value;
    },
    addblock(block, option) {
        if (option === 'prepend') {
            $(block).parents(".dv-block").before(`<div class="dv-block" contenteditable >your content here ${this.menu()} </div>`)
        } else if (option === 'append') {
            $(block).parents(".dv-block").after(`<div class="dv-block" contenteditable >your content here ${this.menu()} </div>`)
        } else
            $("#dv-editable-" + this.lang).append(`<div class="dv-block" contenteditable >your content here ${this.menu()} </div>`)
        /*$("#dv-editable-en").append(`<div class="dv-block" contenteditable >your content here <table class="dv-block-action">
        <tr>
            <td><button onclick="cmstext.editblock(this)">edit block</button></td>
            <td><button onclick="cmstext.deleteblock(this)" >remove block</button></td>
        </tr>
    </table></div>`)*/
    },
    submit(el) {
        tinymce.triggerSave();
        //model.addLoader($(el))
        var form = $("#cmstext-form");
        dform._submit(form, form.data("api"), (response) => {
            console.log(response);
            $.notify("Modification enregistrées", "info")
        })
    },
    save(el) {
        var dvblocks = $(".dv-block")
        dvblocks.attr("contenteditable", false)
        /*$("#dv-editable-fr").find(".dv-block").each((i, el) => {
            console.log(i, el)
            content_fr +=
        })*/
        $(".card-body .dv-block").find(".dv-block-action").remove()
        //model.addLoader($(el))
        var form = new FormData();
        form.append("cmstext_form[content][fr]", $("#dv-editable-fr").html())
        form.append("cmstext_form[content][en]", $("#dv-editable-en").html())

        model.addLoader($(el))
        Drequest.init(__env + "admin/api/cmstext.update?id=" + cmstextid)
            .data(form)
            .post((response) => {
                console.log(response);
                $.notify("Modification enregistrées", "info")
                cmstext.init()
                model.removeLoader()
            })
    },
    editblock(el) {
        this.block = $(el).parents(".dv-block")
        this.block.find(".dv-block-action").remove();
        tinymce.activeEditor.setContent(this.block.html())
        //$("textarea#editor").val(this.block.html());

        $("#commonbox").css('display', "block");
    },
    _dismissmodal() {
        this.block.append(this.menu())
        $("#commonbox").css('display', "none");
    },
    addimageblock(option){
        this.optionimage = option
        $("#image-form").show()
    },
    _dismissimage(){
        $("#image-form").hide()
    },
    copyimage(image) {
        copyTextToClipboard(image)
        this.addimageblock()
        $("#image-link").val(image)
    },
    setimage() {
        var image = $("#image-link").val()
        if (this.optionimage === 'append') {
            $(el).parents(".dv-block").append(`<div class="dv-block" contenteditable ><img style="max-width: 100%" src="${image}" /> ${this.menu()}</div>`)
        } else
            $("#dv-editable-" + this.lang).append(`<div class="dv-block" contenteditable ><img style="max-width: 100%" src="${image}" /> ${this.menu()}</div>`)
        this._dismissimage()
    },
    deleteblock(el) {
        $(el).parents(".dv-block").remove()
    },
    init() {
        $(".dv-block").attr("contenteditable", true)
        $(".dv-block").each((i, el) => {
            //console.log(i, el)
            $(el).append(this.menu())
        })

        $("#image-form").hide()
        $(".dv-editable").hide()
        $("#dv-editable-"+this.lang).show()
        $(".dv-title").hide()
        $("#dv-title-"+this.lang).show()

    },
    startmove(){
        $( "#dv-editable-fr" ).sortable({
            stop: function( event, ui ) {
                console.log("stop sortable")
                cmstext.stopmove()
            }
        });
        $( "#dv-editable-en" ).sortable({
            stop: function( event, ui ) {
                cmstext.stopmove()
            }
        });
    },
    stopmove(){
        $( "#dv-editable-fr" ).sortable( "destroy" );
        $( "#dv-editable-en" ).sortable( "destroy" );
    }
}
cmstext.init()
$("#commonbox").css('display', "none");