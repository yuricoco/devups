@extends('admin.layout')
@section('title', 'List')


@section('cssimport')

    {!! Form::addcss(__admin.'plugins/jquery-ui-1.12.1/jquery-ui.min') !!}
    <style>
        .dv-block {
            position: relative;
            padding: 15px;
            margin-bottom: 15px;
        }

        .dv-block:hover {
            border: 1px solid #5b5b5b;
        }

        .dv-block-action {
            display: none;
        }

        .dv-block:hover .dv-block-action {
            display: block;
            position: absolute;
            bottom: 100%;
            right: 0;
            z-index: 10;
        }
        #image-form{
            position: sticky;
            width: 500px;
            bottom: 100px;
            left: 30%;
            z-index: 10;
        }
    </style>

@endsection

@section('content')

    <div class="row">
        <div class="col-lg-9 col-md-12  stretch-card">
            <div class="card">
                <div class="card-header-tab card-header">
                    <div class="">
                        <div class="d-sm-flex justify-content-between align-items-start">
<div class="row">
                            <div class="col-lg-12 col-md-12">
                                {{$cmstext->reference}}
                            </div>
                            <div class="col-lg-4 col-md-12 text-right">
                                <select onchange="cmstext.changelang(this)">
                                    @foreach($langs as $lang)
                                        <option value="{{$lang->iso_code}}">{{$lang->iso_code}}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary " onclick="cmstext.save(this)">save</button>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div style="position: relative" class="card-body">
                    @foreach($langs as $lang)
                        <h3 id="dv-title-{{$lang->iso_code}}" class="dv-title"> {{$cmstext->title[$lang->iso_code]}}</h3>
                        <div data-lang="{{$lang->iso_code}}" id="dv-editable-{{$lang->iso_code}}"
                             class="dv-editable lang-{{$lang->iso_code}}">
                            {!! $cmstext->content[$lang->iso_code] !!}
                        </div>
                    @endforeach
                    <table>
                        <tr>
                            <td>
                                <button onclick="cmstext.addblock()">new block</button>
                            </td>
                            <td>
                                <input accept=".jpg, .png, .jpeg" hidden onchange="cmstext.setimage(this)" type="file" id="image">
                                <button onclick="document.getElementById('image').click()">add image</button>
                            </td>
                        </tr>
                    </table>

                        <div id="image-form" class="card">
                            <div class="card-header">.

                                <button onclick="cmstext._dismissimage()" type="button" class="swal2-close"
                                        aria-label="Close this dialog" style="display: block;">×
                                </button>
                            </div>
                            <div class="card-body">
                                <button onclick="cmstext.setimage()">Update</button>
                                <hr>
                                <input type="text" id="image-link">
                                <input type="text" placeholder="width auto max 100%" id="image-width">
                                <input type="text" placeholder="height auto" id="image-height">
                            </div>
                        </div>

                </div>
            </div>
        </div>

        <div class="col-lg-3">
            {!! Dv_imageTable::init(new Dv_image())
->buildcontenttable()
->setModel("content")
->render() !!}
        </div>
    </div>
    <div id="commonbox" class="swal2-container swal2-fade swal2-shown" style="display:block; overflow-y: auto;">
        <div role="dialog" aria-labelledby="swal2-title" aria-describedby="swal2-content"
             class="swal2-modal swal2-show dv_modal" tabindex="1"
             style="">
            <div class="main-card mb-3 card  box-container">
                <div class="card-header">.

                    <button onclick="cmstext._dismissmodal()" type="button" class="swal2-close"
                            aria-label="Close this dialog" style="display: block;">×
                    </button>
                </div>
                <div class="card-body">
                    <button onclick="cmstext.setcontent()">Update</button>
                    <hr>
                    <textarea id="editor"></textarea>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('jsimport')

    <script>
        var cmstextid = {{$cmstext->id}};
    </script>
    <?= Form::addDformjs() ?>
    {!! Form::addjs(__admin.'plugins/tinymce.min') !!}
    {!! Form::addjs(__admin.'plugins/jquery-ui-1.12.1/jquery-ui.min') !!}
    <?= Form::addjs(Cmstext::classpath('Resource/js/cmstextForm')) ?>

@endsection
