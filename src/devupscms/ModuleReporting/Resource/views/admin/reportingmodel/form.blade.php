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

                        <select onchange="reportingmodel.changelang(this)">
                            @foreach($langs as $lang)
                                <option value="{{$lang->iso_code}}">{{$lang->iso_code}}</option>
                            @endforeach
                        </select>
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

                    <div class="row">
                        @foreach($langs as $lang)
                            <div id="container-{{$lang->iso_code}}" class="col-lg-6   stretch-card dv-editable">

                                <div class='form-group'>
                                    <button class="btn btn-primary" onclick="reportingmodel.loadFromFile(this)">
                                        Charger le contenu depuis le fichier {{$reportingmodel->name}}_{{$lang->iso_code}}.html
                                    </button>
                                    <button class="btn btn-warning" onclick="saveToFile(this)">
                                        Enregistrer le contenu dans le fichier {{$reportingmodel->name}}_{{$lang->iso_code}}.html
                                    </button>
                                </div>
                                <div class='form-group'>
                                    <div class='alert alert-info'>
                                        use @{{variable}} to add dynamic text in the content.
                                    </div>

                                    <?= Form::textarea('content', $reportingmodel->content[$lang->iso_code],
                                        ['id' => 'code-' . $lang->iso_code, 'class' => 'form-control', 'placeholder' => 'Your html code here ...']); ?>

                                </div>
                                <div class='form-group'>
                                    <label for='contenttext'>{{t('Content version text (use the \n to go to line) ')}}</label>
                                    <?= Form::textarea('contenttext', $reportingmodel->contenttext[$lang->iso_code],
                                        ['class' => 'form-control', 'id' => 'contenttext-' . $lang->iso_code]); ?>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-lg-6  stretch-card">
                            <div class="text-right">
                                <a target="_blank"
                                   href="{{Reportingmodel::classpath(" reportingmodel/preview?id=".$reportingmodel->getId())}}"
                                   class="btn btn-info float-lg-right btn-block"> Preview </a>
                            </div>
                            <div class='form-group'>
                                <iframe id='preview'></iframe>
                            </div>
                            <div class='form-group'>
                                <button type="button" onclick="reportingmodel.updateEditor()"
                                        class="btn btn-block btn-info">update
                                    Editor
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?= Form::submitbtn("Save and continue update", ['onclick' => 'reportingmodel.submit(this)', 'type' => 'button', 'class' => 'btn btn-info btn-block']) ?>

                    <?= Form::submitbtn("save and back to list", ['class' => 'btn btn-success ']) ?>

                    <?= Form::close() ?>
                    <hr>
                    <div class='form-group'>
                        <label for='object'>{{t('Test l envoie de mail')}}</label>
                        {!! $reportingmodel->getTest() !!}
                    </div>
                </div>
                <iframe hidden id="template">{!! Genesis::getView("email") !!}</iframe>
            </div>
        </div>
    </div>

@endsection

@section('jsimport')

    <script src="{{__admin}}plugins/codemirror/lib/codemirror.js"></script>
    <script src="{{__admin}}plugins/codemirror/mode/xml/xml.js"></script>
    <script src="{{__admin}}plugins/codemirror/mode/javascript/javascript.js"></script>
    <script src="{{__admin}}plugins/codemirror/mode/css/css.js"></script>
    <script src="{{__admin}}plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="<?= CLASSJS ?>dform.js"></script>
    <script>
        let report = @json($reportingmodel);
    </script>
    <script src="{{Reportingmodel::classpath()}}Resource/js/reportingmodelCtrl.js"></script>
    <script src="{{Reportingmodel::classpath()}}Resource/js/reportingmodelForm.js"></script>
@endsection
