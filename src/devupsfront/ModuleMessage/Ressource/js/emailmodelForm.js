//cmstextForm

tinymce.init({
    selector: 'textarea#editor',
    height: 550,
    fontSize: 10,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor ',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat code | help',
    content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        // '//www.tiny.cloud/css/codepen.min.css'
    ]
});

// dform._submit = function (el, url) {
//     tinymce.triggerSave();
//
//     var action = url;
//     var callback = function (response) { console.log(response); };
//     entityid = $(el).data("id");
//
//     if(entityid){
//         this.callback = dform.callbackupdate;
//     }else{
//         this.callback = dform.callbackcreate;
//     }
//
//     var formdata = model._formdata($(el));
//
//     console.log(model.formentity);
//
//     model.entity = "cmstext";
//     model._post("cmstext."+action, formdata, callback);
//
//     return false;
// }

//            tinymce.init({selector: ".tinymce"});

//
// $('#editor')
//     .froalaEditor({
//         // Set the file upload URL.
//         imageUploadURL: 'services.php?path=cmstext.uploadimage',
//         imageManagerLoadURL: 'services.php?path=cmstext.loadimage',
//         imageManagerDeleteURL: 'services.php?path=cmstext.deleteimage',
//         //imageManagerDeleteParams: {user_id: 4219762},
//         //buttons: ["bold", "italic", "underline", "strikeThrough", "fontSize", "color", "sep", "formatBlock", "align", "insertOrderedList", "insertUnorderedList", "outdent", "indent", "sep", "selectAll", "createLink", "insertImage", "undo", "redo", "html"],
//         // imageUploadParams: {
//         //     id: 'my_editor'
//         // },
//         imageMove: true,
//         imageUploadParam: "image",
//     })
//     .on('froalaEditor.imageManager.beforeDeleteImage', function (e, editor, $img) {
//         console.log("ksldjfklsfsdlfjslfsdf");
//         $.ajax({
//             // Request method.
//             method: "GET",
//
//             // Request URL.
//             url: "services.php?path=cmstext.deleteimage&image="+$img.data('name'),
//
//             // Request params.
//             // data: {
//             //     src: $img.attr('src')
//             // }
//         })
//             .done (function (data) {
//                 console.log (data ,'image was deleted');
//             })
//             .fail (function () {
//                 console.log ('image delete problem');
//             })
//     });
//
