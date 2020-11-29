@extends('layout')
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
            height: 300px;
            border: 1px solid black;
            border-left: 0px;
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
                        FOrmulaire
                    </div>
                    <div class="btn-actions-pane-right">
                        <div class="nav">

                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <?= Form::open($emailmodel, ["action" => "$action", "method" => "post"], true) ?>

                    <div class='form-group'>
                        <label for='object'>{{t('emailmodel.name')}}</label>
                        <?= Form::input('name', $emailmodel->getName(), ['class' => 'form-control']); ?>
                    </div>
                    <div class='form-group'>
                        <label for='object'>{{t('emailmodel.title')}}</label>
                        <?= Form::input('title', $emailmodel->getTitle(), ['class' => 'form-control']); ?>
                    </div>
                    <div class='form-group'>
                        <label for='object'>{{t('emailmodel.object')}}</label>
                        <?= Form::input('object', $emailmodel->getObject(), ['class' => 'form-control']); ?>
                    </div>
                    <div class="row" id="container">
                        <div class="col-lg-6   stretch-card" id="textareacontainer">
                            <textarea id="code_css" name="code_css"></textarea>
                            <?= Form::textarea('styleressource', $emailmodel->getStyleressource(), ['id' => 'code_css', 'class' => 'form-control']); ?>
                            <?= Form::textarea('content', $emailmodel->getContent(), ['id' => 'code', 'class' => 'form-control']); ?>
                        </div>
                        <div class="col-lg-6  stretch-card" id="iframecontainer">
                            <iframe id=preview></iframe>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='contenttext'>{{t('emailmodel.contenttext')}}</label>
                        <?= Form::textarea('contenttext', $emailmodel->getContenttext(), ['class' => 'form-control']); ?>
                    </div>


                    <?= Form::submitbtn("save", ['class' => 'btn btn-success btn-block']) ?>

                    <?= Form::close() ?>
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
        var editorCss = CodeMirror.fromTextArea(document.getElementById('code_css'), {
            mode: 'text/html'
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
            preview.write(editor.getValue());
            preview.close();
            // added this line
            loadCSS();
        }

        setTimeout(updatePreview, 300);
    </script>

    <script src="{{Emailmodel::classpath()}}ressource/js/emailmodelForm.js"></script>
@endsection
