@extends('layout')
@section('title', 'List')


@section('cssimport')

@show

@section('content')

    <style>
        textarea {
            resize: vertical;
            /*overflow: auto;*/
        }
        input.form-control{

        }
    </style>

    <div class="row">

        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-3 ">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12 ">
                                    <h5>Manage General info</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-6 col-lg-9 text-right">
                    <button onclick="model.savenodemoduledata()" type="button" class="btn btn-success pull-right" >GenerateModule Lang</button>
                <?php if($admin->getLogin() == "dv_admin" ){ ?>
                        <label class="btn btn-info" onclick="model.convertphparraytojson(this)" >Convert phparray to json</label>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<hr>
    <div class="row">

        <div class="col-lg-12 col-md-12">
        <form onsubmit="return model.saveinfo(this);" >
            <button class="btn btn-success pull-right" >Save</button>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Key
                        <input class="form-control" type="text" id="myInput" onkeyup="filterrow(this)" placeholder="Search for names.." ></th>
                    <th scope="col">En</th>
                    <th scope="col">Fr</th>
                </tr>
                </thead>
                <tbody>
                <?php $admin = getadmin();
                foreach ($info as $key => $value){ ?>
                <tr>
                    <?php if($admin->getLogin() == "dv_admin" ){ ?>
                    <th scope="row">
                        <span class="btn btn-danger" onclick="model.removeline(this)">x</span>
                    </th>
                    <td><input name="key" class="form-control" type="text" placeholder="Key" value="<?= $key ?>" ></td>
                    <?php }else{ ?>
                        <th scope="row"></th>
                        <td><input name="key" readonly class="form-control" type="text" placeholder="Key" value="<?= $key ?>" ></td>
                    <?php } ?>
                    <td><textarea name="en" class="form-control" type="text" placeholder="Value" rows="1" ><?= $value['en'] ?></textarea></td>
                    <td><textarea name="fr" class="form-control" type="text" placeholder="Value" rows="1" ><?= $value['fr'] ?></textarea></td>
                </tr>
                <?php } ?>

                </tbody>
            </table>
            <?php if($admin->getLogin() == "dv_admin" ){ ?>
            <span class="btn btn-success" onclick="model.addline()">add line</span>
            <?php } ?>
            <button class="btn btn-success pull-right" >Save</button>
        </form>
        </div>

    </div>


@endsection


<?php function script(){ ?>

<script src="<?= CLASSJS ?>model.js"></script>
<script src="<?= CLASSJS ?>ddatatable.js"></script>
<script src="<?= Generalinfo::classpath('Ressource/js/generalinfoCtrl.js') ?>"></script>

<?php } ?>
@section('jsimport')
@show 