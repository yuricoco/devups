@extends('layout')
@section('title', 'List')

@section('layout_content')

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-car icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Manage Admin
                    <div class="page-title-subheading">This is an example dashboard created using build-in elements and components.
                    </div>
                </div>
            </div>
            <div class="page-title-actions">

                <?php if(getadmin()->getLogin() == "dv_admin" ){ ?>
                <label class="btn btn-info" onclick="updateprivilege(this)" >Update master admin privilage</label>
                <?php } ?>

            </div>
        </div>
    </div>
    <hr>
    <div class="row">

        <div class="col-lg-12 col-md-12  stretch-card">
            <div class="card">
            <div class="card-body">

                <?= \DClass\devups\Datatable::buildtable($lazyloading, [
                    ['header' => 'nom', 'value' => 'name', 'search' => true],
                    ['header' => 'login', 'value' => 'login'],
                ])
                    ->addcustomaction("callbackbtn")
                    ->render();
                ?>

            </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="dvups_adminmodal" tabindex="-1" role="dialog"
         aria-labelledby="modallabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="title" id="modallabel">Modal Label</h3>
                </div>
                <div class="modal-body panel generalinformation"></div>
                <div class="modal-footer">
                    <button data-dismiss="modal" aria-label="Close" type="button" class="btn btn-danger">Close</button>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('jsimport')

    <script src="<?= CLASSJS ?>model.js"></script>
    <script src="<?= CLASSJS ?>ddatatable.js"></script>

    <script>

        function updateprivilege(el) {
            $(el).html("... processing ")
            $.get(model.baseurl+'?path=dvups_:update', function (response) {
                console.log(response);
                $(el).html(response)
            }, 'text')
        }

    </script>
@show
