
@extends('layout.layout')
@section('title', 'New admin')


@section('content')


    <div style="width: 400px; margin: auto" class="loginbox">


        <div class="login-panel panel panel-default">
            <div class="panel-heading">

                <h1>Bonjour, <?= $admin->getName(); ?></h1>
                <p class="account-subtitle">Complete your account credential</p>

                <?php if (isset($error)){ ?>
                <div class="alert alert-warning"><?= $error ?></div>
                <?php } ?>
            </div>
            <div class="panel-body">
                <form role="form" method="post" action="{{$action}}">
                    <fieldset>
                        <div class="form-group">
                            <label>Current Password</label>
                            <input class="form-control" placeholder="Current Password" name="currentpwd" type="password" autocomplete="false" value=""  autofocus />
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input class="form-control" placeholder="New Password" name="newpwd" type="password" autocomplete="false"  value="" />
                        </div>

                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input class="form-control" placeholder="Confirm New Password" name="confimnewpwd" type="password" autocomplete="false"  value="" />
                        </div>

                        <button type="submit" class="btn btn-lg btn-success btn-block">
                            End Creation
                        </button>
                    </fieldset>
                </form>
            </div>
        </div>

    </div>

@endsection