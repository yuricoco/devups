@extends('admin.layout')
@section('title', 'List')


@section('cssimport')
    <link rel=stylesheet href={{__admin}}plugins/codemirror/lib/codemirror.css>
    <style type=text/css>
        .CodeMirror {
            width: 100%;
            border: 1px solid black;
            height: 500px;
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
                        ["data-api" => Reportingmodel::classpath("services.php?path=reportingmodel.update?id=" . $reportingmodel->getId()),
                            "action" => "$action", "method" => "post"], true) ?>

                    <div class="row" id="container">
                        <div class="col-lg-6   stretch-card" id="textareacontainer">

                            <div class='form-group'>
                                <button class="btn btn-primary" onclick="loadFromFile(this)">
                                    Charger le contenu depuis le fichier {{$reportingmodel->name}}.html
                                </button>
                                <button class="btn btn-warning" onclick="saveToFile(this)">
                                    Enregistrer le contenu dans le fichier {{$reportingmodel->name}}.html
                                </button>
                            </div>
                            <div class='form-group'>
                                <div class='alert alert-info'>
                                    use @{{variable}} to add dynamic text in the content.
                                </div>

                                <?= Form::textarea('content', $reportingmodel->getContent(),
                                    ['id' => 'code', 'class' => 'form-control', 'placeholder' => 'Your html code here ...']); ?>


                            </div>
                        </div>
                        <div class="col-lg-6  stretch-card" id="iframecontainer">
                            <div class="text-right">
                                <a target="_blank"
                                   href="{{Reportingmodel::classpath(" reportingmodel/preview?id=".$reportingmodel->getId())}}"
                                   class="btn btn-info float-lg-right btn-block"> Preview </a>
                            </div>
                            <div class='form-group'>
                                <iframe id=preview></iframe>
                            </div>
                            <div class='form-group'>
                                <button type="button" onclick="updateEditor()" class="btn btn-block btn-info">update
                                    Editor
                                </button>
                            </div>
                            <div class='form-group'>
                                <label for='contenttext'>{{t('Content version text (use the \n to go to line) ')}}</label>
                                <?= Form::textarea('contenttext', $reportingmodel->getContenttext(), ['class' => 'form-control']); ?>
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
                        <div class='form-group'>
                            <label for='object'>{{t('reportingmodel.object')}}</label>
                            <?= Form::input('object', $reportingmodel->getObject(), ['class' => 'form-control']); ?>
                        </div>
                        <div class='form-group'>
                            <label for='object'>{{t('Description')}}</label>
                            <?= Form::input('description', $reportingmodel->description, ['class' => 'form-control']); ?>
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
                <iframe hidden id="template">{!! Genesis::getView("email") !!}</iframe>
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
        var template = $("#template").html();
        // Initialize CodeMirror editor with a nice html5 canvas demo.
        var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
            mode: 'text/html'
        });

        editor.on("change", function () {
            clearTimeout(delay);
            delay = setTimeout(updatePreview, 300);
        });

        function updatePreview() {
            var previewFrame = document.getElementById('preview');
            var preview = previewFrame.contentDocument || previewFrame.contentWindow.document;
            preview.open();
            preview.write(
                template.replace(/{yield}/g, editor.getValue().replace(/{__env}/g, __env))

            );
            preview.close();
            $(preview.getElementsByTagName("body")).attr("contenteditable", true)
            // added this line
        }

        function updateEditor() {
            var previewFrame = document.getElementById('preview');
            var preview = previewFrame.contentDocument || previewFrame.contentWindow.document;
            //preview.open();
            //console.log($(preview.getElementsByTagName("html")).html())
            // added this line
            editor.setValue($(preview.getElementById("yield")).html())
            // document.getElementById('code').value = $(preview.getElementsByTagName("html")).html()
        }

        function loadFromFile(el) {
            model.addLoader($(el))
            Drequest.init("{{__env}}admin/api/reportingmodel.load-content?name={{$reportingmodel->name}}")
                .get((response) => {
                    model.removeLoader()
                    if (response.success)
                        editor.setValue(response.content)
                    else{
                        alert(response.detail)
                    }
                })
        }

        var reportingmodel = {
            submit(el) {

                var form = $("#cmstext-form");
                dform._submit(form, form.data("api"), (response) => {
                    console.log(response);
                    $.notify("Modification enregistrées", "info")
                })
            }
        }

        setTimeout(updatePreview, 300);
    </script>

    <script src="{{Reportingmodel::classpath()}}resource/js/reportingmodelCtrl.js"></script>
    <script src="{{Reportingmodel::classpath()}}resource/js/reportingmodelForm.js"></script>
@endsection
