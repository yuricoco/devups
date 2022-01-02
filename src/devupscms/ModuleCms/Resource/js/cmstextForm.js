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
    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help code',
    content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        // '//www.tiny.cloud/css/codepen.min.css'
    ]
});

var cmstext = {
    submit(el) {
        tinymce.triggerSave();
        //model.addLoader($(el))
        var form = $("#cmstext-form");
        dform._submit(form, form.data("api"), (response)=>{
            console.log(response);
            $.notify("Modification enregistrées", "info")
        })
    }
}
