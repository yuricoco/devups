
@extends('admin.layout')
@section('title', 'New admin')


@section('layout_content')

    <div style="width: 400px; margin: auto"  class="">
        <div class="auto">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Change password <?php echo $detail; ?></h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="index.php?path=dvups_admin/changepassword" >
                        <fieldset>
                            <div class="form-group">
                                <label>Old Password</label>
                                <input class="form-control" placeholder="Old Password" name="oldpwd" type="password" autocomplete="false" value=""  autofocus />
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input class="form-control" placeholder="New Password" name="newpwd" type="password" autocomplete="false"  value="" />
                            </div>

                            <button type="submit" class="btn btn-lg btn-success btn-block">Changer</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection