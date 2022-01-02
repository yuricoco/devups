@extends('admin.layout')
@section('title', 'List')


@section('cssimport')
    <link rel=stylesheet href={{__admin}}plugins/codemirror/lib/codemirror.css>
    <style type=text/css>
        .CodeMirror {
            width: 100%;
            border: 1px solid black;
        }

        iframe {
            width: 100%;
            height: 500px;
            border: 1px solid #ccc;

        }
    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12 col-md-12  stretch-card">
            <div class="card">
                <div class="card-header-tab card-header">
                    <div class="card-header-title">
                        <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                        Email model : {{$reportingmodel->getName()}}
                    </div>
                    <div class="btn-actions-pane-right">
                        <div class="nav">
                            <a href="{{Reportingmodel::classpath("reportingmodel/index")}}">retour a la liste</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <?= Form::open($reportingmodel,
                        ["data-api" => Reportingmodel::classpath("services.php?path=reportingmodel.update?id=".$reportingmodel->getId()),
                            "action" => "$action", "method" => "post"], true) ?>

                    <div class="row" id="container">
                        <div class="col-lg-6   stretch-card" id="textareacontainer">
                            <div class="row">

                                <div class='col-lg-12 form-group'>
                                    <label >
                                        style of the mail
                                    </label>
                                    <?= Form::textarea('style', $reportingmodel->getStyle(),
                                        ['id' => 'code_css', 'class' => 'form-control', 'placeholder' => 'Your css code here ...']); ?>
                                </div>
                                <div class='col-lg-12 form-group'>
                                    <div class='alert alert-info'>
                                        use @{{variable}} to add dynamic text in the content.
                                    </div>
                                    <ul class="nav nav-tabs nav-justified " id="myTab" role="tablist">
                                        <li class="nav-item text-center">
                                            <a class="nav-link text-center" id="mail-body-tab"
                                               data-toggle="tab" href="#mail-body"
                                               role="tab" aria-controls="mail-body" aria-selected="true"> Body
                                            </a>
                                        </li>
                                        <li class="nav-item text-center">
                                            <a class="nav-link text-center" id="mail-header-tab"
                                               data-toggle="tab" href="#mail-header"
                                               role="tab" aria-controls="mail-header" aria-selected="false"> Header
                                            </a>
                                        </li>
                                        <li class="nav-item text-center">
                                            <a class="nav-link text-center" id="mail-footer-tab"
                                               data-toggle="tab" href="#mail-footer"
                                               role="tab" aria-controls="mail-footer" aria-selected="false"> Footer
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane show " id="mail-body" role="tabpanel"
                                             aria-labelledby="mail-body-tab">
                                            <?= Form::textarea('content', $reportingmodel->getContent(),
                                                ['id' => 'code', 'class' => 'form-control', 'placeholder' => 'Your html code here ...']); ?>

                                        </div>
                                        <div class="tab-pane " id="mail-header" role="tabpanel"
                                             aria-labelledby="mail-header-tab">
                                            <?= Form::textarea('contentheader', $reportingmodel->getContentheader(),
                                                ['id' => 'codeheader', 'class' => 'form-control', 'placeholder' => 'Your html code here ...']); ?>

                                        </div>
                                        <div class="tab-pane " id="mail-footer" role="tabpanel"
                                             aria-labelledby="mail-footer-tab">
                                            <?= Form::textarea('contentfooter', $reportingmodel->getContentfooter(),
                                                ['id' => 'codefooter', 'class' => 'form-control', 'placeholder' => 'Your html code here ...']); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6  stretch-card" id="iframecontainer">
                            <div class="row">

                            <div class="col-lg-12 text-right" >
                                <a target="_blank" href="{{Reportingmodel::classpath(" reportingmodel/preview?id=".$reportingmodel->getId())}}" class="btn btn-info float-lg-right btn-block"> Preview </a>
                            </div>
                            <div class='col-lg-12 form-group'>
                                <iframe id=preview></iframe>
                            </div>
                            <div class='col-lg-12 form-group'>
                                <button type="button" onclick="updateEditor()" class="btn btn-block btn-info">update Editor</button>
                            </div>
                            <div class='col-lg-12 form-group'>
                                <label for='contenttext'>{{t('Content version text (use the \n to go to line) ')}}</label>
                                <?= Form::textarea('contenttext', $reportingmodel->getContenttext(), ['class' => 'form-control']); ?>
                            </div>
                        </div>
                        </div>
                    </div>
                    <hr>

                    <div class='form-group'>
                        <div class='form-group'>
                            <label for='object'>{{t('reportingmodel.name')}}</label>
                            <?= Form::input('name', $reportingmodel->getName(), ['class' => 'form-control']); ?>
                        </div>
                        <div class='form-group'>
                            <label for='object'>{{t('reportingmodel.title')}}</label>
                            <?= Form::input('title', $reportingmodel->getTitle(), ['class' => 'form-control']); ?>
                        </div>
                    </div>

                    <?= Form::submitbtn("Save and continue update", ['onclick' => 'reportingmodel.submit(this)', 'type' => 'button', 'class' => 'btn btn-info btn-block']) ?>

                    <?= Form::submitbtn("save and back to list", ['class' => 'btn btn-success ']) ?>

                    <?= Form::close() ?>
                    <hr>
                    <div class='form-group'>
                        <label for='object'>{{t('Test l envoie de mail')}}</label>
                        {!! $reportingmodel->getTest() !!}
                    </div>
                </div>

                <button class="btn btn-info" onclick="model.toPDF()">to pdf</button>
            </div>
        </div>
    </div>

