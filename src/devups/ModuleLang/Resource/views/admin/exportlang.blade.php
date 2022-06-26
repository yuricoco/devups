@extends('admin.layout')

@section('layout_content')

    <style>
        #log-import {
            position: relative;
        }

        .loader-container {
            position: absolute;
            display: none;
            width: 50px;
            height: 50px;
            z-index: 9;
            top: 50%;
            left: 50%;
            transform: translateX(-50%);
        }

        .loader-container:before {
            width: 50px;
            height: 50px;
            margin: 0;
            border-left-color: transparent !important;
            border-top-color: transparent !important;
            content: "";
            display: inline-block;
            border-radius: 50%;
            border: 4px solid #004282;
            -webkit-animation: loading 400ms linear infinite;
            animation: spin 400ms linear infinite;
        }
    </style>

    <div class="panel">
        <h3><i class="icon icon-tags"></i> {{t('Export des langues')}}</h3>
        <div class="panel-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-1 ">
                        <form action="{{Local_content::classpath("exportlang")}}" target="_blank" method="get">
                            <div class="form-group">
                                <label>Langue source</label>
                                <select class="form-control" name="local">
                                    @foreach($langs as $lang)
                                        <option value="{{$lang->iso_code}}">{{$lang->iso_code}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Langue cible</label>
                                <select class="form-control" name="dest">
                                    @foreach($langs as $lang)
                                        <option value="{{$lang->iso_code}}">{{$lang->iso_code}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="log-export">
                                <div class="loader-container"></div>
                            </div>
                            <hr>
                            <div class="outlined text-center">

                                <button type="submit"
                                        class="btn btn-primary pa-3 ">
                                    Telecharger le fichier de lang
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4  col-lg-offset-2">

                        <form action="{{__env.('admin/api/local-content.importlang')}}" target="_blank" method="get">
                            <div class="form-group">
                                <label>Selectionnez la langue a traité:</label>
                                <select class="form-control" name="langimport">
                                    @foreach($langs as $lang)
                                        <option value="{{$lang->iso_code}}">{{$lang->iso_code}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Selectionnez le fichier de lang (.xlsx)</label>
                                <input id="filelang" accept=".xlsx" type="file" class="form-control">
                            </div>
                            <div id="log-import">
                                <div class="loader-container"></div>
                            </div>
                            <hr>
                            <div class="outlined text-center">

                                <button onclick="contentlang.importlang(this)" type="button"
                                        class="btn btn-warning  pa-3 ">
                                    IMPORTER LE FICHIER DE LANG
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("jsimport")
    <script>
        console.log(__env)
        var contentlang = {
            langs: [],
            lang: "fr",
            exportlang(el) {
                var form = $(el).parents("form")
                var local = form.find("select[name=local]").val(), dest = form.find("select[name=dest]").val()
                if (local == dest) {
                    $("#log-import").html('<div class="alert alert-danger text-center">' +
                        'la langue source et la langue de destination doivent être différentes' + "</div>");
                    alert("la langue source et la langue de destination doivent être différentes!")
                    return;
                }
                var url = //form.attr("action")
                    `&local=` + local
                    + `&dest=` + dest
                    + "&exportmodel=" + form.find("select[name=exportmodel]").val()
                console.log(url)
                model.addLoader($(el))
                var fd = new FormData();
                $("#log-export").html('<div class="alert alert-info text-center">Traitement de lang en Base de donnees ...' + "</div>");

                $("#log-export").html('<div class="alert alert-info text-center">' + " Traitement des lang des modules ...</div>");
                contentlang.ajaxserve(__env + "module" + url, fd, (response) => {
                    console.log(response);
                    if (!response.success) {
                        $("#log-import").html('<div class="alert alert-danger text-center">' + response.detail + "</div>");
                        return;
                    }
                    $("#log-export").html('<div class="alert alert-success text-center">Traitement termine télécharger le fichier va etre telecharge' + "</div>");

                    window.location.href = form.attr("action") + url;

                    model.removeLoader()

                })
                //window.location.href = url;
            },
            importlang(el, loadlang = false) {
                var form = $(el).parents("form")
                var fd = new FormData();
                var url = form.attr("action");

                /*form.find("input[type=checkbox]:checked").each(function (i, el) {
                    contentlang.langs.push(el.value)
                    fd.append("langs[]", el.value)
                })*/
                contentlang.lang = form.find("select[name=langimport]").val();
                /*if (!contentlang.langs.length) {
                    alert("vous devez selectionnez au moins une langue pour le traitement")
                    return;
                }*/
                var file = $("#filelang")[0].files[0]
                if (!file || loadlang) {
                    this.loadlang(url, 1, 1000)
                    return;
                }
                fd.append("filelang", $("#filelang")[0].files[0])

                $("#log-import").html(`<div class="alert alert-info text-center">... Chargement en cours</div>`)

                Drequest.init(form.attr("action"))
                    .data(fd)
                    .post((response) => {
                        console.log(response);
                        if (!response.success) {

                            $("#log-import").html('<div class="alert alert-danger text-center">' + response.detail + "</div>");

                            return;

                        }

                        $("#log-import").html('<div class="alert alert-success text-center">' + response.detail + " enregistrement des langues en cours ...</div>");
                        this.loadlang(url, 1, 1000)

                    })

            },
            loadlang(url, next, iteration) {
                Drequest.init(url)
                    .param({
                        lang: contentlang.lang,
                        //langs: contentlang.langs.join(),
                        next: next,
                        iteration: iteration,
                    }).get((response) => {
                    console.log(response)

                    if (!response.success) {

                        $("#log-import").html('<div class="alert alert-danger text-center">' + response.detail + "</div>");
                        return;
                    }

                    if (response.remain >= 0) {
                        $("#log-import").html('<div class="alert alert-info text-center">' + response.i + " traductions traitées ...</div>");
                        this.loadlang(url, next + iteration, iteration)
                    } else {
                        $("#log-import").html('<div class="alert alert-success text-center"> Traitement de ' + response.i + " traductions terminés!</div>");
                        alert(" Traitement de " + response.i + " traductions terminés!")
                        window.location.reload()
                    }
                })
            },
            _get(url, data, callback) {
                $.ajax({
                    url: url,
                    data: data,
                    method: "GET",
                    dataType: "json",
                    success: callback,
                    error: function (e) {
                        console.log(e);//responseText
                        callback(e.responseText)
                    }
                });
            },
            ajaxserve: function (url, fd, callback) {

                $.ajax({
                    url: url,
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: "POST",
                    dataType: "json",
                    success: callback,
                    error: function (e) {
                        console.log(e);//responseText
                        model.modalbody.html(e.responseText);
                    }
                });

            },
        }
    </script>
@endsection