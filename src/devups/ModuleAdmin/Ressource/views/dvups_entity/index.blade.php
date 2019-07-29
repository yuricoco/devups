
@extends('layout')
@section('title', 'List')


@section('cssimport')

                <style></style>
                
@show

@section('layout_content')

        <div class="row">
                
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <?= Dvups_entityTable::init($lazyloading)
                        ->buildindextable()
                        ->render(); ?>

        </div>
        </div>
        </div>

        </div>

        <div id="dvups_entitybox" class="swal2-container swal2-fade swal2-shown" style="display:none; overflow-y: auto;">
            <div role="dialog" aria-labelledby="swal2-title" aria-describedby="swal2-content" class="swal2-modal swal2-show dv_modal" tabindex="1"
                 style="">
                <div class="main-card mb-3 card  box-container">
                    <div class="card-header">Modal Tile

                        <button onclick="model._dismissmodal()" type="button" class="swal2-close" aria-label="Close this dialog" style="display: block;">×</button>
                    </div>
                    <div class="card-body"></div>
                </div>

            </div>
        </div>

@endsection

@section('jsimport')
        <script src="<?= CLASSJS ?>model.js"></script>
        <script src="<?= CLASSJS ?>ddatatable.js"></script>
                <script>
                    var dom = null;
                    function updatelabel(id) {
                        var label = $("#input-"+id).val();
                        dom.find("span").html(label);
                        console.log(id, label);

                        $.get("services.php?path=dvups_entity.updatelabel&id="+id, {
                            label : label
                        }, function (response) {
                            console.log(response);

                            dom.next().hide();
                            dom.show();
                        });
                    }

                    function cancelupdate() {
                        dom.next().show();
                        dom.hide();
                    }

                    function editlabel($this) {
                        dom = $($this).parent();
                        dom.next().show();
                        dom.hide();
                    }
                </script>
@show
