<script src="{{__admin}}plugins/notify.min.js"></script>
<script src="{{__env}}web/app/routing.js"></script>
<script src="{{__env}}web/app/jsPDF.js"></script>

<script>
    $("#btn-payment").hide();
</script>

@if(getadmin()->getId() && getadmin()->dvups_role->hydrate()->is("admin") )

    <div data-url="" id="debugpanel" class=" top-banner">
        <style>
            body {
                padding-bottom: 100px;
            }

            #debugpanel {
                position: fixed;
                bottom: 0;
                width: 100%;
                right: 0;
                z-index: 10000;
                background: #333;
                box-shadow: 1px 1px 3px #0c0b0f;
            }

            #debugpanel ul {
                list-style: none;
            }

            #debugpanel li {
                padding: 10px;
                display: inline-block;
                color: white !important;
            }

            #debugpanel li a {
                color: white !important;
            }
        </style>
        <div class="clearfix box-product full-width top-padding-default bg-gray">
            <div class="clearfix container-web">
                <div class="row">
                    <nav class="">
                        <a class="navbar-brand" href="#">{!! tt("Debug panel") !!}</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="sf-menu sf-js-enabled sf-arrows">
                                <li class="nav-item">

                                    @if (isset($_SESSION['debuglang']) && $_SESSION['debuglang'])
                                        <a title="{{t("Desactive le mode debug.")}}" class="nav-link"
                                           href="{{route("translatedebug")}}">{!! tt("Desactiver le mode debug")!!}</a>
                                    @else
                                        <a title='{{ t("Permet de voir la reference des text de traduction pour facilité la recherche.") }}'
                                           class="nav-link"
                                           href="{{route("translatedebug") }}">{!! tt("Activer le mode debug")!!}</a>

                                        {!! Local_content::generatecacheAction() !!}
                                    @endif
                                </li>
                                <li class="nav-item">
                                    <a target="_blank" class="nav-link" href="{{route("admin/")  }}">
                                        {!! tt("Retour à l'administration")  !!}</a>

                                </li>
                                <li class="nav-item">
                                    <label class="nav-item">
                                        <input type="checkbox" onclick="model.locklink(this)" id="chkbox" name="chkbox">
                                        lock link
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dvContentModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="spinner-border spinner-border-sm mr-2" role="status"></span>
                </div>

                <div class="modal-footer">
                    <button id="updatecontent" type="button" onclick="model.updatecontent(this)"
                            class="btn btn-success">
                        <i class="fa fa-check"></i> Update contentjjj
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var $modal = $("#dvContentModalCenter");

        var langs = <?php Genesis::json_encode2(Dvups_lang::all()) ?>;
        model.locklink = function (e) {
            $("form").each(function () {
                var btn = $(this);
                if (e.checked) {
                    // original click handler
                    console.log("link locked")
                    btn.attr("onsubmit", "return false;");
                } else {
                    // original click handler
                    console.log("link unlocked")
                    btn.attr("onsubmit", "return true;");
                }
            })
            $("a").each(function () {
                // your button
                var btn = $(this);
                if (e.checked) {
                    // original click handler
                    console.log("link locked")
                    btn.attr("onclick", "return false;");
                } else {
                    // original click handler
                    console.log("link unlocked")
                    btn.attr("onclick", "return true;");
                }

            });
        };

        model.editcontent = function (el, ref) {

            $modal.find(".modal-title").html(ref);
            bindview("local-content.formWidget?ref=" + ref, "dvContentModalCenter .modal-body")

        };
        model.updatecontent = function (el) {
            console.log("dsdsd", langs)
            for (let l of langs) {
                var id = $("#dvups-id-edit-" + l.iso_code).val();
                var content = $("#dvups-content-edit-" + l.iso_code).val();
                Drequest.api("update.local-content?id=" + id)
                    .data({local_content: {content: content}})
                    .raw((response) => {
                        console.log(response);
                        $.notify("Local content " + l.iso_code + " well updated", "success")
                    });
            }

            $("#dvContentModalCenter").modal("hide")

            /*var iden = $("#dvups-id-edit-en").val();
            var contenten = $("#dvups-content-edit-en").val();
            this._apipost("local-content.update?id="+iden,
                JSON.stringify({local_content:{content: contenten}}),
                (response)=>{
                    console.log(response);
                    $.notify("Local content en well updated", "success")
                })*/
        };
        model.regeneratecache = function () {

            Drequest.init(__env+"admin/api/local-content.regeneratecacheAction").get( (response) => {
                console.log(response);
                window.location.reload();
            })

        }
    </script>
    <!-- Revolution Slider Files Ends Delete if not using slider. -->

    <script>
    </script>
@endif

<script>
    $('#invoicePDF').click(function () {
        var invoice = document.getElementById('invoice');
        var opt = {
            filename: "invoice-promote-2021.pdf",
            image: {type: 'jpeg', quality: 0.98},
            jsPDF: {unit: 'in', format: 'letter', orientation: 'portrait'}
        }
        html2pdf().from(invoice).set(opt).save();
    });

</script>