@endsection

@section('jsimport')

    <script src="{{__admin}}plugins/html2canvas.min.js"></script>
    <script src="{{__admin}}plugins/codemirror/lib/codemirror.js"></script>
    <script src="{{__admin}}plugins/codemirror/mode/xml/xml.js"></script>
    <script src="{{__admin}}plugins/codemirror/mode/javascript/javascript.js"></script>
    <script src="{{__admin}}plugins/codemirror/mode/css/css.js"></script>
    <script src="{{__admin}}plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script>
        var delay;
        // Initialize CodeMirror editor with a nice html5 canvas demo.
        var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
            mode: 'text/html'
        });
        var editorheader = CodeMirror.fromTextArea(document.getElementById('codeheader'), {
            mode: 'text/html'
        });
        var editorfooter = CodeMirror.fromTextArea(document.getElementById('codefooter'), {
            mode: 'text/html'
        });
        var editorCss = CodeMirror.fromTextArea(document.getElementById('code_css'), {
            mode: 'text/css'
        });
        editor.on("change", function () {
            clearTimeout(delay);
            delay = setTimeout(updatePreview, 300);
        });

        function loadCSS() {
            var $head = $("#preview").contents().find("head");
            $head.html("<style>" + editorCss.getValue() + "</style>");
        };

        function updatePreview() {
            var previewFrame = document.getElementById('preview');
            var preview = previewFrame.contentDocument || previewFrame.contentWindow.document;
            preview.open();
            preview.write(
                editorheader.getValue().replace(/{__env}/g, __env)+
                editor.getValue().replace(/{__env}/g, __env)+
                editorfooter.getValue().replace(/{__env}/g, __env)
            );
            preview.close();
            $(preview.getElementsByTagName("body")).attr("contenteditable", true)
            // added this line
            loadCSS();
        }

        function updateEditor() {
            var previewFrame = document.getElementById('preview');
            var preview = previewFrame.contentDocument || previewFrame.contentWindow.document;
            //preview.open();
            //console.log($(preview.getElementsByTagName("html")).html())
            // added this line
            editor.setValue("<body>"+$(preview.getElementsByTagName("body")).html()+"</body>")
            // document.getElementById('code').value = $(preview.getElementsByTagName("html")).html()
        }


        var reportingmodel = {
            submit(el) {

                var form = $("#cmstext-form");
                dform._submit(form, form.data("api"), (response)=>{
                    console.log(response);
                    $.notify("Modification enregistrées", "info")
                })
            }
        }

        setTimeout(updatePreview, 300);
    </script>

    <script src="{{Reportingmodel::classpath()}}resource/js/reportingmodelForm.js"></script>
@endsection
