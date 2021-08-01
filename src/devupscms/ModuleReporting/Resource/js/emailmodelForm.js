//emailmodelForm

function getFrameContents() {
    var iFrame = document.getElementById('preview');
    var iFrameBody;
    if (iFrame.contentDocument) { // FF
        iFrameBody = iFrame.contentDocument.getElementsByTagName('body')[0];
    } else if (iFrame.contentWindow) { // IE
        iFrameBody = iFrame.contentWindow.document.getElementsByTagName('body')[0];
    }
    //alert(iFrameBody.innerHTML);
    return iFrameBody
}

model.toPDF = function (){

    // source can be HTML-formatted string, or a reference
    // to an actual DOM element from which the text will be scraped.
    var dialog = new dialogbox();
    dialog.title = "sample pdf maker 2.0";

    dialog.show()
    dialog.addLoader()
    html2canvas(getFrameContents()).then(function(canvas) {
        dialog.setcontent(canvas);
    });

}