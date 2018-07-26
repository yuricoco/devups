
@extends('layout')
@section('title', 'List')


@section('cssimport')

<style></style>

@show

@section('content')

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> <?php echo CHEMINMODULE; ?>  > Liste 
            </li>
        </ol>
    </div>
    <div class="col-lg-12"> <?= $__navigation ?></div>
</div>
<div class="row">

    <div class="col-lg-12 col-md-12">

        <?=
        Genesis::lazyloadingUI($lazyloading, [
            ['header' => 'Name', 'value' => 'name'],
            ['header' => 'Label', 'value' => 'labelform'],
            ['header' => 'Module', 'value' => 'Dvups_module.name']
        ]);
        ?>

    </div>

</div>

@endsection

@section('jsimport')

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