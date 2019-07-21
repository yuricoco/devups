@extends('layout')
@section('title', 'List')

@section('layout_content')

    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">

            <?= \DClass\devups\Datatable::buildtable($lazyloading, [
                ['header' => 'Name', 'value' => 'name'],
                ['header' => 'Label', 'value' => 'label', 'get' => 'labelform']
            ])->render(); ?>

        </div>
        </div>
        </div>

    </div>

@endsection

@section('jsimport')

    <script>
        var dom = null;

        function updatelabel(id) {
            var label = $("#input-" + id).val();
            dom.find("span").html(label);
            console.log(id, label);

            $.get("services.php?path=dvups_module.updatelabel&id=" + id, {
                label: label
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
